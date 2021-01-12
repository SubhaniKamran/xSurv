<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\CompanyPackage;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\TransactionHistory;
use App\Models\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use PDF;

class CompanyPackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Company Packages System
    public function DisplayCompanyActivePackage()
    {
        $user_id = Auth::id();
        $active_package = DB::table('company_packages')
                ->where('user_id', $user_id)
                ->where('active_status', 1)
                ->where('deleted_at', null)
                ->get();

        return view('company.package.active', compact('active_package'));
    }

    public function DisplayCompanyRecommendation()
    {
        $user_id = Auth::id();
        $recommendation_package = DB::table('packages')
                ->where('status', 1)
                ->where('deleted_at', null)
                ->get();

        $user = User::find($user_id);

        return view('company.package.recommendation', compact('recommendation_package', 'user'));
    }

    public function PackageCompanyRecommendationStore($package_id)
    {
      $user_id       = Auth::id();
      $from_email    = $_ENV['MAIL_FROM_ADDRESS'];
      $package_id    = $package_id;
      $package_name  = "";
      $package_price = "";
      $package_duration = "";
      $invoice_status = "paid";
      $active_status  = 1;
      $company_name  = "";

      $company_details = DB::table('profiles')
              ->where('id', $user_id)
              ->where('deleted_at', null)
              ->get();

      foreach($company_details as $c_details)
      {
        $company_name = $c_details->full_name;
      }

      $package_details = DB::table('packages')
              ->where('id', $package_id)
              ->where('deleted_at', null)
              ->get();

      foreach($package_details as $package)
      {
        $package_name = $package->package_name;
        $package_price = $package->price;
        $package_duration = $package->duration;
      }

      // First check if user have already taken any package or not
      $customer_packages_detail = DB::table('company_packages')
              ->where('user_id', $user_id)
              ->where('deleted_at', null)
              ->get();

      if(sizeof($customer_packages_detail) > 0){

        $result = $this->sendPayment($package_price, $company_name, $package_name);

        if($result != false)
        {
            $end_date = "";
            $customer_packages_id = "";
            $InvoiceName = $package_name . '-' . rand(100000,9999999) . '.pdf';
            foreach($customer_packages_detail as $c_details)
            {
              $current_date = date('Y-m-d');
              $end_date = $c_details->end_date;
              $date1 = strtotime($current_date);
              $date2 = strtotime($end_date);
              if($date1 > $date2)
              {
                $end_date = $current_date;
              }
              $end_date = Carbon::parse($end_date)->addMonth($package_duration)->format('Y-m-d');
              $customer_packages_id = $c_details->id;
            }
            // Start of Updating Data
            DB::beginTransaction();
            $affected = DB::table('company_packages')
                    ->where('id', $customer_packages_id)
                    ->update([
                      'package_id' => $package_id,
                      'package_name' => $package_name,
                      'package_price' => $package_price,
                      'package_duration' => $package_duration,
                      'end_date' => $end_date,
                      'active_status' => $active_status,
                      'updated_at' => Carbon::now()
                    ]);

            $affected1 = TransactionHistory::create([
              'company_packages_id' => $customer_packages_id,
              'user_id'             => $user_id,
              'transaction_id'      => $result,
              'package_id'          => $package_id,
              'package_name'        => $package_name,
              'package_price'       => $package_price,
              'package_duration'    => $package_duration,
              'amount_paid'         => $package_price,
              'end_date'            => $end_date,
              'invoice'             => $InvoiceName,
              'created_at'          => Carbon::now()
            ]);

            $transaction_history_id = $affected1->id;
            $invoice_result = $this->GeneratePackageInvoice($transaction_history_id, $InvoiceName);

            $AdminEmail = "";
            $CompanyEmail = "";
            $CompanyName = "";

            // Get Admin Email
            $admin_details = DB::table('users')
                ->where('id', 1)
                ->get();

            $AdminEmail = $admin_details[0]->email;

            // Get Company Email and Name
            $company_details = DB::table('users')
                ->where('id', $user_id)
                ->get();

            $CompanyEmail = $company_details[0]->email;

            // Get Company Name
            $profile_details = DB::table('profiles')
                ->where('user_id', $user_id)
                ->get();

            $CompanyName = $profile_details[0]->full_name;

            // Get Logo
            $company_logo = DB::table('general_settings')
                ->where('user_id', 1)
                ->get();

            $logo = $company_logo[0]->logo_url;

            // Set Invoice Location
            $invoice_location = storage_path("app/public/pdf/" . $InvoiceName);

            if($affected && $affected1 && $transaction_history_id){
              DB::commit();

              // SET COMPANY EMAIL CODE HERE - START
                $data = array('to' => $CompanyEmail, 'from' => $from_email, 'packageName' => $package_name, 'company' => $CompanyName, 'logo' => $logo, 'headline' => "Package Updated", 'invoice_location' => $invoice_location, 'status' => 0);
                Mail::send('emails.packageupdate', $data, function($message) use ($data){
                    $message->to($data['to'], 'X-Survey')->subject('Package Update');
                    $message->from($data['from'],'X-Survey');
                    $message->attach($data['invoice_location']);
                });
              // SET EMAIL CODE HERE - END

              // SET ADMIN EMAIL CODE HERE - START
                $data = array('to' => $AdminEmail, 'from' => $from_email, 'packageName' => $package_name, 'company' => $CompanyName, 'logo' => $logo, 'headline' => "Package Updated", 'invoice_location' => $invoice_location, 'status' => 1);
                Mail::send('emails.packageupdate', $data, function($message) use ($data){
                    $message->to($data['to'], 'X-Survey')->subject('Package Update');
                    $message->from($data['from'],'X-Survey');
                    $message->attach($data['invoice_location']);
                });
              // SET EMAIL CODE HERE - END

              /* Admin Notification Setting Check - Start */
              $notification_check = NotificationSetting::select('status')->where('user_id', 1)->first();

              /* Notification Work - Start */
              if($notification_check->status == 1)
              {
                $message = $CompanyName . ", has upgrade " . $package_name . " package";
                $n_affected1 = Notification::create([
                  'message' => $message,
                  'sender_id' => $user_id,
                  'reciever_id' => 1,
                  'created_at' => Carbon::now(),
                ]);
              }

              /* Company Notification Setting Check - Start */
              $notification_check = NotificationSetting::select('status')->where('user_id', $user_id)->first();

              if($notification_check->status == 1)
              {
                $message =  "Your " . $package_name . " package has been upgraded";
                $n_affected2 = Notification::create([
                  'message' => $message,
                  'sender_id' => $user_id,
                  'reciever_id' => $user_id,
                  'created_at' => Carbon::now(),
                ]);
              }
              /* Notification Work - End */


              // Update Expiry Date
              Session::put('ExpiryDate', $end_date);
              return redirect(url('/packages/company/active'))->with('message','Package Updated Successfully');
            }
            else {
              DB::rollback();
              return redirect(url('/packages/company/recommendation'))->with('error','Package Updation Failed');
            }
        }
        else
        {
            return redirect(url('/packages/company/recommendation'))->with('error','Package Updation Failed');
        }
      }
      else {
        $result = $this->sendPayment($package_price, $company_name, $package_name);
        if($result != false)
        {
            // Calculate Start and End Date
            $date = Carbon::now();
            $start_date = $date->format('Y-m-d');
            $end_date = Carbon::now()->addMonth($package_duration);
            $end_date = $end_date->format('Y-m-d');
            $InvoiceName = $package_name . '-' . rand(100000,9999999) . '.pdf';

            // Start of Adding Data
            DB::beginTransaction();
            $affected = CompanyPackage::create([
              'user_id'          => $user_id,
              'package_id'       => $package_id,
              'package_name'     => $package_name,
              'package_price'    => $package_price,
              'package_duration' => $package_duration,
              'start_date'       => $start_date,
              'end_date'         => $end_date,
              'invoice_status'   => $invoice_status,
              'active_status'    => $active_status,
              'created_at'       => Carbon::now()
            ]);

            $affected1 = TransactionHistory::create([
              'company_packages_id' => $affected->id,
              'user_id'             => $user_id,
              'transaction_id'      => $result,
              'package_id'          => $package_id,
              'package_name'        => $package_name,
              'package_price'       => $package_price,
              'package_duration'    => $package_duration,
              'amount_paid'         => $package_price,
              'end_date'            => $end_date,
              'invoice'             => $InvoiceName,
              'created_at'          => Carbon::now()
            ]);

            $transaction_history_id = $affected1->id;
            $invoice_result = $this->GeneratePackageInvoice($transaction_history_id, $InvoiceName);

            $AdminEmail = "";
            $CompanyEmail = "";
            $CompanyName = "";

            // Get Admin Email
            $admin_details = DB::table('users')
                ->where('id', 1)
                ->get();

            $AdminEmail = $admin_details[0]->email;

            // Get Company Email and Name
            $company_details = DB::table('users')
                ->where('id', $user_id)
                ->get();

            $CompanyEmail = $company_details[0]->email;

            // Get Company Name
            $profile_details = DB::table('profiles')
                ->where('user_id', $user_id)
                ->get();

            $CompanyName = $profile_details[0]->full_name;

            // Get Logo
            $company_logo = DB::table('general_settings')
                ->where('user_id', 1)
                ->get();

            $logo = $company_logo[0]->logo_url;

            // Set Invoice Location
            $invoice_location = storage_path("app/public/pdf/" . $InvoiceName);

            if($affected && $affected1 && $invoice_result){
              DB::commit();

              // SET COMPANY EMAIL CODE HERE - START
                $data = array('to' => $CompanyEmail, 'from' => $from_email, 'packageName' => $package_name, 'company' => $CompanyName, 'logo' => $logo, 'headline' => "Package Purchased", 'invoice_location' => $invoice_location, 'status' => 0);
                Mail::send('emails.packagepurchase', $data, function($message) use ($data){
                    $message->to($data['to'], 'X-Survey')->subject('Package Purchase');
                    $message->from($data['from'],'X-Survey');
                    $message->attach($data['invoice_location']);
                });
              // SET EMAIL CODE HERE - END

              // SET ADMIN EMAIL CODE HERE - START
                $data = array('to' => $AdminEmail, 'from' => $from_email, 'packageName' => $package_name, 'company' => $CompanyName, 'logo' => $logo, 'headline' => "Package Purchased", 'invoice_location' => $invoice_location, 'status' => 1);
                Mail::send('emails.packagepurchase', $data, function($message) use ($data){
                    $message->to($data['to'], 'X-Survey')->subject('Package Purchase');
                    $message->from($data['from'],'X-Survey');
                    $message->attach($data['invoice_location']);
                });
              // SET EMAIL CODE HERE - END

              /* Admin Notification Setting Check - Start */
              $notification_check = NotificationSetting::select('status')->where('user_id', 1)->first();

              /* Notification Work - Start */
              if($notification_check->status == 1)
              {
                $message = $CompanyName . ", has purchased " . $package_name . " package";
                $n_affected1 = Notification::create([
                  'message' => $message,
                  'sender_id' => $user_id,
                  'reciever_id' => 1,
                  'created_at' => Carbon::now(),
                ]);
              }

              /* Company Notification Setting Check - Start */
              $notification_check = NotificationSetting::select('status')->where('user_id', $user_id)->first();
              if($notification_check->status == 1)
              {
                $message =  "Your " . $package_name . " package has been activated";
                $n_affected2 = Notification::create([
                  'message' => $message,
                  'sender_id' => $user_id,
                  'reciever_id' => $user_id,
                  'created_at' => Carbon::now(),
                ]);
              }
              /* Notification Work - End */

              // Update Expiry Date
              Session::put('ExpiryDate', $end_date);
              return redirect(url('/packages/company/active'))->with('message','Package Activates Successfully');
            }
            else {
              DB::rollback();
              return redirect(url('/packages/company/recommendation'))->with('error','Package Activation Failed');
            }
        }
        else
        {
            return redirect(url('/packages/company/recommendation'))->with('error','Package Activation Failed');
        }
      }
    }

    // Stripe Payment Entry Code - Start
    public function sendPayment($amount, $company_name, $package_name)
    {
        if (auth()->user()->stripe_card_id) {
            $charge = Stripe::charges()->create([
                'customer' => auth()->user()->stripe_customer_id,
                'currency' => 'USD',
                'amount'   => $amount,
            ]);
            return $charge['id'];
            // $paymentTransaction = new PaymentTransaction;
            // $paymentTransaction->user_id = auth()->user()->id;
            // $paymentTransaction->transaction_id = $charge['id'];
            // $paymentTransaction->amount = $amount;
            // if ($paymentTransaction->save()) {
            //         $payment =new PackagePurchase;
            //         $payment->user_id = auth()->user()->id;
            //         $payment->status = 'paid';
            //         $payment->amount_received = $amount;
            //         $payment->company_name = $company_name;
            //         $payment->package_name = $package_name;
            //         $payment->end_date = date('Y-m-d');
            //         $payment->paid_at = date('Y-m-d H:i:s');
            //         if ($payment->save()) {
            //             return redirect()->back()->with('message', 'Credit paid successfully.');
            //         }
            // }
        } else {
            return false;
            // return redirect()->back()->withErrors("Please enter your Debit/Credit Card detials first.");
        }
    }
    // Stripe Payment Entry Code - End


    public function DisplayCompanyHistoryInvoice()
    {
      return view('company.package.history');
    }

    public function DisplayCompanyPackagesHistory(Request $request)
    {
      $user_id = Auth::id();
      $limit = $request->post('length');
      $start = $request->post('start');
      $searchTerm = $request->post('search')['value'];

      $fetch_data = null;
      $recordsTotal = null;
      $recordsFiltered = null;
      if ($searchTerm == '') {
          $fetch_data = DB::table('transaction_histories')
              ->where('transaction_histories.user_id', '=', $user_id)
              ->where('transaction_histories.deleted_at', '=', null)
              ->select('transaction_histories.*')
              ->offset($start)
              ->limit($limit)
              ->get();
          $recordsTotal = sizeof($fetch_data);
          $recordsFiltered = DB::table('transaction_histories')
              ->where('transaction_histories.user_id', '=', $user_id)
              ->where('transaction_histories.deleted_at', '=', null)
              ->select('transaction_histories.*')
              ->count();
      } else {
          $fetch_data = DB::table('transaction_histories')
              ->where(function($query){
                $query->where([
                  ['transaction_histories.user_id', '=', $user_id],
                  ['transaction_histories.deleted_at', '=', null]
                ]);
              })
              ->where(function($query) use($searchTerm) {
                $query->orWhere('transaction_histories.package_name', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('transaction_histories.package_price', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('transaction_histories.package_duration', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('transaction_histories.end_date', 'LIKE', '%' . $searchTerm . '%');
              })
              ->select('transaction_histories.*')
              ->offset($start)
              ->limit($limit)
              ->get();
          $recordsTotal = sizeof($fetch_data);
          $recordsFiltered = DB::table('transaction_histories')
              ->where(function($query){
                $query->where([
                  ['transaction_histories.user_id', '=', $user_id],
                  ['transaction_histories.deleted_at', '=', null]
                ]);
              })
              ->where(function($query) use($searchTerm) {
                $query->orWhere('transaction_histories.package_name', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('transaction_histories.package_price', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('transaction_histories.package_duration', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('transaction_histories.end_date', 'LIKE', '%' . $searchTerm . '%');
              })
              ->select('transaction_histories.*')
              ->count();
      }

      $data = array();
      $SrNo = $start + 1;
      foreach ($fetch_data as $row => $item) {
          $sub_array = array();
          $sub_array[] = $SrNo;
          $sub_array[] = $item->package_name;
          $sub_array[] = "$" . $item->package_price;
          $sub_array[] = $item->package_duration;
          $sub_array[] = $item->end_date;
          $sub_array[] = "$" . $item->amount_paid;
          $sub_array[] = '<button class="btn btn-info mr-2" id="' . $item->id . '" onclick="viewCompanyPackageInvoice(this.id);"><i class="ti-eye"></i></button>';
          $SrNo++;
          $data[] = $sub_array;
      }

      $json_data = array(
          "draw" => intval($request->post('draw')),
          "recordsTotal" => $recordsTotal,
          "recordsFiltered" => $recordsFiltered,
          "data" => $data
      );

      echo json_encode($json_data);
    }

    public function GenerateCompanyPackageInvoice(Request $request)
    {
      $user_id = Auth::id();
      $TransactionHistoryId = $request->post('TransactionId');
      $data = DB::table('transaction_histories')
            ->where('transaction_histories.id', '=', $TransactionHistoryId)
            ->where('transaction_histories.deleted_at', '=', null)
            ->get();

      $profile_data = DB::table('profiles')
            ->where('profiles.user_id', '=', $user_id)
            ->where('profiles.deleted_at', '=', null)
            ->get();

      $company_name = $profile_data[0]->full_name;

      // Get Logo
      $company_logo = DB::table('general_settings')
          ->where('user_id', 1)
          ->get();

      $logo = $company_logo[0]->logo_url;

      $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'font_height_ratio' => 0.75])
            ->loadView('company.package.invoice', compact('data', 'company_name', 'logo'));

      $invoice_name = $data[0]->invoice;
      return $pdf->download($invoice_name);
    }

    // Generate PDF Invoice and save it in a folder
    public function GeneratePackageInvoice($TransactionHistoryId, $InvoiceName)
    {
      $user_id = Auth::id();
      $data = DB::table('transaction_histories')
            ->where('transaction_histories.id', '=', $TransactionHistoryId)
            ->where('transaction_histories.deleted_at', '=', null)
            ->get();

      $profile_data = DB::table('profiles')
            ->where('profiles.user_id', '=', $user_id)
            ->where('profiles.deleted_at', '=', null)
            ->get();

      $company_name = $profile_data[0]->full_name;

      // Get Logo
      $company_logo = DB::table('general_settings')
          ->where('user_id', 1)
          ->get();

      $logo = $company_logo[0]->logo_url;

      $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'font_height_ratio' => 0.75])
            ->loadView('company.package.invoice', compact('data', 'company_name', 'logo'));

      $result = Storage::put('public/pdf/' . $InvoiceName, $pdf->output());
      if($result){
        return 1;
      }
      else {
        return 0;
      }
    }
}

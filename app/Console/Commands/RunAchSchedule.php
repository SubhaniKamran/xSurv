<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CustomerServices;
use App\Models\Notification;
use App\Models\NotificationSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduleMail;
use App\Mail\PackageExpire;
use App\Mail\PackageExpired;
use Carbon\Carbon;

class RunAchSchedule extends Command
{
    protected $signature = 'run:ach';

    protected $description = 'Survey Email';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
      $this->SendSurveyEmails();
      $this->SendPackageExpiryEmail();
      $this->SendPackageExpiredEmail();
    }

    public function SendSurveyEmails()
    {
      // Send email to those whose email date is less than current date and email status is pending and reaction is null
      $customer_services_record = DB::table('customer_services')
          ->join('customers', 'customers.id', '=', 'customer_services.customer_id')
          ->join('services', 'services.id', '=', 'customer_services.service_id')
          ->where([
              ['customer_services.reaction_status', '=', null],
              ['customer_services.service_date', '<=', date('Y-m-d')],
              ['customer_services.deleted_at', '=', null],
              ['customers.status', '=', 1],
          ])
          ->select('customer_services.id As customer_services_id', 'customer_services.user_id As company_id', 'customer_services.service_date As service_date', 'customers.email As email', 'customers.client_name As name', 'services.service_name As service_name')
          ->get();

      if(count($customer_services_record) > 0)
      {
        foreach($customer_services_record as $record)
        {
            $email = $record->email;
            $service_date = $record->service_date;
            $company_id = $record->company_id;
            $currentdate = Carbon::now()->toDateString();
            $EmailDate1 = "";
            $EmailDate2 = "";
            $EmailDate3 = "";
            $EmailDate4 = "";
            $date1 = "";
            $date2 = "";
            $date3 = "";
            $date4 = "";

            // GET Company Schedule Dates Data
            $company_dates_setting = DB::table('company_dates')
                                    ->where('user_id', $company_id)
                                    ->get();

            foreach($company_dates_setting as $datesSetting)
            {
              $EmailDate1 = $datesSetting->date1;
              $EmailDate2 = $datesSetting->date2;
              $EmailDate3 = $datesSetting->date3;
              $EmailDate4 = $datesSetting->date4;
            }

            if($EmailDate1 != "")
            {
              $date1 = Carbon::parse($service_date)->addDay($EmailDate1)->toDateString();
              if($EmailDate2 != "")
              {
                $date2 = Carbon::parse($date1)->addDay($EmailDate2)->toDateString();
                if($EmailDate3 != "")
                {
                  $date3 = Carbon::parse($date2)->addDay($EmailDate3)->toDateString();
                  if($EmailDate4 != "")
                  {
                    $date4 = Carbon::parse($date3)->addDay($EmailDate4)->toDateString();
                  }
                }
              }
            }
            
            if($currentdate == $date1)
            {
              $customer_services_id = $record->customer_services_id;
              $survey_url = "/reaction/view/". $record->service_name . "/" . base64_encode($record->customer_services_id);
              $details = [
                  "title" => "Customer Service Survey",
                  "to" => $record->email,
                  "name" => $record->name,
                  "service" => $record->service_name,
                  "survey_url" => $survey_url
              ];
              Mail::to($email)->send(new ScheduleMail($details));
              DB::table('customer_services')
                    ->where('id', $customer_services_id)
                    ->update([
                        'email_status' => 'sent',
                        'updated_at' => Carbon::now()
                    ]);
            }
            elseif ($currentdate == $date2)
            {
              $customer_services_id = $record->customer_services_id;
              $survey_url = "/reaction/view/". $record->service_name . "/" . base64_encode($record->customer_services_id);
              $details = [
                  "title" => "Customer Service Survey",
                  "to" => $record->email,
                  "name" => $record->name,
                  "service" => $record->service_name,
                  "survey_url" => $survey_url
              ];
              Mail::to($email)->send(new ScheduleMail($details));
              DB::table('customer_services')
                    ->where('id', $customer_services_id)
                    ->update([
                        'email_status' => 'sent',
                        'updated_at' => Carbon::now()
                    ]);
            }
            elseif ($currentdate == $date3)
            {
              $customer_services_id = $record->customer_services_id;
              $survey_url = "/reaction/view/". $record->service_name . "/" . base64_encode($record->customer_services_id);
              $details = [
                  "title" => "Customer Service Survey",
                  "to" => $record->email,
                  "name" => $record->name,
                  "service" => $record->service_name,
                  "survey_url" => $survey_url
              ];
              Mail::to($email)->send(new ScheduleMail($details));
              DB::table('customer_services')
                    ->where('id', $customer_services_id)
                    ->update([
                        'email_status' => 'sent',
                        'updated_at' => Carbon::now()
                    ]);
            }
            elseif ($currentdate == $date4)
            {
              $customer_services_id = $record->customer_services_id;
              $survey_url = "/reaction/view/". $record->service_name . "/" . base64_encode($record->customer_services_id);
              $details = [
                  "title" => "Customer Service Survey",
                  "to" => $record->email,
                  "name" => $record->name,
                  "service" => $record->service_name,
                  "survey_url" => $survey_url
              ];
              Mail::to($email)->send(new ScheduleMail($details));
              DB::table('customer_services')
                    ->where('id', $customer_services_id)
                    ->update([
                        'email_status' => 'sent',
                        'updated_at' => Carbon::now()
                    ]);
            }
          }
      }
      else
      {
        // echo "No record found";
      }
    }

    // Email Notification of Package Expiry 5 days Before
    public function SendPackageExpiryEmail()
    {
      // Get Company Logo
      $logo_details = DB::table('general_settings')
                              ->get();

      $logo = $logo_details[0]->logo_url;

      // Get Admin Email
      $admin_details = DB::table('users')
                    ->where('users.id', 1)
                    ->get();

      $admin_email = $admin_details[0]->email;

      // Send email to those whose package will expire after 5 days
      $customer_package_record = DB::table('company_packages')
                              ->join('users', 'users.id', '=', 'company_packages.user_id')
                              ->join('profiles', 'profiles.user_id', '=', 'company_packages.user_id')
                              ->select('company_packages.user_id As companyid', 'company_packages.id As customer_package_id', 'company_packages.package_name As package_name', 'company_packages.end_date As end_date', 'users.email As email', 'profiles.full_name As company_name')
                              ->get();

      foreach($customer_package_record as $record)
      {
        $package_end_date = $record->end_date;
        $currentdate = Carbon::now();
        $end_date = Carbon::parse($package_end_date);
        if($end_date <= $currentdate)
        {
          $remaining_days = $end_date->diffInDays($currentdate);
          $email = $record->email;

          if($remaining_days >= 0 && $remaining_days <= 5){
            $details = [];
            // Start of Company Email
            if($remaining_days == 1)
            {
              $details = [
                "title" => "Package Expire Alert!",
                "note"  => "Your " . $record->package_name . " package, will expire after " . $remaining_days ." day. Please renew your package. Thanks!",
                "logo"  => $logo
              ];
              $message = $record->package_name . " package will expire after " . $remaining_days ." day.";
            }
            elseif($remaining_days == 0)
            {
              $details = [
              "title" => "Package Expire Alert!",
              "note"  => "Your " . $record->package_name . " package, will expire after a few hours. Please renew your package. Thanks!",
              "logo"  => $logo
              ];
              $message = $record->package_name . " package will expire after a few hours.";
            }
            else{
              $details = [
                "title" => "Package Expire Alert!",
                "note"  => "Your " . $record->package_name . " package, will expire after " . $remaining_days ." days. Please renew your package. Thanks!",
                "logo"  => $logo
              ];
              $message = $record->package_name . " package will expire after " . $remaining_days ." days.";
            }

            Mail::to($email)->send(new PackageExpire($details));

            /* Company Notification Setting Check - Start */
            $notification_check = NotificationSetting::select('status')->where('user_id', $record->companyid)->first();

            // Send notification to company
            if($notification_check->status == 1)
            {
              Notification::create([
                'message' => $message,
                'sender_id' => 1,
                'reciever_id' => $record->companyid,
                'created_at' => Carbon::now(),
              ]);
            }

            // Start of Admin Email
            if($remaining_days == 1)
            {
              $details = [
              "title" => "Package Expire Alert!",
              "note"  => $record->company_name . " " . $record->package_name . " package, will expire after " . $remaining_days . " day.",
              "logo"  => $logo
              ];
              $message = $record->company_name . ", package will expire after " . $remaining_days . " day.";
            }
            elseif($remaining_days == 0)
            {
              $details = [
              "title" => "Package Expire Alert!",
              "note"  => $record->company_name . " " . $record->package_name . " package, will expire after a few hours.",
              "logo"  => $logo
              ];
              $message = $record->company_name . ", package will expire after a few hours days.";
            }
            else
            {
            $details = [
            "title" => "Package Expire Alert!",
            "note"  => $record->company_name . " " . $record->package_name . " package, will expire after " . $remaining_days . " days.",
            "logo"  => $logo
            ];
            $message = $record->company_name . ", package will expire after " . $remaining_days . " days.";
            }

            // Put Admin Email here
            Mail::to($admin_email)->send(new PackageExpire($details));

            /* Admin Notification Setting Check - Start */
            $notification_check = NotificationSetting::select('status')->where('user_id', 1)->first();

            // Send notification to Admin
            if($notification_check->status == 1)
            {
              Notification::create([
                'message' => $message,
                'sender_id' => 1,
                'reciever_id' => 1,
                'created_at' => Carbon::now(),
              ]);
            }
          }
        }
      }
    }

    // Email Notification of Package Expired
    public function SendPackageExpiredEmail()
    {
      // Get Company Logo
      $logo_details = DB::table('general_settings')
                    ->get();

      $logo = $logo_details[0]->logo_url;

      // Get Admin Email
      $admin_details = DB::table('users')
                    ->where('users.id', 1)
                    ->get();

      $admin_email = $admin_details[0]->email;

      // Send email to those whose package is expired
      $customer_package_record = DB::table('company_packages')
                            ->join('users', 'users.id', '=', 'company_packages.user_id')
                            ->join('profiles', 'profiles.user_id', '=', 'company_packages.user_id')
                            ->select('company_packages.user_id As companyid', 'company_packages.id As customer_package_id', 'company_packages.package_name As package_name', 'company_packages.end_date As end_date', 'company_packages.active_status As active_status', 'users.email As    email', 'profiles.full_name As company_name')
                            ->get();

      foreach($customer_package_record as $record)
      {
        $package_end_date = $record->end_date;
        $currentdate = Carbon::now();
        $end_date = Carbon::parse($package_end_date);
        $email = $record->email;

        if($end_date > $currentdate && $record->active_status == 1){

          $today = date('Y-m-d');
          $today = strtotime($today);
          $last_date = strtotime($package_end_date);
          $remaining_days = ($today - $last_date)/60/60/24;

          if($remaining_days == -1)
          {
            // Start of Company Email
            $details = [
              "title" => "Package Expired Alert!",
              "note"  => "Your " . $record->package_name . " package, has been expired. Please renew your package. Thanks!",
              "logo"  => $logo
            ];
            Mail::to($email)->send(new PackageExpired($details));

            /* Company Notification Setting Check - Start */
            $notification_check = NotificationSetting::select('status')->where('user_id', $record->companyid)->first();

            // Send notification to company
            if($notification_check->status == 1)
            {
              $message = $record->package_name . " package has been expired.";
              Notification::create([
                'message' => $message,
                'sender_id' => 1,
                'reciever_id' => $record->companyid,
                'created_at' => Carbon::now(),
              ]);
            }

            // Start of Admin Email
            $details = [
                "title" => "Package Expire Alert!",
                "note"  => $record->company_name . " " . $record->package_name . " package has been expired.",
                "logo"  => $logo
            ];
            // Put Admin Email here
            Mail::to($admin_email)->send(new PackageExpired($details));

            /* Admin Notification Setting Check - Start */
            $notification_check = NotificationSetting::select('status')->where('user_id', 1)->first();

            // Send notification to Admin
            if($notification_check->status == 1)
            {
              $message = $record->company_name . ", package has been expired.";
              Notification::create([
                'message' => $message,
                'sender_id' => 1,
                'reciever_id' => 1,
                'created_at' => Carbon::now(),
              ]);
            }

            DB::table('company_packages')
                ->where('id', $record->customer_package_id)
                ->update([
                    'active_status' => 0,
                    'updated_at' => Carbon::now()
                ]);
          }
        }
      }
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\CustomerServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class EmailsManagementController extends Controller
{
  // Email Management Scheduling System - Start

  public function DisplayScheduleEmails()
  {
    $user_id = Auth::id();
    $CompanyEmailDates = DB::table('company_dates')
                ->where('user_id', $user_id)
                ->get();

    $email_date1 = "";
    $email_date2 = "";
    $email_date3 = "";
    $email_date4 = "";

    foreach($CompanyEmailDates as $EmailDates)
    {
      $email_date1 = $EmailDates->date1;
      $email_date2 = $EmailDates->date2;
      $email_date3 = $EmailDates->date3;
      $email_date4 = $EmailDates->date4;
    }

    return view('company.emails.scheduling', compact('email_date1', 'email_date2', 'email_date3', 'email_date4'));
  }

  public function AllScheduleEmails(Request $request)
  {
      $user_id = Auth::id();
      $limit = $request->post('length');
      $start = $request->post('start');
      $searchTerm = $request->post('search')['value'];

      $fetch_data = null;
      $recordsTotal = null;
      $recordsFiltered = null;
      if ($searchTerm == '') {
          $fetch_data = DB::table('customers')
                      ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                      ->join('services', 'services.id', '=', 'customer_services.service_id')
                      ->where('customers.user_id', $user_id)
                      ->where('customers.status', 1)
                      ->where('customers.deleted_at', null)
                      ->where('customer_services.user_id', $user_id)
                      ->where('customer_services.reaction_status', null)
                      ->where('services.user_id', $user_id)
                      ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
              ->offset($start)
              ->limit($limit)
              ->get();
          $recordsTotal = sizeof($fetch_data);
          $recordsFiltered = DB::table('customers')
                      ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                      ->join('services', 'services.id', '=', 'customer_services.service_id')
                      ->where('customers.user_id', $user_id)
                      ->where('customers.status', 1)
                      ->where('customers.deleted_at', null)
                      ->where('customer_services.user_id', $user_id)
                      ->where('customer_services.reaction_status', null)
                      ->where('services.user_id', $user_id)
                      ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
              ->count();
      } else {
          $fetch_data = DB::table('customers')
                      ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                      ->join('services', 'services.id', '=', 'customer_services.service_id')
                      ->where(function($query) use($user_id){
                        $query->where([
                          ['customers.user_id', '=', $user_id],
                          ['customers.status', '=', 1],
                          ['customers.deleted_at', '=', null],
                          ['customer_services.user_id', '=', $user_id],
                          ['customer_services.reaction_status', '=', null],
                          ['services.user_id', '=', $user_id]
                        ]);
                      })
                      ->where(function($query) use($searchTerm) {
                        $query->orWhere('customers.client_name', 'LIKE', '%' . $searchTerm . '%');
                        $query->orWhere('customers.email', 'LIKE', '%' . $searchTerm . '%');
                        $query->orWhere('customer_services.email_date', 'LIKE', '%' . $searchTerm . '%');
                        $query->orWhere('customer_services.email_status', 'LIKE', '%' . $searchTerm . '%');
                        $query->orWhere('customer_services.reaction_status', 'LIKE', '%' . $searchTerm . '%');
                        $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
                      })
                ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
              ->offset($start)
              ->limit($limit)
              ->get();
          $recordsTotal = sizeof($fetch_data);
          $recordsFiltered = DB::table('customers')
                      ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                      ->join('services', 'services.id', '=', 'customer_services.service_id')
                      ->where(function($query) use($user_id){
                        $query->where([
                          ['customers.user_id', '=', $user_id],
                          ['customers.status', '=', 1],
                          ['customers.deleted_at', '=', null],
                          ['customer_services.user_id', '=', $user_id],
                          ['customer_services.reaction_status', '=', null],
                          ['services.user_id', '=', $user_id]
                        ]);
                      })
                      ->where(function($query) use($searchTerm) {
                        $query->orWhere('customers.client_name', 'LIKE', '%' . $searchTerm . '%');
                        $query->orWhere('customers.email', 'LIKE', '%' . $searchTerm . '%');
                        $query->orWhere('customer_services.email_date', 'LIKE', '%' . $searchTerm . '%');
                        $query->orWhere('customer_services.email_status', 'LIKE', '%' . $searchTerm . '%');
                        $query->orWhere('customer_services.reaction_status', 'LIKE', '%' . $searchTerm . '%');
                        $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
                      })
                ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
              ->count();
      }

      $data = array();
      $SrNo = $start + 1;
      $status = ""; $active_ban = "";
      foreach ($fetch_data as $row => $item) {
        $reaction_status = "pending";
        if(!empty($item->reaction_status)){
          $reaction_status = $item->reaction_status;
        }
        $sub_array = array();
        $sub_array[] = $SrNo;
        $sub_array[] = $item->client_name;
        $sub_array[] = $item->email;
        $sub_array[] = $item->service_name;
        $sub_array[] = $item->email_status;
        $sub_array[] = $reaction_status;
        $sub_array[] = '<button class="btn btn-info mr-2" id="survey_' . $item->customer_service_id . '" onclick="ViewCustomerSurvey(this.id);"><i class="ti-eye"></i></button>';
        // $sub_array[] = $item->email_date;
        // $sub_array[] = '<button class="btn btn-info mr-2" id="edit_' . $item->customer_service_id .'" onclick="editCustomerServiceEmailDate(this.id);"><i class="ti-pencil-alt"></i></button>';
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

  public function UpdateScheduleEmails(Request $request){
    $CustomerServiceId = $request->post('CustomerServiceId');
    $EmailDate = $request->post('EmailDate');
    DB::beginTransaction();
    $affected = DB::table('customer_services')
                ->where('id', $CustomerServiceId)
                ->update([
                    'email_date' => $EmailDate,
                    'updated_at' => Carbon::now()
                ]);
    if ($affected) {
      DB::commit();
      echo "Success";
    }
    else {
      DB::rollback();
      echo "Error";
    }
  }

  public function UpdateAllScheduleEmails(Request $request){
    $user_id = Auth::id();
    $EmailDate1 = null;
    $EmailDate2 = null;
    $EmailDate3 = null;
    $EmailDate4 = null;

    $EmailDate1 = $request->post('email_date1');
    if($EmailDate1 != "")
    {
      $EmailDate2 = $request->post('email_date2');
      if($EmailDate2 != "")
      {
        $EmailDate3 = $request->post('email_date3');
        if($EmailDate3 != "")
        {
          $EmailDate4 = $request->post('email_date4');
        }
      }
    }
    DB::beginTransaction();
    $affected = DB::table('company_dates')
                ->where('user_id', $user_id)
                ->update([
                    'date1' => $EmailDate1,
                    'date2' => $EmailDate2,
                    'date3' => $EmailDate3,
                    'date4' => $EmailDate4,
                    'updated_at' => Carbon::now()
                ]);
    if ($affected) {
      DB::commit();
      return redirect(url('/scheduling/view'))->with('message','Emails Schedule Updated Successfully');
    }
    else {
      DB::rollback();
      return redirect(url('/scheduling/view'))->with('error','Error! An unhandled error exception');
    }
  }

  // public function UpdateAllScheduleEmails(Request $request){
  //   $user_id = Auth::id();
  //   $EmailDate = $request->post('email_date');
  //   DB::beginTransaction();
  //   $affected = DB::table('customer_services')
  //               ->where('user_id', $user_id)
  //               ->where('reaction_status', null)
  //               ->update([
  //                   'email_date' => $EmailDate,
  //                   'updated_at' => Carbon::now()
  //               ]);
  //   if ($affected) {
  //     DB::commit();
  //     return redirect(url('/scheduling/view'))->with('message','Emails Schedule Updated Successfully');
  //   }
  //   else {
  //     DB::rollback();
  //     return redirect(url('/scheduling/view'))->with('error','Error! An unhandled error exception');
  //   }
  // }
  // Email Management Scheduling System - End

  // Survey Email Management - Start
  public function DisplayReactionPage($service, $customer_services_id)
  {
      $CustomerServiceId = base64_decode($customer_services_id);
      $customer_services_data = DB::table('customer_services')
                        ->where('id', $CustomerServiceId)
                        ->get();
      if($customer_services_data != "") {
        $reaction_status = $customer_services_data[0]->reaction_status;
        if($reaction_status == ""){
            return view('emails.reactionform', compact('service', 'CustomerServiceId'));
        }
        else{
            // Cal view which display, you have already filled this survey
            return view('emails.alreadyfilledsurvey');
        }
      }
      else{
        echo "URL is incorrect";
      }
  }

  public function DisplaySurveyForm($service, $customerServiceId, $reaction)
  {
      $service = $service;
      $customerServiceId = base64_decode($customerServiceId);
      $reaction = base64_decode($reaction);

      $customer_services_record = DB::table('customer_services')
                        ->where('id', $customerServiceId)
                        ->get();

      if($customer_services_record != "")
      {
        $customer_services_data = DB::table('customer_services')
                        ->where('id', $customerServiceId)
                        ->where('reaction_status', null)
                        ->where('survey_answer', null)
                        ->count();
        if($customer_services_data > 0){
             DB::beginTransaction();
             // Check the reaction type
             if($reaction == "happy")
             {
                 // Update Reaction Status
                 $affected = DB::table('customer_services')
                       ->where('id', $customerServiceId)
                       ->update([
                           'reaction_status' => $reaction,
                           'updated_at' => Carbon::now()
                       ]);

                 if($affected){
                   DB::commit();

                   // Ban this customer
                   $customer_id = $customer_services_record[0]->customer_id;
                   DB::table('customers')
                           ->where('id', $customer_id)
                           ->update([
                               'status' => 0,
                               'updated_at' => Carbon::now()
                           ]);

                   $company_id = $customer_services_record[0]->user_id;
                   $company_google_review = DB::table('google_reviews')
                          ->where('user_id', $company_id)
                          ->get();
                   if($company_google_review != ""){
                      $google_review_link = $company_google_review[0]->google_url;
                      return Redirect::to($google_review_link);
                   }
                 }
                 else {
                   DB::rollback();
                 }
             }
             elseif($reaction == "sad" || $reaction == "neutral")
             {
                $survey_questions = $customer_services_record[0]->survey_question;
                // Cal view which display survey template questions
                return view('emails.surveyquestions', compact('service', 'customerServiceId', 'survey_questions', 'reaction'));
             }
        }
        else{
            // Cal view which display, you have already filled this survey
            return view('emails.alreadyfilledsurvey');
        }
      }
      else
      {
        echo "URL is incorrect";
      }
  }

  public function StoreSurveyResults(Request $request)
  {
      $service = $request->post('service');
      $customerServiceId = $request->post('customer_service_id');
      $reaction_status = $request->post('reaction_status');
      $answers = json_encode($request->post('answers'));

      DB::beginTransaction();
      $affected = DB::table('customer_services')
            ->where('id', $customerServiceId)
            ->update([
                'reaction_status' => $reaction_status,
                'updated_at' => Carbon::now()
            ]);

      $affected1 = DB::table('customer_services')
            ->where('id', $customerServiceId)
            ->update([
                'survey_answer' => $answers,
                'updated_at' => Carbon::now()
            ]);
     if($affected && $affected1){
        DB::commit();
        return view('emails.appreciatefeedback');
     }
     else{
        DB::rollback();
        echo "Error!";
     }
  }
  // Survey Email Management - End

  // Email Management Pending Report - Start
  public function DisplayPendingEmails()
  {
    return view('company.emails.pending');
  }

  public function AllPendingEmails(Request $request)
  {
    $user_id = Auth::id();
    $pending_status = "pending";
    $limit = $request->post('length');
    $start = $request->post('start');
    $searchTerm = $request->post('search')['value'];

    $fetch_data = null;
    $recordsTotal = null;
    $recordsFiltered = null;
    if ($searchTerm == '') {
        $fetch_data = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where('customers.user_id', $user_id)
                    ->where('customers.status', 1)
                    ->where('customers.deleted_at', null)
                    ->where('customer_services.user_id', $user_id)
                    ->where('customer_services.email_status', $pending_status)
                    ->where('customer_services.reaction_status', null)
                    ->where('services.user_id', $user_id)
                    ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
            ->offset($start)
            ->limit($limit)
            ->get();
        $recordsTotal = sizeof($fetch_data);
        $recordsFiltered = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where('customers.user_id', $user_id)
                    ->where('customers.status', 1)
                    ->where('customers.deleted_at', null)
                    ->where('customer_services.user_id', $user_id)
                    ->where('customer_services.email_status', $pending_status)
                    ->where('customer_services.reaction_status', null)
                    ->where('services.user_id', $user_id)
                    ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
            ->count();
    } else {
        $fetch_data = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where(function($query) use($user_id, $pending_status){
                      $query->where([
                        ['customers.user_id', '=', $user_id],
                        ['customers.status', '=', 1],
                        ['customers.deleted_at', '=', null],
                        ['customer_services.user_id', '=', $user_id],
                        ['customer_services.email_status', '=', $pending_status],
                        ['customer_services.reaction_status', '=', null],
                        ['services.user_id', '=', $user_id]
                      ]);
                    })
                    ->where(function($query) use($searchTerm) {
                      $query->orWhere('customers.client_name', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customers.email', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_date', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.reaction_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
                    })
              ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
            ->offset($start)
            ->limit($limit)
            ->get();
        $recordsTotal = sizeof($fetch_data);
        $recordsFiltered = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where(function($query) use($user_id, $pending_status){
                      $query->where([
                        ['customers.user_id', '=', $user_id],
                        ['customers.status', '=', 1],
                        ['customers.deleted_at', '=', null],
                        ['customer_services.user_id', '=', $user_id],
                        ['customer_services.email_status', '=', $pending_status],
                        ['customer_services.reaction_status', '=', null],
                        ['services.user_id', '=', $user_id]
                      ]);
                    })
                    ->where(function($query) use($searchTerm) {
                      $query->orWhere('customers.client_name', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customers.email', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_date', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.reaction_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
                    })
              ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
            ->count();
    }

    $data = array();
    $SrNo = $start + 1;
    $status = ""; $active_ban = "";
    $EmailDate1 = ""; $EmailDate2 = ""; $EmailDate3 = ""; $EmailDate4 = "";
    $date1 = ""; $date2 = ""; $date3 = ""; $date4 = "";
    foreach ($fetch_data as $row => $item) {
      $reaction_status = "pending";
      if(!empty($item->reaction_status)){
        $reaction_status = $item->reaction_status;
      }
      // Get Email Dates
      $service_date = $item->service_date;
      $company_id = $item->company_id;
      $CompanyEmailDatesSetting = $this->EmailDates($company_id);
      foreach($CompanyEmailDatesSetting as $emaildates)
      {
        $EmailDate1 = $emaildates->date1;
        $EmailDate2 = $emaildates->date2;
        $EmailDate3 = $emaildates->date3;
        $EmailDate4 = $emaildates->date4;
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

      $sub_array = array();
      $sub_array[] = $SrNo;
      $sub_array[] = $item->client_name;
      $sub_array[] = $item->service_name;
      $sub_array[] = $item->email_status;
      $sub_array[] = $reaction_status;
      $sub_array[] = '<button class="btn btn-info mr-2" id="survey_' . $item->customer_service_id . '" onclick="ViewCustomerSurvey(this.id);"><i class="ti-eye"></i></button>';
      $sub_array[] = $item->service_date;
      $sub_array[] = $date1;
      $sub_array[] = $date2;
      $sub_array[] = $date3;
      $sub_array[] = $date4;
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
  // Email Management Pending Report - End

  public function EmailDates($company_id)
  {
    $company_dates_setting = DB::table('company_dates')
                            ->where('user_id', $company_id)
                            ->get();

    return $company_dates_setting;
  }


  // Email Management Sent Report - Start
  public function DisplaySentEmails()
  {
    return view('company.emails.sent');
  }

  public function AllSentEmails(Request $request)
  {
    $user_id = Auth::id();
    $sent_status = "sent";
    $limit = $request->post('length');
    $start = $request->post('start');
    $searchTerm = $request->post('search')['value'];

    $fetch_data = null;
    $recordsTotal = null;
    $recordsFiltered = null;
    if ($searchTerm == '') {
        $fetch_data = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where('customers.user_id', $user_id)
                    ->where('customers.status', 1)
                    ->where('customers.deleted_at', null)
                    ->where('customer_services.user_id', $user_id)
                    ->where('customer_services.email_status', $sent_status)
                    ->where('customer_services.reaction_status', null)
                    ->where('services.user_id', $user_id)
                    ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
            ->offset($start)
            ->limit($limit)
            ->get();
        $recordsTotal = sizeof($fetch_data);
        $recordsFiltered = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where('customers.user_id', $user_id)
                    ->where('customers.status', 1)
                    ->where('customers.deleted_at', null)
                    ->where('customer_services.user_id', $user_id)
                    ->where('customer_services.email_status', $sent_status)
                    ->where('customer_services.reaction_status', null)
                    ->where('services.user_id', $user_id)
                    ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
            ->count();
    } else {
        $fetch_data = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where(function($query) use($user_id, $sent_status){
                      $query->where([
                        ['customers.user_id', '=', $user_id],
                        ['customers.status', '=', 1],
                        ['customers.deleted_at', '=', null],
                        ['customer_services.user_id', '=', $user_id],
                        ['customer_services.email_status', '=', $sent_status],
                        ['customer_services.reaction_status', '=', null],
                        ['services.user_id', '=', $user_id]
                      ]);
                    })
                    ->where(function($query) use($searchTerm) {
                      $query->orWhere('customers.client_name', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customers.email', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_date', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.reaction_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
                    })
              ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
            ->offset($start)
            ->limit($limit)
            ->get();
        $recordsTotal = sizeof($fetch_data);
        $recordsFiltered = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where(function($query) use($user_id, $sent_status){
                      $query->where([
                        ['customers.user_id', '=', $user_id],
                        ['customers.status', '=', 1],
                        ['customers.deleted_at', '=', null],
                        ['customer_services.user_id', '=', $user_id],
                        ['customer_services.email_status', '=', $sent_status],
                        ['customer_services.reaction_status', '=', null],
                        ['services.user_id', '=', $user_id]
                      ]);
                    })
                    ->where(function($query) use($searchTerm) {
                      $query->orWhere('customers.client_name', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customers.email', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_date', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.reaction_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
                    })
              ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
            ->count();
    }

    $data = array();
    $SrNo = $start + 1;
    $status = ""; $active_ban = "";
    $EmailDate1 = ""; $EmailDate2 = ""; $EmailDate3 = ""; $EmailDate4 = "";
    $date1 = ""; $date2 = ""; $date3 = ""; $date4 = "";
    foreach ($fetch_data as $row => $item) {
      $reaction_status = "pending";
      if(!empty($item->reaction_status)){
        $reaction_status = $item->reaction_status;
      }
      // Get Email Dates
      $service_date = $item->service_date;
      $company_id = $item->company_id;
      $CompanyEmailDatesSetting = $this->EmailDates($company_id);
      foreach($CompanyEmailDatesSetting as $emaildates)
      {
        $EmailDate1 = $emaildates->date1;
        $EmailDate2 = $emaildates->date2;
        $EmailDate3 = $emaildates->date3;
        $EmailDate4 = $emaildates->date4;
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
      $sub_array = array();
      $sub_array[] = $SrNo;
      $sub_array[] = $item->client_name;
      $sub_array[] = $item->service_name;
      $sub_array[] = $item->email_status;
      $sub_array[] = $reaction_status;
      $sub_array[] = '<button class="btn btn-info mr-2" id="survey_' . $item->customer_service_id . '" onclick="ViewCustomerSurvey(this.id);"><i class="ti-eye"></i></button>';
      $sub_array[] = $item->service_date;
      $sub_array[] = $date1;
      $sub_array[] = $date2;
      $sub_array[] = $date3;
      $sub_array[] = $date4;
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
  // Email Management Sent Report - End

  // Email Management Record Report - Start
  public function DisplayRecordEmails()
  {
    return view('company.emails.record');
  }

  public function AllRecordEmails(Request $request)
  {
    $user_id = Auth::id();
    $sent_status = "sent";
    $limit = $request->post('length');
    $start = $request->post('start');
    $searchTerm = $request->post('search')['value'];

    $fetch_data = null;
    $recordsTotal = null;
    $recordsFiltered = null;
    if ($searchTerm == '') {
        $fetch_data = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where('customers.user_id', $user_id)
                    // ->where('customers.status', 1)
                    ->where('customers.deleted_at', null)
                    ->where('customer_services.user_id', $user_id)
                    ->where('customer_services.email_status', $sent_status)
                    ->whereNotNull('customer_services.reaction_status')
                    ->where('services.user_id', $user_id)
                    ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'customer_services.updated_at AS updated_at', 'services.service_name AS service_name')
            ->offset($start)
            ->limit($limit)
            ->get();
        $recordsTotal = sizeof($fetch_data);
        $recordsFiltered = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where('customers.user_id', $user_id)
                    // ->where('customers.status', 1)
                    ->where('customers.deleted_at', null)
                    ->where('customer_services.user_id', $user_id)
                    ->where('customer_services.email_status', $sent_status)
                    ->whereNotNull('customer_services.reaction_status')
                    ->where('services.user_id', $user_id)
                    ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'customer_services.updated_at AS updated_at', 'services.service_name AS service_name')
             ->count();
    } else {
        $fetch_data = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where(function($query) use($user_id, $sent_status){
                      $query->where([
                        ['customers.user_id', '=', $user_id],
                        // ['customers.status', '=', 1],
                        ['customers.deleted_at', '=', null],
                        ['customer_services.user_id', '=', $user_id],
                        ['customer_services.email_status', '=', $sent_status],
                        ['services.user_id', '=', $user_id]
                      ]);
                    })
                    ->whereNotNull('customer_services.reaction_status')
                    ->where(function($query) use($searchTerm) {
                      $query->orWhere('customers.client_name', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customers.email', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_date', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.reaction_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
                    })
              ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'customer_services.updated_at AS updated_at', 'services.service_name AS service_name')
            ->offset($start)
            ->limit($limit)
            ->get();
        $recordsTotal = sizeof($fetch_data);
        $recordsFiltered = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where(function($query) use($user_id, $sent_status){
                      $query->where([
                        ['customers.user_id', '=', $user_id],
                        // ['customers.status', '=', 1],
                        ['customers.deleted_at', '=', null],
                        ['customer_services.user_id', '=', $user_id],
                        ['customer_services.email_status', '=', $sent_status],
                        ['services.user_id', '=', $user_id]
                      ]);
                    })
                    ->whereNotNull('customer_services.reaction_status')
                    ->where(function($query) use($searchTerm) {
                      $query->orWhere('customers.client_name', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customers.email', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_date', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.email_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('customer_services.reaction_status', 'LIKE', '%' . $searchTerm . '%');
                      $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
                    })
              ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.user_id As company_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'customer_services.updated_at AS updated_at', 'services.service_name AS service_name')
            ->count();
    }

    $data = array();
    $SrNo = $start + 1;
    $status = ""; $active_ban = ""; $template = "";
    $FeedbackDate = "";
    foreach ($fetch_data as $row => $item)
    {
      if($item->reaction_status == "sad" || $item->reaction_status == "neutral"){
        $template = '<button class="btn btn-info mr-2" id="survey_' . $item->customer_service_id . '" onclick="ViewCustomerSurvey(this.id);"><i class="ti-eye"></i></button>';
      }
      elseif ($item->reaction_status == "happy") {
        $template = '<i class="ti-face-smile" style="font-size: 20px;"></i>';
      }

      // Get Email Dates
      $service_date = $item->service_date;
      $company_id = $item->company_id;
      $FeedbackDate = Carbon::parse($item->updated_at)->toDateString();

      $sub_array = array();
      $sub_array[] = $SrNo;
      $sub_array[] = $item->client_name;
      // $sub_array[] = $item->email;
      $sub_array[] = $item->service_name;
      $sub_array[] = $item->email_status;
      $sub_array[] = $item->reaction_status;
      $sub_array[] = $template;
      $sub_array[] = $item->service_date;
      $sub_array[] = $FeedbackDate;
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
  // Email Management Record Report - End
}

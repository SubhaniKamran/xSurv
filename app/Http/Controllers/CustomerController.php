<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\Customer;
use App\Models\CustomerServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function create()
  {
    $user_id = Auth::id();
    $services = DB::table('services')
        ->where([
            ['deleted_at', '=', null],
            ['status', '=', 1],
            ['user_id', '=', $user_id]
        ])->get();
    return view('company.customer.create', compact('services'));
  }

  public function store(Request $request){
    $user_id    = Auth::id();
    $name       = $request['client_name'];
    $email      = $request['email'];
    $phone      = $request['phone'];
    $service    = $request['service'];
    // $email_date = $request['email_date'];

    $check_email = DB::table('customers')
                  ->where('email', $email)
                  ->where('deleted_at', null)
                  ->get();
    $service_details = DB::table('services')
                  ->where('id', $service)
                  ->where('deleted_at', null)
                  ->get();
    $service_name = $service_details[0]->service_name;

    if(sizeof($check_email) > 0){
      $customer_id = $check_email[0]->id;
      DB::beginTransaction();
      try
      {
        $survey_id = "";
        $survey_questions = "";
        $service_date = date('Y-m-d');
        $email_status = "pending";

        $survey_record = DB::table('services')
                      ->join('surveys', 'services.survey_id', '=', 'surveys.id')
                      ->where('services.id', $service)
                      ->select('surveys.*')
                      ->get();

        foreach($survey_record as $survey_data){
            $survey_id = $survey_data->id;
            $survey_questions = $survey_data->question;
        }

        $affected = CustomerServices::create([
            'user_id'     => $user_id,
            'customer_id' => $customer_id,
            'survey_id'  => $survey_id,
            'service_id' => $service,
            'email_date' => $email_date,
            'service_date' => $service_date,
            'survey_question' => $survey_questions,
            // 'email_status' => $email_status,
            'created_at' => Carbon::now()
        ]);

        if($affected){
          DB::commit();
          return redirect(url('/customer/add'))->with('message','Customer Added Successfully');
        }
        else {
          DB::rollback();
          return redirect(url('/customer/add'))->with('error','Error! An unhandled error exception');
        }
      }
      catch (\Exception $e)
      {
        DB::rollback();
        throw $e;
      }
    }
    else {
      DB::beginTransaction();
      try
      {
        $affected = Customer::create([
            'user_id'     => Auth::id(),
            'client_name' => $name,
            'email'       => $email,
            'phone'       => $phone,
            'created_at'  => Carbon::now()
        ]);

        $customer_id = $affected->id;
        $survey_id = "";
        $survey_questions = "";
        $service_date = date('Y-m-d');
        $email_status = "pending";

        $survey_record = DB::table('services')
                      ->join('surveys', 'services.survey_id', '=', 'surveys.id')
                      ->where('services.id', $service)
                      ->select('surveys.*')
                      ->get();

        foreach($survey_record as $survey_data){
            $survey_id = $survey_data->id;
            $survey_questions = $survey_data->question;
        }

        $affected1 = CustomerServices::create([
            'user_id'      => $user_id,
            'customer_id'  => $customer_id,
            'service_id'   => $service,
            'survey_id'    => $survey_id,
            // 'email_date'   => $email_date,
            'service_date' => $service_date,
            'survey_question' => $survey_questions,
            'email_status' => $email_status,
            'created_at'   => Carbon::now()
        ]);

        if($affected && $affected1){
          DB::commit();
          return redirect(url('/customer/add'))->with('message','Customer Added Successfully');
        }
        else {
          DB::rollback();
          return redirect(url('/customer/add'))->with('error','Error! An unhandled error exception');
        }
      }
      catch (\Exception $e)
      {
        DB::rollback();
        throw $e;
      }
    }
  }

  public function NewCustomerServiceStore(Request $request){
    $user_id    = Auth::id();
    $customer_status = "";
    $reaction_status = "happy";
    $service    = $request->post('service');
    $service_details = DB::table('services')
                  ->where('id', $service)
                  ->where('deleted_at', null)
                  ->get();
    $service_name = $service_details[0]->service_name;

    $customer_id = $request->post('serviceCustomerId');

    // Get customer Ban status
    $customer_ban_details = DB::table('customers')
                  ->where('id', $customer_id)
                  ->get();

    foreach($customer_ban_details as $c_details)
    {
      $customer_status = $c_details->status;
    }

    DB::beginTransaction();
    try
    {
      $survey_id = "";
      $survey_questions = "";
      $service_date = date('Y-m-d');
      $email_status = "pending";

      $survey_record = DB::table('services')
                    ->join('surveys', 'services.survey_id', '=', 'surveys.id')
                    ->where('services.id', $service)
                    ->select('surveys.*')
                    ->get();

      foreach($survey_record as $survey_data){
          $survey_id = $survey_data->id;
          $survey_questions = $survey_data->question;
      }

      if($customer_status == 1)
      {
        $affected = CustomerServices::create([
            'user_id'     => $user_id,
            'customer_id' => $customer_id,
            'survey_id'  => $survey_id,
            'service_id' => $service,
            'service_date' => $service_date,
            'survey_question' => $survey_questions,
            'email_status' => $email_status,
            'created_at' => Carbon::now()
        ]);
      }
      elseif($customer_status == 0)
      {
        $affected = CustomerServices::create([
            'user_id' => $user_id,
            'customer_id' => $customer_id,
            'survey_id' => $survey_id,
            'service_id' => $service,
            'service_date' => $service_date,
            'survey_question' => $survey_questions,
            'email_status' => $email_status,
            'reaction_status' => $reaction_status,
            'created_at' => Carbon::now()
        ]);
      }

      if($affected){
        DB::commit();
        return redirect(url('/customer/all'))->with('message','Customer Assigned New Service Successfully');
      }
      else {
        DB::rollback();
        return redirect(url('/customer/all'))->with('error','Error! An unhandled error exception');
      }
    }
    catch (\Exception $e)
    {
      DB::rollback();
      throw $e;
    }
  }

  public function all()
  {
      return view('company.customer.index');
  }

  public function load(Request $request)
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
              ->where('customers.deleted_at', '=', null)
              ->where('customers.user_id', '=', $user_id)
              ->select('customers.*')
              ->offset($start)
              ->limit($limit)
              ->get();
          $recordsTotal = sizeof($fetch_data);
          $recordsFiltered = DB::table('customers')
              ->where('customers.deleted_at', '=', null)
              ->where('customers.user_id', '=', $user_id)
              ->select('customers.*')
              ->count();
      } else {
          $fetch_data = DB::table('customers')
              ->where(function($query) use($user_id){
                $query->where([
                  ['customers.deleted_at', '=', null],
                  ['customers.user_id', '=', $user_id]
                ]);
              })
              ->where(function($query) use($searchTerm) {
                $query->orWhere('customers.client_name', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('customers.email', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('customers.phone', 'LIKE', '%' . $searchTerm . '%');
              })
              ->select('customers.*')
              ->offset($start)
              ->limit($limit)
              ->get();
          $recordsTotal = sizeof($fetch_data);
          $recordsFiltered = DB::table('customers')
              ->where(function($query) use($user_id){
                $query->where([
                  ['customers.deleted_at', '=', null],
                  ['customers.user_id', '=', $user_id]
                ]);
              })
              ->where(function($query) use($searchTerm) {
                $query->orWhere('customers.client_name', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('customers.email', 'LIKE', '%' . $searchTerm . '%');
                $query->orWhere('customers.phone', 'LIKE', '%' . $searchTerm . '%');
              })
              ->select('customers.*')
              ->count();
      }

      $data = array();
      $SrNo = $start + 1;
      $status = ""; $active_ban = "";
      foreach ($fetch_data as $row => $item) {
          if($item->status == 1){
            $status = '<span class="badge badge-success">Active</span>';
            $active_ban = '<button class="btn btn-danger" id="ban_' . $item->id . '" onclick="banCustomer(this.id);">Ban</button>';
          }else {
            $status = '<span class="badge badge-danger">Ban</span>';
            $active_ban = '<button class="btn btn-success" id="active_' . $item->id . '" onclick="activeCustomer(this.id);">Active</button>';
          }
          $sub_array = array();
          $sub_array[] = $SrNo;
          $sub_array[] = $item->client_name;
          $sub_array[] = $item->email;
          $sub_array[] = $item->phone;
          $sub_array[] = $status;
          $sub_array[] = '<button class="btn btn-info mr-2" id="view_' . $item->id . '" onclick="viewCustomer(this.id);"><i class="ti-eye"></i></button><button class="btn btn-info mr-2" id="edit_' . $item->id . '" onclick="editCustomer(this.id);"><i class="ti-pencil-alt"></i></button><button class="btn btn-danger" id="delete_' . $item->id . '" onclick="deleteCustomer(this.id);"><i class="ti-trash"></i></button>';
          $sub_array[] = $active_ban;
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

  public function delete(Request $request){
    $CustomerId = $request->post('CustomerId');
    DB::beginTransaction();
    $affected = DB::table('customers')
                  ->where('id', $CustomerId)
                  ->update([
                    'deleted_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                  ]);
    if($affected){
      DB::commit();
      echo "Success";
    }
    else {
      DB::rollback();
      echo "Error";
    }
  }

  public function active(Request $request){
    $CustomerId = $request->post('CustomerId');
    DB::beginTransaction();
    $affected = DB::table('customers')
                ->where('id', $CustomerId)
                ->update([
                    'status' => 1,
                    'updated_at' => Carbon::now()
                ]);
    if($affected){
      DB::commit();
      echo "Success";
    }
    else {
      DB::rollback();
      echo "Error";
    }
  }

  public function ban(Request $request){
    $CustomerId = $request->post('CustomerId');
    DB::beginTransaction();
    $affected = DB::table('customers')
                  ->where('id', $CustomerId)
                  ->update([
                    'status' => 0,
                    'updated_at' => Carbon::now()
                  ]);
    if($affected){
      DB::commit();
      echo "Success";
    }
    else {
      DB::rollback();
      echo "Error";
    }
  }

  public function editCustomer(Request $request){
    $CustomerId = $request->post('CustomerId');
    $customer = DB::table('customers')
                ->where('id', $CustomerId)
                ->get();
    return view('company/customer/edit', compact('customer'));
  }

  public function updateCustomer(Request $request){
    $CustomerId = $request->customerId;
    DB::beginTransaction();
    $affected = DB::table('customers')
                ->where('id', $CustomerId)
                ->update([
                    'client_name' => $request['client_name'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                    'updated_at' => Carbon::now()
                ]);
    if ($affected) {
      DB::commit();
      return redirect(url('/customer/all'))->with('message','Customer Updated Successfully');
    }
    else {
      DB::rollback();
      return redirect(url('/customer/all'))->with('error','Error! An Unhandled Exception Occurred');
    }
  }

  public function viewCustomer(Request $request){
    $CustomerId = $request->post('CustomerId');
    $CustomerDetails = DB::table('customers')
                ->where('customers.id', $CustomerId)
                ->select('customers.*')
                ->get();

    return view('company/customer/viewCustomerDetails', compact('CustomerDetails', 'CustomerId'));
  }

  public function viewCustomerServices(Request $request){
    $CustomerId = $request->post('CustomerId');
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
                    ->where('customers.id', $CustomerId)
                    ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date' ,'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
            ->offset($start)
            ->limit($limit)
            ->get();
        $recordsTotal = sizeof($fetch_data);
        $recordsFiltered = DB::table('customers')
                    ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                    ->join('services', 'services.id', '=', 'customer_services.service_id')
                    ->where('customers.id', $CustomerId)
                    ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
                    ->count();
    } else {
      $fetch_data = DB::table('customers')
                  ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                  ->join('services', 'services.id', '=', 'customer_services.service_id')
                  ->where(function($query) use($CustomerId){
                    $query->where([
                      ['customers.id', '=', $CustomerId],
                    ]);
                  })
                  ->where(function($query) use($searchTerm) {
                    $query->orWhere('customer_services.email_date', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('customer_services.email_status', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('customer_services.reaction_status', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
                  })
            ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
            ->offset($start)
            ->limit($limit)
            ->get();
      $recordsTotal = sizeof($fetch_data);
      $recordsFiltered = DB::table('customers')
                  ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                  ->join('services', 'services.id', '=', 'customer_services.service_id')
                  ->where(function($query) use($CustomerId){
                    $query->where([
                      ['customers.id', '=', $CustomerId],
                    ]);
                  })
                  ->where(function($query) use($searchTerm) {
                    $query->orWhere('customer_services.email_date', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('customer_services.email_status', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('customer_services.reaction_status', 'LIKE', '%' . $searchTerm . '%');
                    $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
                  })
            ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.service_date AS service_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
            ->count();
    }

    $data = array();
    $SrNo = $start + 1;
    $status = ""; $active_ban = ""; $template  = "";
    foreach ($fetch_data as $row => $item) {
        $reaction_status = "pending";
        if(!empty($item->reaction_status)){
          $reaction_status = $item->reaction_status;
          if($item->reaction_status == "sad" || $item->reaction_status == "neutral"){
            $template = '<button class="btn btn-info mr-2" id="survey_' . $item->customer_service_id . '" onclick="ViewCustomerSurvey(this.id);"><i class="ti-eye"></i></button>';
          }
          elseif ($item->reaction_status == "happy") {
            $template = '<i class="ti-face-smile" style="font-size: 20px;"></i>';
          }
        }
        else {
          $template = '<button class="btn btn-info mr-2" id="survey_' . $item->customer_service_id . '" onclick="ViewCustomerSurvey(this.id);"><i class="ti-eye"></i></button>';
        }
        $sub_array = array();
        $sub_array[] = $SrNo;
        $sub_array[] = $item->service_name;
        // $sub_array[] = '<button class="btn btn-info mr-2" id="survey_' . $item->customer_service_id . '" onclick="ViewCustomerSurvey(this.id);"><i class="ti-eye"></i></button>';
        $sub_array[] = $template;
        // $sub_array[] = $item->email_date;
        $sub_array[] = $item->service_date;
        $sub_array[] = $item->email_status;
        $sub_array[] = $reaction_status;
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

  public function CustomerSurveyDetails(Request $request)
  {
    $CustomerServiceId = $request->post('CustomerServiceId');
    $ServiceId  = $request->post('ServiceId');
    $SurveyId   = $request->post('SurveyId');
    $survey     = array();
    $customer_survey =  DB::table('customers')
                ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                ->join('services', 'services.id', '=', 'customer_services.service_id')
                ->where('customer_services.id', $CustomerServiceId)
                ->select('customer_services.survey_question AS survey_question', 'customer_services.survey_answer AS survey_answer')
                ->get();

      $survey[0] = $customer_survey[0]->survey_question;
      $survey[1] = $customer_survey[0]->survey_answer;
      echo json_encode($survey);
  }
}

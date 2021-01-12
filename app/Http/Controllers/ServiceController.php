<?php
namespace App\Http\Controllers;

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function create()
  {
      $user_id = Auth::id();
      $surveys = DB::table('surveys')
                ->where(function($query) use($user_id){
                  $query->where([
                    ['surveys.deleted_at', '=', null],
                    ['surveys.status', '=', 1],
                    ['surveys.user_id', '=', $user_id]
                  ]);
                })
                ->where(function($query) use($user_id) {
                  $query->orWhere('surveys.user_id', '=', $user_id);
                  $query->orWhere('surveys.user_id', '=', 1);
                })
                ->select('surveys.*')
                ->get();

      return view('company.service.create', compact('surveys'));
  }
  public function store(Request $request){
      $user_id = Auth::id();
      $affected = null;
      DB::beginTransaction();
      $affected = Service::create([
          'user_id' => $user_id,
          'survey_id' => $request['survey'],
          'service_name' => $request['service_name'],
          'created_at' => Carbon::now()
      ]);
      if($affected){
        DB::commit();
        return redirect(url('/service/add'))->with('message','Service Added Successfully');
      }
      else {
        DB::rollback();
        return redirect(url('/service/add'))->with('error','Error! An unhandled error exception');
      }
  }

  public function all()
  {
      return view('company.service.index');
  }

  public function AllServices(Request $request)
  {
    $user_id = Auth::id();
    $services = DB::table('services')
        ->where('services.deleted_at', '=', null)
        ->where('services.user_id', '=', $user_id)
        ->get();

    return json_encode($services);
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
          $fetch_data = DB::table('services')
              -> join('surveys', 'services.survey_id', '=', 'surveys.id')
              ->where('services.deleted_at', '=', null)
              ->where('services.user_id', '=', $user_id)
              ->select('services.*', 'surveys.question AS question', 'surveys.id AS surveyid')
              ->offset($start)
              ->limit($limit)
              ->get();
          $recordsTotal = sizeof($fetch_data);
          $recordsFiltered = DB::table('services')
              -> join('surveys', 'services.survey_id', '=', 'surveys.id')
              ->where('services.deleted_at', '=', null)
              ->where('services.user_id', '=', $user_id)
              ->select('services.*', 'surveys.question AS question', 'surveys.id AS surveyid')
              ->count();
      } else {
          $fetch_data = DB::table('services')
              -> join('surveys', 'services.survey_id', '=', 'surveys.id')
              ->where(function($query) use($user_id){
                $query->where([
                  ['services.deleted_at', '=', null],
                  ['services.user_id', '=', $user_id]
                ]);
              })
              ->where(function($query) use($searchTerm) {
                $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
              })
              ->select('services.*', 'surveys.question AS question', 'surveys.id AS surveyid')
              ->offset($start)
              ->limit($limit)
              ->get();
          $recordsTotal = sizeof($fetch_data);
          $recordsFiltered = DB::table('services')
              -> join('surveys', 'services.survey_id', '=', 'surveys.id')
              ->where(function($query) use($user_id){
                $query->where([
                  ['services.deleted_at', '=', null],
                  ['services.user_id', '=', $user_id]
                ]);
              })
              ->where(function($query) use($searchTerm) {
                $query->orWhere('services.service_name', 'LIKE', '%' . $searchTerm . '%');
              })
              ->select('services.*', 'surveys.question AS question', 'surveys.id AS surveyid')
              ->count();
      }

      $data = array();
      $SrNo = $start + 1;
      $status = ""; $active_ban = "";
      foreach ($fetch_data as $row => $item) {
          if($item->status == 1){
            $status = '<span class="badge badge-success">Active</span>';
            $active_ban = '<button class="btn btn-danger" id="ban_' . $item->id . '" onclick="banService(this.id);">Ban</button>';
          }else {
            $status = '<span class="badge badge-danger">Ban</span>';
            $active_ban = '<button class="btn btn-success" id="active_' . $item->id . '" onclick="activeService(this.id);">Active</button>';
          }
          $sub_array = array();
          $sub_array[] = $SrNo;
          $sub_array[] = $item->service_name;
          $sub_array[] = '<button class="btn btn-info mr-2" id="survey_' . $item->surveyid . '" onclick="ViewServiceSurveyQuestions(this.id);"><i class="ti-eye"></i></button>';
          $sub_array[] = $status;
          $sub_array[] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '" onclick="editService(this.id);"><i class="ti-pencil-alt"></i></button><button class="btn btn-danger" id="delete_' . $item->id . '" onclick="deleteService(this.id);"><i class="ti-trash"></i></button>';
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
    $ServiceId = $request->post('ServiceId');
    DB::beginTransaction();
    $affected = DB::table('services')
                  ->where('id', $ServiceId)
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
    $ServiceId = $request->post('ServiceId');
    DB::beginTransaction();
    $affected = DB::table('services')
                ->where('id', $ServiceId)
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
    $ServiceId = $request->post('ServiceId');
    DB::beginTransaction();
    $affected = DB::table('services')
                  ->where('id', $ServiceId)
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

  public function editService(Request $request){
    $user_id   = Auth::id();
    $ServiceId = $request->post('ServiceId');
    $service = DB::table('services')
        ->where([
            ['id', '=', $ServiceId]
        ])->get();
    $surveys = DB::table('surveys')
              ->where(function($query){
                $query->where([
                  ['surveys.deleted_at', '=', null],
                  ['surveys.status', '=', 1]
                ]);
              })
              ->where(function($query) use($user_id) {
                $query->orWhere('surveys.user_id', '=', $user_id);
                $query->orWhere('surveys.user_id', '=', 1);
              })
              ->select('surveys.*')
              ->get();

    return view('company/service/edit', compact('service', 'surveys'));
  }

  public function updateService(Request $request){
    $ServiceId = $request->serviceId;
    DB::beginTransaction();
    $affected = DB::table('services')
                ->where('id', $ServiceId)
                ->update([
                    'survey_id' => $request['survey'],
                    'service_name' => $request['service_name'],
                    'updated_at' => Carbon::now()
                ]);
    if ($affected) {
      DB::commit();
      return redirect(url('/service/all'))->with('message','Service Updated Successfully');
    }
    else {
      DB::rollback();
      return redirect(url('/service/all'))->with('error','Error! An Unhandled Exception Occurred');
    }
  }

  public function ServiceSurveyQuestion(Request $request){
    $survey_id = $request->post('SurveyId');
    $survey = DB::table('surveys')
              ->where('id', $survey_id)
              ->get();

    echo $survey[0]->question;
  }
}

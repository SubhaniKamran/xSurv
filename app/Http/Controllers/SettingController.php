<?php
namespace App\Http\Controllers;

use App\Models\GoogleReviews;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  // Google Review Setting - Start
  public function GoogleReviewCreate()
  {
      $user_id = Auth::id();
      $google_review = DB::table('google_reviews')
                  ->where('deleted_at', '=', null)
                  ->where('user_id', '=', $user_id)
                  ->count();

      return view('company.setting.create_google_review', compact('google_review'));
  }

  public function GoogleReviewStore(Request $request){
      $user_id = Auth::id();
      $affected = null;
      $google_url = "https://search.google.com/local/writereview?placeid=" . $request['google_url'];
      DB::beginTransaction();
      $affected = GoogleReviews::create([
          'user_id' => $user_id,
          'google_url' => $google_url,
          'created_at' => Carbon::now()
      ]);
      if($affected){
        DB::commit();
        return redirect(url('/googlereview/add'))->with('message','Google Review Added Successfully');
      }
      else {
        DB::rollback();
        return redirect(url('/googlereview/add'))->with('error','Error! An unhandled error exception');
      }
  }

  public function GoogleReviewLoad(Request $request)
  {
      $user_id = Auth::id();
      $limit = $request->post('length');
      $start = $request->post('start');
      $searchTerm = $request->post('search')['value'];

      $fetch_data = null;
      $recordsTotal = null;
      $recordsFiltered = null;
      if ($searchTerm == '') {
          $fetch_data = DB::table('google_reviews')
              ->where('google_reviews.deleted_at', '=', null)
              ->where('google_reviews.user_id', '=', $user_id)
              ->select('google_reviews.*')
              ->offset($start)
              ->limit($limit)
              ->get();
          $recordsTotal = sizeof($fetch_data);
          $recordsFiltered = DB::table('google_reviews')
              ->where('google_reviews.deleted_at', '=', null)
              ->where('google_reviews.user_id', '=', $user_id)
              ->select('google_reviews.*')
              ->count();
      } else {
          $fetch_data = DB::table('google_reviews')
              ->where(function($query) use($user_id){
                $query->where([
                  ['google_reviews.deleted_at', '=', null],
                  ['google_reviews.user_id', '=', $user_id]
                ]);
              })
              ->where(function($query) use($searchTerm) {
                $query->orWhere('google_reviews.google_url', 'LIKE', '%' . $searchTerm . '%');
              })
              ->select('google_reviews.*')
              ->offset($start)
              ->limit($limit)
              ->get();
          $recordsTotal = sizeof($fetch_data);
          $recordsFiltered = DB::table('google_reviews')
              ->where(function($query) use($user_id){
                $query->where([
                  ['google_reviews.deleted_at', '=', null],
                  ['google_reviews.user_id', '=', $user_id]
                ]);
              })
              ->where(function($query) use($searchTerm) {
                $query->orWhere('google_reviews.google_url', 'LIKE', '%' . $searchTerm . '%');
              })
              ->select('google_reviews.*')
              ->count();
      }

      $data = array();
      foreach ($fetch_data as $row => $item) {
          $sub_array = array();
          $sub_array[] = $item->google_url;
          $sub_array[] = '<button class="btn btn-info mr-2" id="edit_' . $item->id . '" onclick="editGoogleReviewUrl(this.id);"><i class="ti-pencil-alt"></i></button>';
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

  public function GoogleReviewUpdate(Request $request)
  {
    $GoogleReviewUrlID = $request->post('GoogleReviewUrlId');
    $Url = "https://search.google.com/local/writereview?placeid=" . $request->post('Url');
    DB::beginTransaction();
    $affected = DB::table('google_reviews')
                ->where('id', $GoogleReviewUrlID)
                ->update([
                  'google_url' => $Url,
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
  // Google Review Setting - End
}

<?php
namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GeneralSettingsController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  // Google Setting - Start
  public function GeneralSettingLogoCreate()
  {
      $user_id = Auth::id();
      $google_settings_logo = DB::table('general_settings')
                  ->where('deleted_at', '=', null)
                  ->where('user_id', '=', 1)
                  ->get();

      $google_settings_logo_check = DB::table('general_settings')
                  ->where('deleted_at', '=', null)
                  ->where('user_id', '=', 1)
                  ->count();

      return view('admin.setting.logo', compact('google_settings_logo', 'google_settings_logo_check'));
  }

  public function GeneralSettingLogoStore(Request $request){
      $user_id = Auth::id();
      $affected = null;

      if($request->hasFile('logo_url'))
      {
        $FileName  = "xsurvey_logo";
        $Extension = $request->file('logo_url')->extension();
        $FileName  = $FileName . '.' . $Extension;
        $result    = $request->file('logo_url')->storeAs('/public/logo/', $FileName);

        DB::beginTransaction();
        $affected = GeneralSetting::create([
            'user_id' => $user_id,
            'logo_url' => $FileName,
            'created_at' => Carbon::now()
        ]);
        if($affected){
          DB::commit();
          return redirect(url('/admin/settings/logo'))->with('message','Logo Added Successfully');
        }
        else {
          DB::rollback();
          return redirect(url('/admin/settings/logo'))->with('error','Error! An unhandled error exception');
        }
      }
  }

  public function GeneralSettingLogoUpdate(Request $request){
      $user_id = Auth::id();
      $affected = null;
      $PreviousFileName = $request->post('editGeneralSettingsLogoId');
      if($request->hasFile('editLogoUrl'))
      {
        $path = storage_path().'/app/public/logo/'. $PreviousFileName;
        unlink($path);
        $FileName  = "xsurvey_logo";
        $Extension = $request->file('editLogoUrl')->extension();
        $FileName  = $FileName . '.' . $Extension;
        $result    = $request->file('editLogoUrl')->storeAs('/public/logo/', $FileName);

        DB::beginTransaction();
        $affected = DB::table('general_settings')
                    ->update([
                      'logo_url' => $FileName,
                      'updated_at' => Carbon::now()
                    ]);
        if($affected){
          Session::put('logo', $FileName);
          DB::commit();
          return redirect(url('/admin/settings/logo'))->with('message','Logo Updated Successfully');
        }
        else {
          DB::rollback();
          return redirect(url('/admin/settings/logo'))->with('error','Error! An unhandled error exception');
        }
      }
  }
  // Google Review Setting - End
}

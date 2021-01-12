<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $logo_details = DB::table('general_settings')
                    ->where('user_id', '=', 1)
                    ->get();
        $logo = $logo_details[0]->logo_url;
        return view('auth.login', compact('logo'));
    }

    protected function authenticated(Request $request, $user)
    {
      if(! $user->status){
        Auth::logout();
        return redirect('/login')->with('error','Blocked by X-Survey.');
      }
      else {
        $logo_name = "";
        $name = "";
        $profile_image = "";
        // Get Logo from database
        $google_settings_logo = DB::table('general_settings')
                    ->where('deleted_at', '=', null)
                    ->where('user_id', '=', 1)
                    ->limit(1)
                    ->get();
        foreach($google_settings_logo as $logo)
        {
          $logo_name = $logo->logo_url;
        }
        Session::put('logo', $logo_name);

        // Start of Getting User Name and Profile Image
        $profile_details = DB::table('profiles')
                    ->where('user_id', '=', $user->id)
                    ->get();

        foreach($profile_details as $profile)
        {
          $name = $profile->full_name;
          $profile_image = $profile->image;
        }
        Session::put('name', $name);

        if (!Storage::disk('profile')->exists($profile_image)) {
          $profile_image = "dummy.jpg";
        }
        Session::put('profile', $profile_image);

        if ($user->role_id == '2'){
            $this->redirectTo= '/admin/dashboard';
        }
        else {
          $end_date = "0000-00-00";
          // Get User Package Status
          $package_status = DB::table('company_packages')
                      ->where('user_id', '=', $user->id)
                      ->get();

          if(sizeof($package_status) > 0)
          {
            foreach($package_status as $package)
            {
              $end_date = $package->end_date;
            }
            Session::put('ExpiryDate', $end_date);
          }
          else {
            Session::put('ExpiryDate', $end_date);
            return redirect(url('/packages/company/recommendation'));
          }
        }
      }
    }
    public function logout(Request $request)
    {
      Auth::logout();
      return redirect('/login');
    }
}

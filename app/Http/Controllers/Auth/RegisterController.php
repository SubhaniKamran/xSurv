<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\CompanyDates;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $logo_details = DB::table('general_settings')
                    ->where('user_id', '=', 1)
                    ->get();
        $logo = $logo_details[0]->logo_url;
        return view('auth.register', compact('logo'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        DB::beginTransaction();
        $affected = null;
        $affected2 = null;
        $user= User::create([
          'email' => $data['email'],
          'password' => Hash::make($data['password']),
        ]);
        if($user){
          $affected = Profile::create([
              'user_id' => $user->id,
              'full_name' => $data['username'],
              'phone' => $data['phone'],
              'address' => $data['address'],
              'image' => "dummy.jpg",
          ]);

          $affected2 = CompanyDates::create([
              'user_id' => $user->id
          ]);
        }

        $Email = $data['email'];
        $Password = $data['password'];
        $CompanyName = $data['username'];

        // Get Admin Email
        $admin_details = DB::table('users')
            ->where('id', 1)
            ->get();

        // Get Company Logo
        $logo_details = DB::table('general_settings')
            ->where('user_id', 1)
            ->get();

        $logo = $logo_details[0]->logo_url;

        $AdminEmail = $admin_details[0]->email;
        $from_email = $_ENV['MAIL_FROM_ADDRESS'];

        // SET COMPANY EMAIL CODE HERE - START
        $data = array('to' => $Email, 'from' => $from_email, 'password'=> $Password, 'company' => $CompanyName, 'headline' => "Congratulations!", 'logo' => $logo, 'status' => 0);
        Mail::send('emails.companyregister', $data, function($message) use ($data){
            $message->to($data['to'], 'X-Survey')->subject('Company Registration');
            $message->from($data['from'],'X-Survey');
        });
        // SET EMAIL CODE HERE - END

        // SET ADMIN EMAIL CODE HERE - START
        $data = array('to' => $AdminEmail, 'from' => $from_email, 'password'=> $Password, 'company' => $CompanyName, 'headline' => "New Company Registered!", 'logo' => $logo, 'status' => 1);
        Mail::send('emails.companyregister', $data, function($message) use ($data){
            $message->to($data['to'], 'X-Survey')->subject('Company Registration');
            $message->from($data['from'],'X-Survey');
        });
        // SET EMAIL CODE HERE - END

        /* Create user notification setting account */
        $n_setting_affected = NotificationSetting::create([
          'user_id' => $user->id,
          'status' => 1,
          'created_at' => Carbon::now(),
        ]);

        /* Admin Notification Setting Check - Start */
        $notification_check = NotificationSetting::select('status')->where('user_id', 1)->first();

        /* Notification Work - Start */
        if($notification_check->status == 1)
        {
          $message = $CompanyName . ", New company registered.";
          $n_affected1 = Notification::create([
            'message' => $message,
            'sender_id' => $user->id,
            'reciever_id' => 1,
            'created_at' => Carbon::now(),
          ]);
        }

        $message = "Congratulations! You have been registered successfully.";
        $n_affected2 = Notification::create([
          'message' => $message,
          'sender_id' => $user->id,
          'reciever_id' => $user->id,
          'created_at' => Carbon::now(),
        ]);
        /* Notification Work - End */

        if($affected && $affected2 && $n_setting_affected){
            DB::commit();
        }
        else{
            DB::rollback();
        }
        return $user;
    }
}

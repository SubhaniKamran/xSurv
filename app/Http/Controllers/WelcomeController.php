<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mail;

class WelcomeController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
      $logo_details = DB::table('general_settings')
              ->where('user_id', 1)
              ->get();

      $logo = $logo_details[0]->logo_url;

      $package_details = DB::table('packages')
              ->where('deleted_at', null)
              ->get();

      return view('home/welcome', compact('logo', 'package_details'));
    }

    public function DropUsALine(Request $request)
    {
      // Send Email to Admin
      $Name    = $request->post('name');
      $Email   = $request->post('email');
      $Message = $request->post('message');

      // Get Admin Email
      $admin_details = DB::table('users')
          ->where('id', 1)
          ->get();

      $AdminEmail = $admin_details[0]->email;

      // Get Logo Details
      $logo_details = DB::table('general_settings')
              ->where('user_id', 1)
              ->get();

      $logo = $logo_details[0]->logo_url;

      // Get from email address from .env file
      $from_email = $_ENV['MAIL_FROM_ADDRESS'];

      // SET ADMIN EMAIL CODE HERE - START
      $data = array('to' => $AdminEmail, 'from' => $from_email, 'name'=> $Name, 'email' => $Email, 'message_drop' => $Message, 'logo' => $logo);
      Mail::send('emails.dropusaline', $data, function($message) use ($data){
          $message->to($data['to'], 'X-Survey')->subject('Drop Us a Line');
          $message->from($data['from'],'X-Survey');
      });
      // SET EMAIL CODE HERE - END

      return redirect(url('/'));
    }

    public function clearcache()
    {
      Auth::logout();
      return redirect('/clear-cache');
    }
}

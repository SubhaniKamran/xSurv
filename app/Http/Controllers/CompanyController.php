<?php

namespace App\Http\Controllers;

use Mail;
use App\Http\Requests\StoreCompany;
use App\Models\Company;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users=User::all();
        return view('admin.company.index', compact('users'));
    }

    public function create()
    {
        return view('admin.company.create');
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        $Email = $request['email'];
        $Password = $request['password'];
        $CompanyName = $request['company_name'];
        // Check if Email Already Exists or Not
        $email_check = DB::table('users')
                ->where('email', $Email)
                ->count();

        if($email_check > 0)  {
          return redirect(url('/admin/company/create'))->with('error','Error! Email Already Exists');
        }
        else {
          if(strlen($Password) <= 7){
            return redirect(url('/admin/company/create'))->with('error','Error! Password must be of 8 characters');
          }
          else {
            DB::beginTransaction();
            $user= User::create([
              'email' => $request['email'],
              'password' => Hash::make($request['password']),
            ]);
            if($user){
                Profile::create([
                  'user_id'=>$user->id,
                  'full_name' => $request['company_name'],
                  'phone' => $request['phone'],
                  'address' => $request['address'],
                  'image' => "dummy.jpg",
                ]);
            }

            /* Admin Notification Setting Check - Start */
            $notification_check = NotificationSetting::select('status')->where('user_id', 1)->first();

            /* Notification Work - Start */
            if($notification_check->status == 1)
            {
              $message = $request['company_name'] . ", New company registered.";
              Notification::create([
                'message' => $message,
                'sender_id' => $user_id,
                'reciever_id' => $user_id,
                'created_at' => Carbon::now(),
              ]);
            }

            $message =  "Congratulations! You have been registered successfully.";
            Notification::create([
              'message' => $message,
              'sender_id' => $user_id,
              'reciever_id' => $user->id,
              'created_at' => Carbon::now(),
            ]);
            /* Notification Work - End */

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

            DB::commit();
            return redirect(route('admin.company.index'))->with('message','Company Registered successfully and confirmation Email sent!');
          }
        }
    }

    public function show(Company $company)
    {

    }

    public function edit(User $company)
    {
        $users = User::where('id','!=', $company->id)->get();
        return view('admin.company.create',['users'=>$users, 'user'=>$company]);
    }

    public function update(Request $request, User $company)
    {
        $request->validate([
            'company_name'=>'required|min:4',
            'email'=>'required|email',
            'phone'=>'required',
            'address'=>'required',
        ]);
        $company->email=$request->email;
        $profile = Profile::where('user_id',$company['id'])->first();
        $profile->full_name=$request->company_name;
        $profile->address=$request->address;
        $profile->phone=$request->phone;
        $company->save();
        $profile->save();
        return redirect(route('admin.company.index'))->with('message', 'Record Successfully Update');
    }

    public function destroy(User $company)
    {
        if($company->forceDelete())
        {
            $company->profile()->forceDelete();
            return back()->with('message','Company Deleted successfully');
        }
        else
        {
            return back()->with('message','Error Deleting Company');
        }
    }

    public function ban($id)
    {
        DB::beginTransaction();
        $affected = DB::table('users')
                ->where('id', $id)
                ->update([
                  'status' => 0,
                  'updated_at' => Carbon::now()
                ]);
        if ($affected) {
          DB::commit();
          return redirect(route('admin.company.index'))->with('message', 'Company Successfully Banned');
        }
        else {
          DB::rollback();
          return redirect(route('admin.company.index'))->with('message', 'Error! An unhandled exception occured');
        }
    }

    public function active($id)
    {
      DB::beginTransaction();
      $affected = DB::table('users')
              ->where('id', $id)
              ->update([
                'status' => 1,
                'updated_at' => Carbon::now()
              ]);
      if ($affected) {
        DB::commit();
        return redirect(route('admin.company.index'))->with('message', 'Company Successfully Activated');
      }
      else {
        DB::rollback();
        return redirect(route('admin.company.index'))->with('message', 'Error! An unhandled exception occured');
      }
    }

    public function CompanyDetails($user_id)
    {
      $sent_status = "sent";
      $company_details = DB::table('customers')
                  ->join('customer_services', 'customer_services.customer_id', '=', 'customers.id')
                  ->join('services', 'services.id', '=', 'customer_services.service_id')
                  ->where('customers.user_id', $user_id)
                  ->where('customers.status', 1)
                  ->where('customers.deleted_at', null)
                  ->where('customer_services.user_id', $user_id)
                  ->where('customer_services.email_status', $sent_status)
                  ->whereNotNull('customer_services.reaction_status')
                  ->where('services.user_id', $user_id)
                  ->select('customers.*', 'customer_services.id AS customer_service_id', 'customer_services.service_id AS service_id', 'customer_services.survey_id AS survey_id', 'customer_services.email_date AS email_date', 'customer_services.email_status AS email_status', 'customer_services.reaction_status AS reaction_status', 'services.service_name AS service_name')
                  ->get();

      $profile_details = DB::table('users')
                  ->join('profiles', 'profiles.user_id', '=', 'users.id')
                  ->where('users.id', $user_id)
                  ->select('users.email AS Email', 'profiles.full_name AS FullName', 'profiles.address AS Address', 'profiles.phone AS Phone')
                  ->get();
      return view('admin.company.details', compact('company_details', 'profile_details'));
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      if (Session::has('name')){
        $user_id = Auth::id();
        $sent = "sent";
        $reaction_status = "happy";

        // Total Customers
        $customers = DB::table('customers')
                  ->where('user_id', $user_id)
                  ->where('deleted_at', null)
                  ->count();

        // Happy Customers
        $happy_customers = DB::table('customer_services')
                  ->where('user_id', $user_id)
                  ->where('email_status', $sent)
                  ->where('reaction_status', $reaction_status)
                  ->where('deleted_at', null)
                  ->count();

        // Happy Customers
        $total_records = DB::table('customer_services')
                  ->where('user_id', $user_id)
                  ->where('email_status', $sent)
                  ->whereNotNull('reaction_status')
                  ->where('deleted_at', null)
                  ->count();

        // Total Services
        $total_services = DB::table('services')
                  ->where('user_id', $user_id)
                  ->where('deleted_at', null)
                  ->count();

        return view('company/dashboard', compact('customers', 'happy_customers', 'total_records', 'total_services'));
      }
      else {
        Auth::logout();
        return redirect('/')->withError('');
      }
    }
}

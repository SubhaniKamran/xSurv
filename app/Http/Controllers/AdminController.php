<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
      $sent = "sent";
      $reaction_status = "happy";
      // Total Customers
      $customers = DB::table('customers')
                ->where('deleted_at', null)
                ->count();

      // Happy Customers
      $happy_customers = DB::table('customer_services')
                ->where('email_status', $sent)
                ->where('reaction_status', $reaction_status)
                ->where('deleted_at', null)
                ->count();

      // Total Companies
      $total_companies = DB::table('users')
                ->where('role_id', 1)
                ->where('deleted_at', null)
                ->count();

      // Total Revenue
      $total_revenue =  DB::table("transaction_histories")->sum('amount_paid');

      return view('admin.dashboard', compact('customers', 'happy_customers', 'total_companies', 'total_revenue'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}

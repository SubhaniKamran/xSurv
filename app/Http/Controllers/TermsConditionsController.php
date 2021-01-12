<?php

namespace App\Http\Controllers;

use App\Models\TermsConditions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TermsConditionsController extends Controller
{
    public function create()
    {
      $user_id = Auth::id();
      $terms_conditions = DB::table('terms_conditions')
              ->where('user_id', $user_id)
              ->get();

      $terms_conditions_check = DB::table('terms_conditions')
              ->where('user_id', $user_id)
              ->whereNotNull('termscondition')
              ->count();

      return view('admin.terms_conditions.index', compact('terms_conditions', 'terms_conditions_check'));
    }

    public function store(Request $request)
    {
      $user_id = Auth::id();
      $description = $request->post('description');
      $terms_conditions_check = DB::table('terms_conditions')
              ->where('user_id', $user_id)
              ->whereNotNull('termscondition')
              ->count();

      if($terms_conditions_check > 0)
      {
        DB::beginTransaction();
        $affected = DB::table('terms_conditions')
              ->where('user_id', $user_id)
              ->update([
                'termscondition' => $description,
                'updated_at' => Carbon::now()
              ]);
        if ($affected) {
          DB::commit();
          return redirect(url('admin/termsconditions/create'))->with('message','Terms and Conditions Updated Successfully');
        }
        else {
          DB::rollback();
          return redirect(url('admin/termsconditions/create'))->with('error','Error! An Unhandled Exception Occurred');
        }
      }
      else
      {
        DB::beginTransaction();
        $affected = TermsConditions::create([
            'user_id' => $user_id,
            'termscondition' => $description,
            'created_at' => Carbon::now()
        ]);
        if ($affected) {
          DB::commit();
          return redirect(url('admin/termsconditions/create'))->with('message','Terms and Conditions Added Successfully');
        }
        else {
          DB::rollback();
          return redirect(url('admin/termsconditions/create'))->with('error','Error! An Unhandled Exception Occurred');
        }
      }
    }

    public function DisplayTermsConditions()
    {
      $terms_conditions = DB::table('terms_conditions')
                    ->get();

      $general_settings = DB::table('general_settings')
                    ->where('user_id', 1)
                    ->get();
      return view('home/terms_conditions', compact('terms_conditions', 'general_settings'));
    }
}

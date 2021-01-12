<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $packages = DB::table('packages')
                    ->where('deleted_at', null)
                    ->get();
        return view('admin.package.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.package.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_name'=>'required|min:4',
            'description'=>'required',
            'price'=>'required',
            'duration'=>'required',
        ]);

        $package = Package::create($request->only('package_name','description','price','duration'));
        return back()->with('message','Package Added Successfully');
    }

    public function edit(Package $package)
    {
        $packages = Package::where('id','!=', $package->id)->get();
        return view('admin.package.create',['packages'=>$packages, 'package'=>$package]);
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'package_name'=>'required|min:4',
            'description'=>'required',
            'price'=>'required',
            'duration'=>'required',
        ]);

        if($request->recommend_status == "recommend")
        {
          $package_details = DB::table('packages')
                      ->where('recommend_status', "recommend")
                      ->where('deleted_at', null)
                      ->count();

          if($package_details >= 1)
          {
            $package_id = $request->package_id;
            $package_details_count = DB::table('packages')
                        ->where('recommend_status', "recommend")
                        ->where('id', $package_id)
                        ->where('deleted_at', null)
                        ->count();

            if($package_details_count >= 1)
            {
              $package->package_name=$request->package_name;
              $package->description=$request->description;
              $package->price=$request->price;
              $package->duration=$request->duration;
              $package->recommend_status = $request->recommend_status;
              $saved=$package->save();

              return redirect(route('admin.package.index'))->with('message', 'Record Successfully Update');
            }
            else
            {
              return redirect(route('admin.package.index'))->with('error', 'Error! Maximum 1 Recommend Packages is Allowed');
            }
          }
          else
          {
            $package->package_name=$request->package_name;
            $package->description=$request->description;
            $package->price=$request->price;
            $package->duration=$request->duration;
            $package->recommend_status = $request->recommend_status;
            $saved=$package->save();

            return redirect(route('admin.package.index'))->with('message', 'Record Successfully Update');
          }
        }
        else
        {
          $package->package_name=$request->package_name;
          $package->description=$request->description;
          $package->price=$request->price;
          $package->duration=$request->duration;
          $package->recommend_status = $request->recommend_status;
          $saved=$package->save();

          return redirect(route('admin.package.index'))->with('message', 'Record Successfully Update');
        }
    }

    public function destroy(Package $package)
    {
        DB::beginTransaction();
        $affected = DB::table('packages')
                ->where('id', $package->id)
                ->update([
                  'status' => 0,
                  'deleted_at' => Carbon::now()
                ]);
        if ($affected) {
          DB::commit();
          return redirect(route('admin.package.index'))->with('message', 'Package Successfully Deleted');
        }
        else {
          DB::rollback();
          return redirect(route('admin.package.index'))->with('message', 'Error! An unhandled exception occured');
        }
    }

    public function ban($id)
    {
        DB::beginTransaction();
        $affected = DB::table('packages')
                ->where('id', $id)
                ->update([
                  'status' => 0,
                  'updated_at' => Carbon::now()
                ]);
        if ($affected) {
          DB::commit();
          return redirect(route('admin.package.index'))->with('message', 'Package Successfully Banned');
        }
        else {
          DB::rollback();
          return redirect(route('admin.package.index'))->with('message', 'Error! An unhandled exception occured');
        }
    }

    public function active($id)
    {
      $package_details = DB::table('packages')
                  ->where('status', 1)
                  ->where('deleted_at', null)
                  ->count();

      if ($package_details >= 3) {
        return redirect(route('admin.package.index'))->with('error', 'Error! Maximum 3 Active Packages are allowed');
      }
      else {
        DB::beginTransaction();
        $affected = DB::table('packages')
                ->where('id', $id)
                ->update([
                  'status' => 1,
                  'updated_at' => Carbon::now()
                ]);
        if ($affected) {
          DB::commit();
          return redirect(route('admin.package.index'))->with('message', 'Package Successfully Activated');
        }
        else {
          DB::rollback();
          return redirect(route('admin.package.index'))->with('message', 'Error! An unhandled exception occured');
        }
      }
    }
}

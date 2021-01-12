<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ProfileEmailCreate()
    {
        $user_id = Auth::id();
        $profile_details = DB::table('profiles')
                ->where('user_id', $user_id)
                ->get();

        return view('admin.profile.create', compact('profile_details'));
    }

    public function ProfileEmailUpdate(Request $request)
    {
      $id = Auth::user()->id;
      $updatedEmail = $request->post('email');
      DB::beginTransaction();
      $affected = DB::table('users')
              ->where('id', $id)
              ->update([
                'email' => $updatedEmail,
                'updated_at' => Carbon::now()
              ]);
      if ($affected) {
        DB::commit();
        return redirect(url('admin/logout'))->with('message','Email Updated Successfully');
      }
      else {
        DB::rollback();
        return redirect(url('admin/profile/create'))->with('error','Error! An Unhandled Exception Occurred');
      }
    }

    public function ProfilePasswordCreate()
    {
      return view('admin.profile.index');
    }

    public function ProfilePasswordUpdate(Request $request)
    {
      $id = Auth::user()->id;
      $Password = $request->post('new_password');
      $ConfirmPassword = $request->post('new_confirm_password');
      if($Password == $ConfirmPassword)
      {
        if(strlen($Password) >= 8)
        {
          $Password = Hash::make($Password);
          DB::beginTransaction();
          $affected = DB::table('users')
                  ->where('id', $id)
                  ->update([
                    'password' => $Password,
                    'updated_at' => Carbon::now()
                  ]);
          if ($affected) {
            DB::commit();
            return redirect(url('admin/logout'))->with('message','Password Updated Successfully');
          }
          else {
            DB::rollback();
            return redirect(url('admin/profile/create'))->with('error','Error! An Unhandled Exception Occurred');
          }
        }
        else
        {
          return redirect(url('admin/profile/create'))->with('error','Error! Minimum Password Length is 8 Characters');
        }
      }
      else
      {
        return redirect(url('admin/profile/create'))->with('error','Password and Confirm Password Not Matched');
      }
    }

    public function UpdateAdminProfileData(Request $request)
    {
      $profileId = $request->post('profile_id');
      $name    = $request->post('name');
      $address = $request->post('address');
      $phone   = $request->post('phone');
      $previous_filename = $request->post('previous_filename');

      if($request->hasFile('profile_image')){

        $path = storage_path().'/app/public/profile/'. $previous_filename;
        if($previous_filename != ""){
          if (Storage::disk('profile')->exists($previous_filename)) {
            if($previous_filename != "dummy.jpg")
            {
              unlink($path);
            }
          }
        }
        $FileName  = $name;
        $Extension = $request->file('profile_image')->extension();
        $FileName  = $FileName . '-' . rand(10000,99999999) . '.' . $Extension;
        $result    = $request->file('profile_image')->storeAs('/public/profile/', $FileName);

        DB::beginTransaction();
        $affected = DB::table('profiles')
                ->where('id', $profileId)
                ->update([
                  'full_name'  => $name,
                  'address'    => $address,
                  'phone'      => $phone,
                  'image'      => $FileName,
                  'updated_at' => Carbon::now()
                ]);
        if($affected){
          DB::commit();
          // Update Sessions
          Session::put('name', $name);
          Session::put('profile', $FileName);
          return redirect(url('/admin/profile/create'))->with('message','Profile Updated Successfully');
        }
        else {
          DB::rollback();
          return redirect(url('/admin/profile/create'))->with('error','Error! An unhandled error exception');
        }
      }
      else {
        DB::beginTransaction();
        $affected = DB::table('profiles')
                ->where('id', $profileId)
                ->update([
                  'full_name' => $name,
                  'address' => $address,
                  'phone' => $phone,
                  'updated_at' => Carbon::now()
                ]);
        if($affected){
          DB::commit();
          // Update Session
          Session::put('name', $name);
          return redirect(url('/admin/profile/create'))->with('message','Profile Updated Successfully');
        }
        else {
          DB::rollback();
          return redirect(url('/admin/profile/create'))->with('error','Error! An unhandled error exception');
        }
      }
    }

    // Company Profile - Start
    public function CompanyProfileCreate()
    {
      $user_id = Auth::id();
      $profile_details = DB::table('profiles')
              ->where('user_id', $user_id)
              ->get();

      $user = User::find($user_id);

      return view('company.profile.create', compact('profile_details', 'user'));
    }

    public function CompanyProfileEmailUpdate(Request $request)
    {
      $id = Auth::user()->id;
      $updatedEmail = $request->post('email');
      DB::beginTransaction();
      $affected = DB::table('users')
              ->where('id', $id)
              ->update([
                'email' => $updatedEmail,
                'updated_at' => Carbon::now()
              ]);
      if ($affected) {
        DB::commit();
        return redirect(url('company/logout'))->with('message','Email Updated Successfully');
      }
      else {
        DB::rollback();
        return redirect(url('company/profile/create'))->with('error','Error! An Unhandled Exception Occurred');
      }
    }

    public function CompanyProfilePasswordUpdate(Request $request)
    {
      $id = Auth::user()->id;
      $Password = $request->post('new_password');
      $ConfirmPassword = $request->post('new_confirm_password');
      if($Password == $ConfirmPassword)
      {
        if(strlen($Password) >= 8)
        {
          $Password = Hash::make($Password);
          DB::beginTransaction();
          $affected = DB::table('users')
                  ->where('id', $id)
                  ->update([
                    'password' => $Password,
                    'updated_at' => Carbon::now()
                  ]);
          if ($affected) {
            DB::commit();
            return redirect(url('company/logout'))->with('message','Password Updated Successfully');
          }
          else {
            DB::rollback();
            return redirect(url('company/profile/create'))->with('error','Error! An Unhandled Exception Occurred');
          }
        }
        else
        {
          return redirect(url('company/profile/create'))->with('error','Error! Minimum Password Length is 8 Characters');
        }
      }
      else
      {
        return redirect(url('company/profile/create'))->with('error','Password and Confirm Password Not Matched');
      }
    }

    public function UpdateCompanyProfileData(Request $request)
    {
      $profileId = $request->post('profile_id');
      $name    = $request->post('name');
      $address = $request->post('address');
      $phone   = $request->post('phone');
      $previous_filename = $request->post('previous_filename');

      if($request->hasFile('profile_image')){

        $path = storage_path().'/app/public/profile/'. $previous_filename;
        if($previous_filename != ""){
          if (Storage::disk('profile')->exists($previous_filename)) {
            if($previous_filename != "dummy.jpg")
            {
              unlink($path);
            }
          }
        }
        $FileName  = $name;
        $Extension = $request->file('profile_image')->extension();
        $FileName  = $FileName . '-' . rand(10000,99999999) . '.' . $Extension;
        $result    = $request->file('profile_image')->storeAs('/public/profile/', $FileName);

        DB::beginTransaction();
        $affected = DB::table('profiles')
                ->where('id', $profileId)
                ->update([
                  'full_name'  => $name,
                  'address'    => $address,
                  'phone'      => $phone,
                  'image'      => $FileName,
                  'updated_at' => Carbon::now()
                ]);
        if($affected){
          DB::commit();
          // Update Sessions
          Session::put('name', $name);
          Session::put('profile', $FileName);
          return redirect(url('/company/profile/create'))->with('message','Profile Updated Successfully');
        }
        else {
          DB::rollback();
          return redirect(url('/company/profile/create'))->with('error','Error! An unhandled error exception');
        }
      }
      else {
        DB::beginTransaction();
        $affected = DB::table('profiles')
                ->where('id', $profileId)
                ->update([
                  'full_name' => $name,
                  'address' => $address,
                  'phone' => $phone,
                  'updated_at' => Carbon::now()
                ]);
        if($affected){
          DB::commit();
          // Update Sessions
          Session::put('name', $name);
          return redirect(url('/company/profile/create'))->with('message','Email Updated Successfully');
        }
        else {
          DB::rollback();
          return redirect(url('/company/profile/create'))->with('error','Error! An unhandled error exception');
        }
      }
    }

    public function CompanyProfileCardUpdate(Request $request)
    {
        $Card_Number  = $request->post('card_number');
        $Expiry_Month = $request->post('expiry_month');
        $Cvc          = $request->post('cvc');
        $Expiry_Year  = $request->post('expiry_year');
        $id           = Auth::user()->id;
        $user         = User::find($id);
        if($user->stripe_customer_id == null){
            $createCustomerToStripeResponse = $this->registerCustomerToStripe($id);
            if($createCustomerToStripeResponse =="error")
            {
                return redirect(url('/company/profile/create'))->with('error','Error! An unhandled error exception');
            }
            else
            {
                $addCardToStripeResponse = $this->addCardToStripe($id, $Card_Number, $Expiry_Month, $Cvc, $Expiry_Year, $createCustomerToStripeResponse);

                if($addCardToStripeResponse)
                {
                    return redirect(url('/company/profile/create'))->with('message','Profile Updated Successfully');
                }
                else
                {
                    return redirect(url('/company/profile/create'))->with('error','Error! An unhandled error exception');
                }
            }
        }
        else{
            $addCardToStripeResponse = $this->updateCardToStripe($id,$Card_Number,$Expiry_Month,$Cvc,$Expiry_Year,$user->stripe_customer_id);
            if($addCardToStripeResponse == 1)
            {
                return redirect(url('/company/profile/create'))->with('message','Profile Updated Successfully');
            }
            else
            {
                return redirect(url('/company/profile/create'))->with('error', $addCardToStripeResponse);
            }
        }
    }

    public function registerCustomerToStripe($id)
    {
        $user = User::find($id);
        if ($user) {
            if($user->stripe_customer_id)
            {
                return $user->stripe_customer_id;
            }else
            {
                $customer = Stripe::customers()->create([
                    'email' => $user->email,
                ]);
                if ($customer['id']) {
                    $user->stripe_customer_id = $customer['id'];
                    $user->save();
                    return $customer['id'];
                } else {
                    return "error";
                }
            }
        } else {
            return response()->json(array('message'=> 'User not found.'), 404);
        }
    }

    public function addCardToStripe($userId, $card_number, $card_exp_month, $card_cvc, $card_exp_year, $createCustomerToStripeResponse)
    {
        $user = User::find($userId);
        try {
            if($user->card_number != $card_number)
            {
                $token = Stripe::tokens()->create([
                    'card' => [
                        'number'    => $card_number,
                        'exp_month' => $card_exp_month,
                        'cvc'       => $card_cvc,
                        'exp_year'  => $card_exp_year,
                    ],
                ]);

                $card = Stripe::cards()->create($createCustomerToStripeResponse, $token['id']);
                $user->stripe_card_id = $card['id'];

                $user->card_number = $card_number;
                $user->card_exp_month = $card_exp_month;
                $user->card_cvc = $card_cvc;
                $user->card_exp_year = $card_exp_year;
                if ($user->save()) {
                    return true;
                }
            }else
            {
                if($user->stripe_customer_id != null && $user->stripe_card_id != null)
                {
                    $findCard = Stripe::cards()->find($user->stripe_customer_id, $user->stripe_card_id );
                    if($findCard){
                        return true;
                    }else
                    {
                        return "Card Not Found";
                    }
                }
                else
                {
                    return "Add your card";
                    // return redirect()->back()->withErrors("Add your card");
                }
            }
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return $e->getMessage();
        }
    }

    public function updateCardToStripe($userId, $card_number, $card_exp_month, $card_cvc, $card_exp_year, $createCustomerToStripeResponse)
    {
        $user = User::find($userId);
        try {
            if($user->card_number != $card_number)
            {
                $response = $this->addCardToStripe($userId, $card_number, $card_exp_month, $card_cvc, $card_exp_year, $createCustomerToStripeResponse);
                // return redirect()->back()->with('message', 'Card Updated Successfully.');
                return $response;
            }else
            {
                $token = Stripe::tokens()->create([
                        'card' => [
                            'number'    => $card_number,
                            'exp_month' => $card_exp_month,
                            'cvc'       => $card_cvc,
                            'exp_year'  => $card_exp_year,
                        ],
                    ]);
                Stripe::cards()->delete($user->stripe_customer_id, $user->stripe_card_id );

                $card = Stripe::cards()->create($createCustomerToStripeResponse, $token['id']);
                $user->stripe_card_id = $card['id'];
                $user->card_number = $card_number;
                $user->card_exp_month = $card_exp_month;
                $user->card_cvc = $card_cvc;
                $user->card_exp_year = $card_exp_year;
                if ($user->save()) {
                    return true;
                }
            }
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return false;
        }
    }
}

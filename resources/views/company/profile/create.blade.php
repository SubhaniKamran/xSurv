@extends('company.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            @if(session()->has('message'))
              <div class="alert alert-success mt-4">
                {{ session('message') }}
              </div>
            @elseif(session()->has('error'))
              <div class="alert alert-danger mt-4">
                {{ session('error') }}
              </div>
            @endif
        </div>

        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Change Profile</h4>
                    <form method="POST" action="{{url('company/profile/data/update')}}" enctype="multipart/form-data">
                        @csrf
                        <!-- @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input type="hidden" name="profile_id" value="{{$profile_details[0]->id}}" />
                                <input id="name" type="text" class="form-control" value="{{ $profile_details[0]->full_name }}" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                            <div class="col-md-6">
                                <textarea class="form-control" rows="3" name="address">{{ $profile_details[0]->address }}</textarea>
                                <!-- <input id="address" type="text" class="form-control" value="{{ $profile_details[0]->address }}" name="address"> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" value="{{ $profile_details[0]->phone }}" name="phone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Profile</label>
                            <div class="col-md-6">
                                <input type="hidden" name="previous_filename" value="{{ $profile_details[0]->image }}" />
                                <input id="profile_image" type="file" class="form-control" name="profile_image">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Profile
                                </button>
                            </div>
                        </div>
                    </form><!--end form-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!-- end col -->

        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Change Email <small>(you will be logout)</small></h4>
                    <form method="POST" action="{{url('company/profile/email/update')}}">
                        @csrf
                        <!-- @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach -->
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" value="{{ Auth::user()->email }}" name="email" autocomplete="current-password">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Email
                                </button>
                            </div>
                        </div>
                    </form><!--end form-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!-- end col -->

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Change Password <small>(you will be logout)</small></h4>
                    <form method="POST" action="{{ url('company/profile/password/update') }}">
                        @csrf
                        <!-- @foreach ($errors->all() as $error)
                          <p class="text-danger">{{ $error }}</p>
                        @endforeach -->
                        <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
                          <div class="col-md-6">
                              <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password" required>
                          </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>
                            <div class="col-md-6">
                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password" required>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form><!--end form-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!-- end col -->

        <!-- Start of Credit/Debet Card setting -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Credit/Debit Card</h4>
                    <form method="POST" action="{{ url('company/profile/card/update') }}">
                        @csrf
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                        <div class="form-group row">
                          <label for="card_number" class="col-md-4 col-form-label text-md-right">Card Number</label>
                          <div class="col-md-6">
                              <input id="card_number" type="number" class="form-control" name="card_number" onkeypress="validateCardLength(event);" placeholder="4242424242424242" value="{{$user->card_number}}" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="expiry_month" class="col-md-4 col-form-label text-md-right">Expiry Month</label>
                          <div class="col-md-6">
                              <input id="expiry_month" type="number" class="form-control" name="expiry_month" onkeypress="validateExpiryMonthLength(event);" placeholder="01" value="{{$user->card_exp_month}}" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="cvc" class="col-md-4 col-form-label text-md-right">CVC</label>
                          <div class="col-md-6">
                              <input id="cvc" type="number" class="form-control" name="cvc" onkeypress="validateCVCLength(event);" placeholder="123" value="{{$user->card_cvc}}" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="expiry_year" class="col-md-4 col-form-label text-md-right">Expiry Year</label>
                          <div class="col-md-6">
                              <input id="expiry_year" type="number" class="form-control" name="expiry_year" onkeypress="validateExpiryYearLength(event);" placeholder="2020" value="{{$user->card_exp_year}}" required>
                          </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form><!--end form-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!-- end col -->
    </div>
@endsection

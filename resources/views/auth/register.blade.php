@extends('auth.layouts.app')
@section('content')

<div class="auth-page" style="margin-top: 50px;">
    <div class="card auth-card shadow-lg">
        <div class="card-body">
            <div class="px-3">
                <div class="auth-logo-box">
                    <a href="../dashboard/analytics-index.html" class="logo logo-admin"><img src="{{ asset('public/storage/logo/' . $logo) }}" height="55" alt="logo" class="auth-logo"></a>
                </div><!--end auth-logo-box-->

                <div class="text-center auth-logo-text">
                    <h4 class="mt-0 mb-3 mt-5">Free Register for X-Survey</h4>
                    <p class="text-muted mb-0">Get your free X-Survey account now.</p>
                </div> <!--end auth-logo-text-->

                <form class="form-horizontal auth-form my-4" method="post" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="username">{{ __('Company Name') }}</label>
                        <div class="input-group mb-3">
                            <span class="auth-form-icon">
                                <i class="dripicons-user"></i>
                            </span>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" id="username" placeholder="Enter Company Name" required>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div><!--end form-group-->

                    <div class="form-group">
                        <label for="useremail">{{ __('E-Mail') }}</label>
                        <div class="input-group mb-3">
                            <span class="auth-form-icon">
                                <i class="dripicons-mail"></i>
                            </span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="useremail" name="email" value="{{ old('email') }}" placeholder="Enter Email" required>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div><!--end form-group-->
                    <div class="form-group">
                        <label for="mo_number">{{ __('Mobile Number') }}</label>
                        <div class="input-group mb-3">
                            <span class="auth-form-icon">
                                <i class="dripicons-phone"></i>
                            </span>
                            <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" id="mo_number" placeholder="Enter Mobile Number" required>
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div><!--end form-group-->
                    <div class="form-group">
                        <label for="address">{{ __('Address') }}</label>
                        <div class="input-group mb-3">
                            <span class="auth-form-icon">
                                <i class="dripicons-mail"></i>
                            </span>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" id="address" placeholder="Enter Address" required>
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div><!--end form-group-->
                    <div class="form-group">
                        <label for="userpassword">Password</label>
                        <div class="input-group mb-3">
                            <span class="auth-form-icon">
                                <i class="dripicons-lock"></i>
                            </span>
                            <input type="password" class="form-control   @error('password') is-invalid @enderror" id="userpassword" value="{{ old('password') }}" placeholder="Enter password" name="password"  autocomplete="new-password" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div><!--end form-group-->

                    <div class="form-group">
                        <label for="conf_password">Confirm Password</label>
                        <div class="input-group mb-3">
                          <span class="auth-form-icon">
                              <i class="dripicons-lock-open"></i>
                          </span>
                          <input type="password" class="form-control" id="conf_password" name="password_confirmation"  autocomplete="new-password" placeholder="Enter Confirm Password" required>
                        </div>
                    </div><!--end form-group-->

                    <div class="form-group row mt-4">
                        <div class="col-sm-12">
                            <div class="custom-control custom-switch switch-success">
                                <input type="checkbox" class="custom-control-input" id="customSwitchSuccess" required>
                                <label class="custom-control-label text-muted" for="customSwitchSuccess">By registering you agree to the X Survey <a href="{{url('terms_conditions')}}" class="text-primary">Terms of Use</a></label>
                            </div>
                        </div><!--end col-->
                    </div><!--end form-group-->

                    <div class="form-group mb-0 row">
                        <div class="col-12 mt-2">
                            <button class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light" type="submit"> {{ __('Register') }} <i class="fas fa-sign-in-alt ml-1"></i></button>
                        </div><!--end col-->
                    </div> <!--end form-group-->
                </form><!--end form-->
            </div><!--end /div-->

            <div class="m-3 text-center text-muted">
                <p class="">Already have an account ? <a href="{{ route('login') }}" class="text-primary ml-2">Log in</a></p>
            </div>
        </div><!--end card-body-->
    </div><!--end card-->
</div>
@endsection

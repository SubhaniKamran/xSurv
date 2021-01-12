@extends('auth.layouts.app')
@section('content')
<div class="auth-page" style="margin-top: 20px;">
    <div class="row mb-5">
      <div class="col-12">
          @if(session()->has('message'))
              <div class="alert alert-success">
                {{ session('message') }}
              </div>
          @elseif(session()->has('error'))
              <div class="alert alert-danger">
                {{ session('error') }} Contact us at <a class="text-white" href="{{url('/#contact')}}"><u>support</u></a>
              </div>
          @endif
      </div>
    </div>
    <div class="card auth-card shadow-lg">
        <div class="card-body">
            <div class="px-3">
                <div class="auth-logo-box">
                    <a href="../dashboard/analytics-index.html" class="logo logo-admin"><img src="{{ asset('public/storage/logo/' . $logo) }}" height="55" alt="logo" class="auth-logo"></a>
                </div><!--end auth-logo-box-->

                <div class="text-center auth-logo-text">
                    <h4 class="mt-0 mb-3 mt-5">Let's Get Started X-Survey</h4>
                    <p class="text-muted mb-0">Sign in to continue to X-Survey.</p>
                </div> <!--end auth-logo-text-->
                    <form class="form-horizontal auth-form my-4" method="POST" action="{{ route('login') }}">
                        @csrf
                    <div class="form-group">
                        <label for="username">{{ __('E-Mail Address') }}</label>
                        <div class="input-group mb-3">
                            <span class="auth-form-icon">
                                <i class="dripicons-user"></i>
                            </span>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="username" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div><!--end form-group-->

                    <div class="form-group">
                        <label for="userpassword">{{ __('Password') }}</label>
                        <div class="input-group mb-3">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-lock"></i>
                                                </span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="userpassword" placeholder="Enter password" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div><!--end form-group-->

                    <div class="form-group row mt-4">
                        <div class="col-sm-6">
                            <div class="custom-control custom-switch switch-success">
                                <input type="checkbox" name="remember" class="custom-control-input" id="customSwitchSuccess" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label text-muted" for="customSwitchSuccess">{{ __('Remember me') }}</label>
                            </div>
                        </div><!--end col-->
                        <div class="col-sm-6 text-right">
                            @if (Route::has('password.request'))
                                <a class="text-muted font-13" href="{{ route('password.request') }}"><i class="dripicons-lock"></i>
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif

                        </div><!--end col-->
                    </div><!--end form-group-->

                    <div class="form-group mb-0 row">
                        <div class="col-12 mt-2">
                            <button class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light" type="submit">  {{ __('Login') }} <i class="fas fa-sign-in-alt ml-1"></i></button>
                        </div><!--end col-->
                    </div> <!--end form-group-->
                </form><!--end form-->
            </div><!--end /div-->
            <div class="m-3 text-center text-muted">
                <p class="">Don't have an account ?  <a href="{{ route('register') }}" class="text-primary ml-2">  {{ __('Resister') }}</a></p>
            </div>
        </div><!--end card-body-->
    </div><!--end card-->
</div>
@endsection

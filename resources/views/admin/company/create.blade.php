@extends('admin.app')
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">@if(@$user)Edit Company @else Add Company @endif</h4>
                    <form @if(@$user) action="{{route('admin.company.update',$user->id)}}"
                          @else action="{{route('admin.company.store')}}" @endif method="post">
                        @csrf
                        @if(@$user)
                            @method('PUT')
                        @endif
                        <div class="form-group mt-4">
                            <label>Company Name</label>
                            <input type="text" name="company_name" value="{{ @$user->profile->full_name}}"
                                   class="form-control @error('company_name') parsley-error @enderror "
                                   placeholder="Company Name" data-parsley-id="5">
                            @error('company_name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div><!--end form-group-->
                        <div class="form-group">
                            <label>E-Mail</label>
                            <div>
                                <input type="email" name="email" value="{{@$user->email}}"
                                       class="form-control @error('email') parsley-error @enderror" parsley-type="email"
                                       placeholder="Enter a valid e-mail" data-parsley-id="11">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><!--end form-group-->
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" value="{{@$user->profile->address}}"
                                   class="form-control @error('address') parsley-error @enderror" placeholder="Address"
                                   data-parsley-id="13">
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div><!--end form-group-->
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="number" name="phone" value="{{@$user->profile->phone}}"
                                   class="form-control @error('phone') parsley-error @enderror"
                                   placeholder="Enter Phone Number" data-parsley-id="15">
                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div><!--end form-group-->
                        @if(! @$user)
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="password" id="pass2"
                                       class="form-control @error('password') parsley-error @enderror"
                                       placeholder="New Password" data-parsley-id="7">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div><!--end form-group-->
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control "
                                       placeholder="Confirm New Password" data-parsley-id="19">
                            </div><!--end form-group-->
                        @endif
                        <div class="form-group mb-0">
                            <input type="submit" name="submit" class="btn btn-gradient-primary waves-effect waves-light"
                                   @if(@$user)value="Update" @else value="Submit"@endif>
                        </div><!--end form-group-->
                    </form><!--end form-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!-- end col -->
    </div>
@endsection

@extends('admin.app')

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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Change Password</h4>
                    <form method="POST" action="{{ url('admin/profile/password/update') }}">
                        @csrf
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
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
    </div>
@endsection

@extends('company.layouts.app')
@section('content')
<style>
.dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate{
  display: none;
}
</style>
    <br>
    <br>
    <form method="POST" class="form-horizontal well" action="{{url('/googlereview/store')}}">
        @csrf
        <div class="row">
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
          <br>
          <div class="col-md-12">
            <div class="alert alert-info" role="alert">
              <div>
                <h4>Instructions</h4>
                <ol>
                  <li>Visit Google Place ID <a href="https://developers.google.com/places/web-service/place-id" target="_blank">https://developers.google.com/places/web-service/place-id</a></li>
                  <li>In the ‘Enter a location‘ field search your company name</li>
                  <li>Your Place ID will appear in the popover and you will just need to copy it</li>
                  <li>And paste this ID number in X Survey Url</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          @if($google_review == 0)
          <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <h4 class="mt-0 header-title">Google Review</h4>
                      <div class="form-group mt-4">
                        <label for="service_name">Google Place ID</label>
                          <input id="google_url" type="text" class="form-control" name="google_url" required>
                      </div>
                  </div>
              </div>
          </div>
         @endif
        </div>
        <div class="form-group row mb-0">
          <div class="col-sm-12">
            @if($google_review > 0)

            @else
              <input type="submit" value="Add" name="add" class="btn btn-gradient-primary">
            @endif
          </div>
        </div>
        </form>
        <br>
        <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <h4 class="mt-0 header-title">Google URl</h4>
                      <table id="table_google_url" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                          <thead>
                          <tr role="row">
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 75%;">URL</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;" >Action</th>
                          </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
        </div>

    @include('company.setting.editGoogleReviewModal')
@endsection

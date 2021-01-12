@extends('admin.app')
@section('content')
    <br>
    <br>
    <form method="POST" class="form-horizontal well" action="{{url('admin/settings/logo/store')}}" enctype="multipart/form-data">
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
        </div>
        <div class="row">
          @if($google_settings_logo_check == 0)
          <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <h4 class="mt-0 header-title">X Survey Logo</h4>
                      <div class="form-group mt-4">
                        <label for="service_name">Add Logo</label>
                          <input id="logo_url" type="file" class="form-control" name="logo_url" accept="image/x-png,image/gif,image/jpeg" required>
                      </div>
                  </div>
              </div>
          </div>
         @endif
        </div>
        <div class="form-group row mb-0">
          <div class="col-sm-12">
            @if($google_settings_logo_check > 0)

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
                      <h4 class="mt-0 header-title">Logo</h4>
                      <table id="table_general_settings_url" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                          <thead>
                          <tr role="row">
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;" >Sr#</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 75%;">Logo</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;" >Action</th>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach($google_settings_logo as $logo)
                              <tr>
                                <td>1</td>
                                <td><img src="{{ asset('public/storage/logo/' . $logo->logo_url) }}" alt="XSurvey Logo" title="Logo" width="150" height="150" class="img-fluid"></td>
                                <td><a href="javascript:void(0);" id="{{$logo->logo_url}}" onclick="editGeneralSettingsLogo(this.id);"><button class="btn btn-info btn-sm"><i class="ti-pencil"></i></button></a></td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
       </div>
    @include('admin.setting.editGeneralSettingLogoModal')
@endsection

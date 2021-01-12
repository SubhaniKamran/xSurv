@extends('admin.app')
@section('content')
        <br>
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
      <br>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title">Notification Settings</h4>
                <table id="table_notification_setting" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                  <thead>
                  <tr role="row">
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;" >Sr#</th>
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 70%;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;" >Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($notification_setting as $setting)
                      <tr>
                        <td>1</td>
                        <td>
                          @if($setting->status == 1)
                            <span class="badge badge-success">Enabled</span>
                          @else
                            <span class="badge badge-danger">Disable</span>
                          @endif
                        </td>
                        <td>
                          @if($setting->status == 1)
                            <a href="{{url('admin/notification/setting/disable/'. $setting->id)}}"><button class="btn btn-danger">Disable</button></a>
                          @else
                            <a href="{{url('admin/notification/setting/enable/'. $setting->id)}}"><button class="btn btn-success">Enable</button></a>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
         </div>
       </div>
    </div>
@endsection

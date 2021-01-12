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
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-4">All Packages</h4>
                      <table id="table_packages" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                          <thead>
                          <tr role="row">
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 20%;">Package Name</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Price</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Duration</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Status</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Recommend</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Action</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;" >Active/Ban</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($packages as $package)
                          <tr role="row" class="odd">
                              <td tabindex="0" class="sorting_1">{{$package->package_name}}</td>
                              <td>${{$package->price}}</td>
                              <td>{{$package->duration}}</td>
                              <td>
                                @if($package->status == 1)
                                  <span class="badge badge-success">Active</span>
                                @else
                                  <span class="badge badge-danger">Ban</span>
                                @endif
                              </td>
                              <td>{{ucwords($package->recommend_status)}}</td>
                              <td> <a href="javascript:;" onclick="adminPackageDelete('{{$package->id}}')"><span class="btn btn-sm btn-danger"><i class="ti-trash"></i></span></a>
                                <form id="delete-package-{{$package->id}}" action="{{ route('admin.package.destroy',$package->id) }}" method="POST" style="display: none;">
                                    @method('DELETE')
                                    @csrf
                                </form> | <a href="{{ route('admin.package.edit',$package->id) }}"><button class="btn btn-info btn-sm"><i class="ti-pencil"></i></button></a>
                              </td>
                              <td class="highlight">
                                @if($package->status == 1)
                                  <a href="{{url("admin/package/ban/". $package->id)}}"><button class="btn btn-danger">Ban</button></a>
                                @else
                                  <a href="{{url("admin/package/active/". $package->id)}}"><button class="btn btn-success">Active</button></a>
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
      @include('admin.package.deletePackageModal')
    <script type="text/javascript">
        // function confirmPackageDelete(id)
        // {
        //     let choice = confirm("Are you sure, You want to Delete this record?");
        //     if(choice)
        //     {
        //         document.getElementById('delete-package-'+id).submit();
        //     }
        // }
    </script>
@endsection

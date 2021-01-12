@extends('admin.app')

@section('content')
    <div class="row">
        <div class="col-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
        <br>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">All Companies</h4>
                      <table id="row_callback" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                          <thead>
                          <tr role="row">
                              <th class="sorting_asc" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 153px;" >Company Name</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 235px;" >Email</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 110px;" >Address</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 47px;" >Phone</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 47px;" >Status</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 99px;" >Action</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 84px;" >Active/Ban</th>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach($users as $user)
                                @if($user->role_id!=2)
                             <tr role="row" class="odd">
                                <td tabindex="0" class="sorting_1">{{@$user->profile->full_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{@$user->profile->address}}</td>
                                <td>{{@$user->profile->phone}}</td>
                                <td>@if($user->status == 1)<span class="badge badge-success">Active</span> @else <span class="badge badge-danger">Ban</span> @endif</td>
                                <td>
                                     <a href="{{url("admin/company/details/". $user->id)}}"><button class="btn btn-info"><i class="ti-eye"></i></button></a>
                                     <a href="javascript:;" onclick="confirmDelete('{{$user->id}}')"><span class="btn btn-sm btn-danger"><i class="ti-trash"></i></span></a>
                                     <form id="delete-company-{{$user->id}}" action="{{ route('admin.company.destroy',$user->id) }}" method="POST" style="display: none;">
                                       @method('DELETE')
                                       @csrf
                                     </form>
                                     <a href="{{ route('admin.company.edit',$user->id) }}"><button class="btn btn-info"><i class="ti-pencil-alt"></i></button></a>
                                </td>
                                <td class="highlight">
                                   @if($user->status==1)
                                    <a href="{{url("admin/company/ban/". $user->id)}}"><button class="btn btn-danger">Ban</button></a>
                                  @else
                                    <a href="{{url("admin/company/active/". $user->id)}}"><button class="btn btn-success">Active</button></a>
                                  @endif
                                </td>
                            </tr>
                            @endif
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
      @include('admin.company.deleteCompanyModal')
      @endsection

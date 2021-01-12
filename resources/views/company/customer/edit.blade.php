@extends('company.layouts.app')
@section('content')
    <br>
    <br>
    <form method="POST" class="form-horizontal well" action="{{url('/customer/update')}}">
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
          <div class="col-12">
              <input type="hidden" name="customerId" value="{{$customer[0]->id}}" />
              <div class="card">
                  <div class="card-body">
                      <h4 class="mt-0 header-title">Edit Customer</h4>
                      <div class="form-group mt-4">
                        <label for="client_name">Client Name</label>
                        <input id="client_name" type="text" class="form-control" name="client_name" value="{{$customer[0]->client_name}}" required>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{$customer[0]->email}}" required>
                      </div>
                      <div class="form-group">
                        <label for="phone">Phone</label>
                        <input id="phone" type="number" class="form-control" name="phone" value="{{$customer[0]->phone}}" required>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <div class="form-group row mb-5">
            <div class="col-sm-12">
                <a href="{{url('/customer/all')}}" class="btn btn-gradient-info">Cancel</a>
                <input type="submit" value="Update" name="update" class="btn btn-gradient-primary">
            </div>
        </div>
    </form>
@endsection

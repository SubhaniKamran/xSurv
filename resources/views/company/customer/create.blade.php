@extends('company.layouts.app')
@section('content')
    <br>
    <br>
    <form method="POST" class="form-horizontal well" action="{{url('/customer/store')}}">
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
              <div class="card">
                  <div class="card-body">
                      <h4 class="mt-0 header-title">Add New Customer</h4>
                      <div class="form-group mt-4">
                        <label for="client_name">Client Name</label>
                        <input id="client_name" type="text" class="form-control" name="client_name" required>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email" required>
                      </div>
                      <div class="form-group">
                        <label for="phone">Phone</label>
                        <input id="phone" type="number" class="form-control" name="phone" required>
                      </div>
                      <div class="form-group">
                        <label for="service">Service</label>
                        <select class="form-control" name="service" id="service" required>
                          <option value="" selected disabled>Select Service</option>
                          @foreach($services as $service)
                            <option value="{{$service->id}}">{{$service->service_name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <!-- <div class="form-group">
                        <label for="email_date">Email Date</label>
                        <input id="email_date" type="date" class="form-control" name="email_date" min="{{ now()->toDateString('Y-m-d') }}">
                      </div> -->
                  </div>
              </div>
          </div>
        </div>
        <div class="form-group row mb-5">
            <div class="col-sm-12">
                <input type="submit" value="Add" name="add" class="btn btn-gradient-primary">
            </div>
        </div>
    </form>
@endsection

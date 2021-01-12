@extends('company.layouts.app')
@section('content')
    <br>
    <br>
    <form method="POST" class="form-horizontal well" action="{{url('/service/store')}}">
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
                      <h4 class="mt-0 header-title">Add New Service</h4>
                      <div class="form-group mt-4">
                        <label for="service_name">Service Name</label>
                        <input id="service_name" type="text" class="form-control" name="service_name" required>
                      </div>
                      <div class="form-group">
                        <label for="service_name">Survey</label>
                        <select class="form-control" name="survey" id="survey" required>
                          <option value="" selected disabled>Select Survey</option>
                            @foreach($surveys as $survey)
                              <option value="{{$survey->id}}">{{$survey->template_name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-sm-12">
                <input type="submit" value="Add" name="add" class="btn btn-gradient-primary">
            </div>
        </div>
    </form>
@endsection

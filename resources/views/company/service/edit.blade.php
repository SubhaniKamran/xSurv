@extends('company.layouts.app')
@section('content')
    <br>
    <br>
    <form method="POST" class="form-horizontal well" action="{{url('/service/update')}}">
        @csrf
        <input type="hidden" name="serviceId" value="{{$service[0]->id}}" />
        <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <h4 class="mt-0 header-title">Edit Service</h4>
                      <div class="form-group mt-4">
                        <label for="service_name">Service Name</label>
                        <input id="service_name" type="text" class="form-control" name="service_name" value="{{$service[0]->service_name}}" required>
                      </div>
                      <div class="form-group">
                        <label for="service_name">Survey</label>
                        <select class="form-control" name="survey" id="survey" required>
                          <option value="" selected disabled>Select Survey</option>
                            @foreach($surveys as $survey)
                              @if($survey->id == $service[0]->survey_id)
                                <option value="{{$survey->id}}" selected>{{$survey->template_name}}</option>
                              @else
                                <option value="{{$survey->id}}">{{$survey->template_name}}</option>
                              @endif
                            @endforeach
                        </select>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-sm-12">
                <a href="{{url('/service/all')}}" class="btn btn-gradient-info">Cancel</a>
                <input type="submit" value="Update" name="update" class="btn btn-gradient-primary">
            </div>
        </div>
    </form>
@endsection

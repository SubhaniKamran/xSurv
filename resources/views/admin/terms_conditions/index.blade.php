@extends('admin.app')

@section('content')
    <div class="row mt-3">
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
                    <h4 class="mt-0 header-title">
                      @if($terms_conditions_check > 0)
                      Edit Terms and Conditions
                      @else
                      Add Terms and Conditions
                      @endif
                    </h4>
                    <form action="{{url('admin/termsconditions/store')}}" method="post">
                        @csrf
                        <div class="form-group mt-4">
                            <label>Description</label>
                            <div>
                                <textarea id="elm1" name="description" aria-hidden="true" class="myTextEditor">{!! @$terms_conditions[0]->termscondition !!}</textarea>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                          @if($terms_conditions_check > 0)
                            <input type="submit" name="submit" class="btn btn-gradient-primary waves-effect waves-light" value="Update">
                          @else
                            <input type="submit" name="submit" class="btn btn-gradient-primary waves-effect waves-light" value="Add">
                          @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

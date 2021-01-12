@extends('admin.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">@if(@$package)Edit Package @else Add Packages @endif</h4>
                    <form  action="@if(@$package){{route('admin.package.update',$package->id)}} @else{{route('admin.package.store')}} @endif" method="post">
                        @csrf
                        @if(@$package)
                            @method('PUT')
                            <input type="hidden" name="package_id" value="{{$package->id}}" />
                        @endif
                        <div class="form-group mt-4">
                            <label>Package Name</label>
                            <input type="text" name="package_name" value="{{@$package->package_name}}" class="form-control @error('package_name') parsley-error @enderror" data-parsley-id="5">
                            @error('package_name')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <div>
                                <textarea id="elm1" name="description" aria-hidden="true" class="myTextEditor">{!! @$package->description !!}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input  type="number" name="price" value="{{@$package->price}}" class="form-control @error('price') parsley-error @enderror" data-parsley-id="13">
                            @error('price')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Duration (Month)</label>
                            <input  type="text" name="duration" value="{{@$package->duration}}" class="form-control @error('duration') parsley-error @enderror" data-parsley-id="15">
                            @error('duration')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        @if(@$package)
                          <label>Recommend Status</label>
                          <select class="form-control mb-3" name="recommend_status" id="recommend_status">
                            @if($package->recommend_status == "recommend")
                              <option value="recommend" selected>Recommend</option>
                              <option value="not recommend">Not Recommend</option>
                            @elseif($package->recommend_status == "not recommend")
                              <option value="recommend">Recommend</option>
                              <option value="not recommend" selected>Not Recommend</option>
                            @endif
                          </select>
                        @endif
                        <div class="form-group mb-0">
                          <input type="submit" name="submit" class="btn btn-gradient-primary waves-effect waves-light" value="@if(@$package)Edit Package @else Add Packages @endif">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

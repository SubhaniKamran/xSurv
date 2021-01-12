@extends('company.layouts.app')
@section('content')

    @if($company_google_id == 0)
      <br>
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-warning" role="alert">
          Warning! Company google review setting is incomplete. First go to settings and complete it.
          </div>
        </div>
      </div>
    @endif

    <form method="POST" class="form-horizontal well" action="{{url('/survey/templates/store')}}">
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
        </div>
        <input type="hidden" name="surveyId" value="{{$survey[0]->id}}" />
        <div class="row">
            <div class="col-12">
              <h4 class="text-center mt-4 mb-4">Save as your own survey</h4>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Survey Form</h4>
                        <div class="form-group ">
                            <label for="form_name">Template Name</label>
                            <input id="form_name" type="text" class="form-control" name="template_name" value="{{$survey[0]->template_name}}" />
                        </div>
                        <div class="form-group ">
                            <label for="form_description">Template Description</label>
                            <input id="form_description" type="text" class="form-control" name="template_description" value="{{$survey[0]->template_description}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <fieldset>
            <div class="repeater-custom-show-hide">
                <div data-repeater-list="question">
                    <?php
                    $TempArray = json_decode($survey[0]->question);
                    $Temp = implode(',' , $TempArray);
                    $Questions = explode(',', $Temp);
                    $RowCount = 0;
                    ?>
                    @foreach($Questions as $item)
                    <?php
                      $item = str_replace("~", ",", $item);
                    ?>
                        <div data-repeater-item="" style="">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group row  d-flex align-items-end">
                                                <div class="col-sm-8">
                                                    <div class="form-group ">
                                                        <label for="question">Question</label>
                                                        <input id="question" type="text" class="form-control"
                                                               name="question" placeholder="Question" value="{{$item}}" />
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-sm-8">
                                                    <div class="form-group " id="drd">
                                                        <label for="answer">Answer</label>
                                                        <input id="answer" disabled type="text" class="form-control"
                                                               name="answer" placeholder="Answer">
                                                    </div>
                                                    <span data-repeater-delete="" class="btn btn-gradient-danger btn-sm">
                                                    <span class="far fa-trash-alt mr-1"></span> Delete
                                                </span>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </div><!--end card-body-->
                                    </div><!--end card-->
                                </div> <!-- end col -->
                            </div>
                        </div>
                    @endforeach
                </div>
                <!--end repet-list-->

                <div class="form-group row mb-0">
                    <div class="col-sm-12">
                        <a href="{{url('/survey/templates')}}" class="btn btn-gradient-info">Cancel</a>
                        <span data-repeater-create="" class="btn btn-gradient-secondary btn-md">
                            <span class="fa fa-plus"></span>
                            Add
                        </span>
                        <input type="submit" value="Submit" name="submit" class="btn btn-gradient-primary" <?php if($company_google_id == 0){echo "disabled";} ?> >
                    </div><!--end col-->
                </div><!--end row-->
                <br>
            </div> <!--end repeter-->
        </fieldset><!--end fieldset-->
    </form><!--end form-->
@endsection

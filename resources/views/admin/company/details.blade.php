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
              <h4 class="mt-0 header-title">Company</h4>
                <table id="row_callback" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                  <thead>
                    <tr role="row">
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;" >Company Name</th>
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;">Email</th>
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Address</th>
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Phone</th>
                    </tr>
                  </thead>
                  <tbody>
                    	@foreach($profile_details as $details)
                        <tr>
                          <td>{{$details->Email}}</td>
                          <td>{{$details->FullName}}</td>
                          <td>{{$details->Address}}</td>
                          <td>{{$details->Phone}}</td>
                        </tr>
                      @endforeach
                  </tbody>
               </table>
          </div>
      </div>
  </div>
    <br/>
    <div class="col-12">
      <div class="card">
          <div class="card-body">
              <h4 class="mt-0 header-title">All Companies</h4>
                <table id="row_callback" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                  <thead>
                    <tr role="row">
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;" >Sr#</th>
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;">Client Name</th>
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Email</th>
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Service</th>
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;">Email Status</th>
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Reaction</th>
                      <!-- <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Email Date</th> -->
                      <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Template</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $counter = 1; ?>
                    	@foreach($company_details as $details)
                        <tr>
                          <td>{{$counter}}</td>
                          <td>{{$details->client_name}}</td>
                          <td>{{$details->email}}</td>
                          <td>{{$details->service_name}}</td>
                          <td>{{$details->email_status}}</td>
                          <td>{{$details->reaction_status}}</td>
                          <!-- <td>{{$details->email_date}}</td> -->
                          <td>
                            @if($details->reaction_status == "sad" || $details->reaction_status == "neutral")
                              <button class="btn btn-info mr-2" id="survey_{{$details->customer_service_id}}" onclick="ViewCustomerSurvey(this.id);"><i class="ti-eye"></i></button>
                            @elseif($details->reaction_status == "happy")
                              <i class="ti-face-smile" style="font-size: 20px;"></i>
                            @endif
                          </td>
                        </tr>
                        <?php $counter++; ?>
                      @endforeach
                  </tbody>
               </table>
          </div>
      </div>
  </div>
</div>
@include('admin.company.viewSurveyQuestionsModal')
<!-- </div>
</div> -->
@endsection

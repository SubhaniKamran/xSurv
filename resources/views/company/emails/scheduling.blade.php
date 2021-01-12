@extends('company.layouts.app')
@section('content')
    <style>
        #table_surveys_filter label{
            float: right;
        }
        #table_surveys_paginate ul{
            float: right;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div id="success-message">
                <div class="alert alert-success">
                    <strong>Message:&nbsp;&nbsp;</strong>
                    <span id="success-message-content"></span>
                </div>
            </div>
            <div id="error-message">
                <div class="alert alert-danger">
                    <strong>Message:&nbsp;&nbsp;</strong>
                    <span id="error-message-content"></span>
                </div>
            </div>
        </div>
    </div>

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
                    <h4 class="mt-0 header-title">Update Schedule for All Customer</h4>
                    <form method="POST" class="form-horizontal well" action="{{url('/scheduling/update/all')}}">
                        @csrf
                        <div class="row mt-4">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="email_date1">Email Date 1</label>
                              <select class="form-control" name="email_date1" id="email_date1" onchange="CreateEmailDate1(this.value);">
                                <option value="" selected>Select Days</option>
                                <option value="1" <?php if($email_date1 == 1){echo "selected";} ?> >1 Day</option>
                                <option value="2" <?php if($email_date1 == 2){echo "selected";} ?> >2 Days</option>
                                <option value="3" <?php if($email_date1 == 3){echo "selected";} ?> >3 Days</option>
                                <option value="4" <?php if($email_date1 == 4){echo "selected";} ?> >4 Days</option>
                                <option value="5" <?php if($email_date1 == 5){echo "selected";} ?> >5 Days</option>
                                <option value="6" <?php if($email_date1 == 6){echo "selected";} ?> >6 Days</option>
                                <option value="7" <?php if($email_date1 == 7){echo "selected";} ?> >7 Days</option>
                                <option value="8" <?php if($email_date1 == 8){echo "selected";} ?> >8 Days</option>
                                <option value="9" <?php if($email_date1 == 9){echo "selected";} ?> >9 Days</option>
                                <option value="10" <?php if($email_date1 == 10){echo "selected";} ?> >10 Days</option>
                                <option value="11" <?php if($email_date1 == 11){echo "selected";} ?> >11 Days</option>
                                <option value="12" <?php if($email_date1 == 12){echo "selected";} ?> >12 Days</option>
                                <option value="13" <?php if($email_date1 == 13){echo "selected";} ?> >13 Days</option>
                                <option value="14" <?php if($email_date1 == 14){echo "selected";} ?> >14 Days</option>
                                <option value="15" <?php if($email_date1 == 15){echo "selected";} ?> >15 Days</option>
                                <option value="16" <?php if($email_date1 == 16){echo "selected";} ?> >16 Days</option>
                                <option value="17" <?php if($email_date1 == 17){echo "selected";} ?> >17 Days</option>
                                <option value="18" <?php if($email_date1 == 18){echo "selected";} ?> >18 Days</option>
                                <option value="19" <?php if($email_date1 == 19){echo "selected";} ?> >19 Days</option>
                                <option value="20" <?php if($email_date1 == 20){echo "selected";} ?> >20 Days</option>
                                <option value="21" <?php if($email_date1 == 21){echo "selected";} ?> >21 Days</option>
                                <option value="22" <?php if($email_date1 == 22){echo "selected";} ?> >22 Days</option>
                                <option value="23" <?php if($email_date1 == 23){echo "selected";} ?> >23 Days</option>
                                <option value="24" <?php if($email_date1 == 24){echo "selected";} ?> >24 Days</option>
                                <option value="25" <?php if($email_date1 == 25){echo "selected";} ?> >25 Days</option>
                                <option value="26" <?php if($email_date1 == 26){echo "selected";} ?> >26 Days</option>
                                <option value="27" <?php if($email_date1 == 27){echo "selected";} ?> >27 Days</option>
                                <option value="28" <?php if($email_date1 == 28){echo "selected";} ?> >28 Days</option>
                                <option value="29" <?php if($email_date1 == 29){echo "selected";} ?> >29 Days</option>
                                <option value="30" <?php if($email_date1 == 30){echo "selected";} ?> >30 Days</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="email_date2">Email Date 2</label>
                              <select class="form-control" name="email_date2" id="email_date2" onchange="CreateEmailDate2(this.value);" <?php if($email_date1 == ""){echo "disabled";} ?> >
                                <option value="" selected>Select Days</option>
                                <option value="1" <?php if($email_date2 == 1){echo "selected";} ?> >1 Day</option>
                                <option value="2" <?php if($email_date2 == 2){echo "selected";} ?> >2 Days</option>
                                <option value="3" <?php if($email_date2 == 3){echo "selected";} ?> >3 Days</option>
                                <option value="4" <?php if($email_date2 == 4){echo "selected";} ?> >4 Days</option>
                                <option value="5" <?php if($email_date2 == 5){echo "selected";} ?> >5 Days</option>
                                <option value="6" <?php if($email_date2 == 6){echo "selected";} ?> >6 Days</option>
                                <option value="7" <?php if($email_date2 == 7){echo "selected";} ?> >7 Days</option>
                                <option value="8" <?php if($email_date2 == 8){echo "selected";} ?> >8 Days</option>
                                <option value="9" <?php if($email_date2 == 9){echo "selected";} ?> >9 Days</option>
                                <option value="10" <?php if($email_date2 == 10){echo "selected";} ?> >10 Days</option>
                                <option value="11" <?php if($email_date2 == 11){echo "selected";} ?> >11 Days</option>
                                <option value="12" <?php if($email_date2 == 12){echo "selected";} ?> >12 Days</option>
                                <option value="13" <?php if($email_date2 == 13){echo "selected";} ?> >13 Days</option>
                                <option value="14" <?php if($email_date2 == 14){echo "selected";} ?> >14 Days</option>
                                <option value="15" <?php if($email_date2 == 15){echo "selected";} ?> >15 Days</option>
                                <option value="16" <?php if($email_date2 == 16){echo "selected";} ?> >16 Days</option>
                                <option value="17" <?php if($email_date2 == 17){echo "selected";} ?> >17 Days</option>
                                <option value="18" <?php if($email_date2 == 18){echo "selected";} ?> >18 Days</option>
                                <option value="19" <?php if($email_date2 == 19){echo "selected";} ?> >19 Days</option>
                                <option value="20" <?php if($email_date2 == 20){echo "selected";} ?> >20 Days</option>
                                <option value="21" <?php if($email_date2 == 21){echo "selected";} ?> >21 Days</option>
                                <option value="22" <?php if($email_date2 == 22){echo "selected";} ?> >22 Days</option>
                                <option value="23" <?php if($email_date2 == 23){echo "selected";} ?> >23 Days</option>
                                <option value="24" <?php if($email_date2 == 24){echo "selected";} ?> >24 Days</option>
                                <option value="25" <?php if($email_date2 == 25){echo "selected";} ?> >25 Days</option>
                                <option value="26" <?php if($email_date2 == 26){echo "selected";} ?> >26 Days</option>
                                <option value="27" <?php if($email_date2 == 27){echo "selected";} ?> >27 Days</option>
                                <option value="28" <?php if($email_date2 == 28){echo "selected";} ?> >28 Days</option>
                                <option value="29" <?php if($email_date2 == 29){echo "selected";} ?> >29 Days</option>
                                <option value="30" <?php if($email_date2 == 30){echo "selected";} ?> >30 Days</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="email_date3">Email Date 3</label>
                              <select class="form-control" name="email_date3" id="email_date3" onchange="CreateEmailDate3(this.value);" <?php if($email_date2 == ""){echo "disabled";} ?> >
                                <option value="" selected>Select Days</option>
                                <option value="1" <?php if($email_date3 == 1){echo "selected";} ?> >1 Day</option>
                                <option value="2" <?php if($email_date3 == 2){echo "selected";} ?> >2 Days</option>
                                <option value="3" <?php if($email_date3 == 3){echo "selected";} ?> >3 Days</option>
                                <option value="4" <?php if($email_date3 == 4){echo "selected";} ?> >4 Days</option>
                                <option value="5" <?php if($email_date3 == 5){echo "selected";} ?> >5 Days</option>
                                <option value="6" <?php if($email_date3 == 6){echo "selected";} ?> >6 Days</option>
                                <option value="7" <?php if($email_date3 == 7){echo "selected";} ?> >7 Days</option>
                                <option value="8" <?php if($email_date3 == 8){echo "selected";} ?> >8 Days</option>
                                <option value="9" <?php if($email_date3 == 9){echo "selected";} ?> >9 Days</option>
                                <option value="10" <?php if($email_date3 == 10){echo "selected";} ?> >10 Days</option>
                                <option value="11" <?php if($email_date3 == 11){echo "selected";} ?> >11 Days</option>
                                <option value="12" <?php if($email_date3 == 12){echo "selected";} ?> >12 Days</option>
                                <option value="13" <?php if($email_date3 == 13){echo "selected";} ?> >13 Days</option>
                                <option value="14" <?php if($email_date3 == 14){echo "selected";} ?> >14 Days</option>
                                <option value="15" <?php if($email_date3 == 15){echo "selected";} ?> >15 Days</option>
                                <option value="16" <?php if($email_date3 == 16){echo "selected";} ?> >16 Days</option>
                                <option value="17" <?php if($email_date3 == 17){echo "selected";} ?> >17 Days</option>
                                <option value="18" <?php if($email_date3 == 18){echo "selected";} ?> >18 Days</option>
                                <option value="19" <?php if($email_date3 == 19){echo "selected";} ?> >19 Days</option>
                                <option value="20" <?php if($email_date3 == 20){echo "selected";} ?> >20 Days</option>
                                <option value="21" <?php if($email_date3 == 21){echo "selected";} ?> >21 Days</option>
                                <option value="22" <?php if($email_date3 == 22){echo "selected";} ?> >22 Days</option>
                                <option value="23" <?php if($email_date3 == 23){echo "selected";} ?> >23 Days</option>
                                <option value="24" <?php if($email_date3 == 24){echo "selected";} ?> >24 Days</option>
                                <option value="25" <?php if($email_date3 == 25){echo "selected";} ?> >25 Days</option>
                                <option value="26" <?php if($email_date3 == 26){echo "selected";} ?> >26 Days</option>
                                <option value="27" <?php if($email_date3 == 27){echo "selected";} ?> >27 Days</option>
                                <option value="28" <?php if($email_date3 == 28){echo "selected";} ?> >28 Days</option>
                                <option value="29" <?php if($email_date3 == 29){echo "selected";} ?> >29 Days</option>
                                <option value="30" <?php if($email_date3 == 30){echo "selected";} ?> >30 Days</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="email_date4">Email Date 4</label>
                              <select class="form-control" name="email_date4" id="email_date4" onchange="CreateEmailDate4(this.value);" <?php if($email_date3 == ""){echo "disabled";} ?> >
                                <option value="" selected>Select Days</option>
                                <option value="1" <?php if($email_date4 == 1){echo "selected";} ?> >1 Day</option>
                                <option value="2" <?php if($email_date4 == 2){echo "selected";} ?> >2 Days</option>
                                <option value="3" <?php if($email_date4 == 3){echo "selected";} ?> >3 Days</option>
                                <option value="4" <?php if($email_date4 == 4){echo "selected";} ?> >4 Days</option>
                                <option value="5" <?php if($email_date4 == 5){echo "selected";} ?> >5 Days</option>
                                <option value="6" <?php if($email_date4 == 6){echo "selected";} ?> >6 Days</option>
                                <option value="7" <?php if($email_date4 == 7){echo "selected";} ?> >7 Days</option>
                                <option value="8" <?php if($email_date4 == 8){echo "selected";} ?> >8 Days</option>
                                <option value="9" <?php if($email_date4 == 9){echo "selected";} ?> >9 Days</option>
                                <option value="10" <?php if($email_date4 == 10){echo "selected";} ?> >10 Days</option>
                                <option value="11" <?php if($email_date4 == 11){echo "selected";} ?> >11 Days</option>
                                <option value="12" <?php if($email_date4 == 12){echo "selected";} ?> >12 Days</option>
                                <option value="13" <?php if($email_date4 == 13){echo "selected";} ?> >13 Days</option>
                                <option value="14" <?php if($email_date4 == 14){echo "selected";} ?> >14 Days</option>
                                <option value="15" <?php if($email_date4 == 15){echo "selected";} ?> >15 Days</option>
                                <option value="16" <?php if($email_date4 == 16){echo "selected";} ?> >16 Days</option>
                                <option value="17" <?php if($email_date4 == 17){echo "selected";} ?> >17 Days</option>
                                <option value="18" <?php if($email_date4 == 18){echo "selected";} ?> >18 Days</option>
                                <option value="19" <?php if($email_date4 == 19){echo "selected";} ?> >19 Days</option>
                                <option value="20" <?php if($email_date4 == 20){echo "selected";} ?> >20 Days</option>
                                <option value="21" <?php if($email_date4 == 21){echo "selected";} ?> >21 Days</option>
                                <option value="22" <?php if($email_date4 == 22){echo "selected";} ?> >22 Days</option>
                                <option value="23" <?php if($email_date4 == 23){echo "selected";} ?> >23 Days</option>
                                <option value="24" <?php if($email_date4 == 24){echo "selected";} ?> >24 Days</option>
                                <option value="25" <?php if($email_date4 == 25){echo "selected";} ?> >25 Days</option>
                                <option value="26" <?php if($email_date4 == 26){echo "selected";} ?> >26 Days</option>
                                <option value="27" <?php if($email_date4 == 27){echo "selected";} ?> >27 Days</option>
                                <option value="28" <?php if($email_date4 == 28){echo "selected";} ?> >28 Days</option>
                                <option value="29" <?php if($email_date4 == 29){echo "selected";} ?> >29 Days</option>
                                <option value="30" <?php if($email_date4 == 30){echo "selected";} ?> >30 Days</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <input type="submit" value="Update Schedule" name="update" class="btn btn-gradient-primary updateBtn">
                          </div>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">All Services Email Schedule</h4>
                    <table id="table_emails_schedule" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%" >Sr#</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%">Client Name</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%">Email</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%">Service</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%">Email Status</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%">Reaction</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%">Template</th>
                            <!-- <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Email Date</th> -->
                            <!-- <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%">Action</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('company.customer.viewSurveyQuestionsModal')
    @include('company.emails.editEmailSchedule')
@endsection

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
                    <h4 class="mt-0 header-title">All Services Email Record</h4>
                    <table id="table_emails_record" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                        <thead>
                          <tr role="row">
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%" >Sr#</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%">Client Name</th>
                              <!-- <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 5%">Email</th> -->
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%">Service</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%">Email Status</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%">Reaction</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%">Template</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;">Service Date</th>
                              <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;">Feedback Date</th>
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
@endsection

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
                    <h4 class="mt-0 header-title">All Services</h4>
                    <table id="table_services" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;" >Sr#</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 25%;">Title</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 25%;">Survey Template</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;" >Status</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 20%;" >Action</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;" >Active/Ban</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('company.service.viewSurveyQuestionsModal')
    @include('company.service.deleteServiceModal')
@endsection

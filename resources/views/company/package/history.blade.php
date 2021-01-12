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
        <div class="col-12 mt-2">
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
                    <h4 class="mt-0 header-title">Package History</h4>
                    <table id="table_company_package_history" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Sr#</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;">Package Name</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;">Price</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%;">Duration</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">End Date</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Amount Paid</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Invoice</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

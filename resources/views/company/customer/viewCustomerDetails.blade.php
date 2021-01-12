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
            <form>
              <input type="hidden" name="view_customerId" id="view_customerId" value="{{$CustomerId}}" />
            </form>
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Customer Information</h4>
                    <table id="table_customers_details" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%">Client Name</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%">Email</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 15%">Phone</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Status</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%;">Add Service</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach($CustomerDetails as $customer)
                            <tr>
                              <td>{{$customer->client_name}}</td>
                              <td>{{$customer->email}}</td>
                              <td>{{$customer->phone}}</td>
                              @if($customer->status == 1)
                                <td><span class="badge badge-success">Active</span></td>
                              @else
                                <td><span class="badge badge-danger">Ban</span></td>
                              @endif
                              <td><button class="btn btn-info mr-2" id="customer_{{$customer->id}}" onclick="addCustomerNewService(this.id);"><i class="ti-pencil-alt"></i></button></td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Customer Services</h4>
                    <table id="table_customers_services_details" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="row_callback_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%" >Sr#</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 20%">Service</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 10%">Survey</th>
                            <!-- <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 20%">Email Date</th> -->
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 20%">Service Date</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 20%;">Email Status</th>
                            <th class="sorting" tabindex="0" aria-controls="row_callback" rowspan="1" colspan="1" style="width: 20%;">Reaction</th>
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
    @include('company.customer.addNewCustomerService')
@endsection

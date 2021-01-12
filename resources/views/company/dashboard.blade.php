@extends('company.layouts.app')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">X-Survey</li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">Dashboard</a></li>
                    </ol>
                </div>
                <!-- <h4 class="page-title">X Survey</h4> -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
          <div class="row">
              <div class="col-sm-3">
                  <div class="card crm-data-card">
                      <div class="card-body">
                          <div class="row">
                              <div class="col-4 align-self-center">
                                  <div class="icon-info">
                                      <i class="far fa-smile rounded-circle bg-soft-success"></i>
                                  </div>
                              </div>
                              <div class="col-8 text-right">
                                  <p class="text-muted font-14">Happy Customers</p>
                                  <h3 class="mb-0">{{$happy_customers}}</h3>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-3">
                  <div class="card crm-data-card">
                      <div class="card-body">
                          <div class="row">
                              <div class="col-4 align-self-center">
                                  <div class="icon-info">
                                      <i class="far fa-user rounded-circle bg-soft-pink"></i>
                                  </div>
                              </div>
                              <div class="col-8 text-right">
                                  <p class="text-muted font-14">Total Customers</p>
                                  <h3 class="mb-0">{{$customers}}</h3>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-3">
                  <div class="card crm-data-card">
                      <div class="card-body">
                          <div class="row">
                              <div class="col-4 align-self-center">
                                  <div class="icon-info">
                                      <i class="far fa-registered rounded-circle bg-soft-purple"></i>
                                  </div>
                              </div>
                              <div class="col-8 text-right">
                                  <p class="text-muted font-14">Total Records</p>
                                  <h3 class="mb-0">{{$total_records}}</h3>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-3">
                  <div class="card crm-data-card">
                      <div class="card-body">
                          <div class="row">
                              <div class="col-4 align-self-center">
                                  <div class="icon-info">
                                      <i class="far fa-handshake rounded-circle bg-soft-warning"></i>
                                  </div>
                              </div>
                              <div class="col-8 text-right">
                                  <p class="text-muted font-14">Total Services</p>
                                  <h3 class="mb-0">{{$total_services}}</h3>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
@endsection

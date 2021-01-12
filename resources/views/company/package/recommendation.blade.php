@extends('company.layouts.app')
@section('content')
<style>
  .cardColorSetting{
    background-color: white;
  }
  .description{
    color: grey;
  }
</style>

    <form method="POST" class="form-horizontal well" action="{{url('/packages/company/recommendation/store')}}">
        @csrf
        <div class="row">
          <div class="col-md-12 mt-2">
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
          @if($user->stripe_customer_id == null || $user->stripe_card_id == null || $user->card_number == null || $user->card_exp_month == null || $user->card_cvc == null || $user->card_exp_year == null)
            <div class="col-md-12 mt-2">
                <div class="alert alert-warning">
                    Warning! Your Card information is incomplete. Please go to profile and update the card information
                </div>
            </div>
          @endif
          <br>
          <div class="col-12">
              <div class="card" style="background-color: #f6f6f6;">
                  <div class="card-body">
                      <h4 class="mt-0 mb-5 header-title">Packages</h4>
                      <div class="row">
                        <!-- Start of Packages Plans -->
                        @foreach($recommendation_package as $package)
                          <!-- <div class="col-md-4">
                            <div class="card cardColorSetting cardHeight" style="width: 100%;">
                              @if($package->recommend_status == "recommend")
                                <div>
                                  <span class="badge badge-success badgeSetting">Recommended</span>
                                </div>
                              @endif
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-4">
                                    <h4 class="card-title">{{$package->package_name}}</h4>
                                  </div>
                                  <div class="col-8 text-right priceSetting">
                                    <div class="details" style="display:inline;padding-right: 15px;">{{$package->price}}$</div><div class="linespace" style="">|</div><div class="details" style="display:inline;padding-left:15px;">{{$package->duration}} Months</div>
                                  </div>
                                </div>
                                <div>
                                  <p class="card-text">{!! $package->description !!}</p>
                                </div>
                              </div>
                              <div class="card-footer text-muted">
                                  <a href="{{url('/packages/company/recommendation/store/'. $package->id)}}" class="btn btn-primary buttonSelectPlan">Select Plan</a>
                              </div>
                            </div>
                          </div> -->

                          <div class="col-lg-4">
                            <div class="card cardColorSetting">
                                <div class="card-body">
                                    @if($package->recommend_status == "recommend")
                                      <span class="badge badge-pink a-animate-blink mt-0">RECOMMENDED</span>
                                    @endif
                                    <div class="pricingTable1 text-center">
                                        <h6 class="title1 py-3 m-0">{{$package->package_name}}</h6>
                                        <div class="text-muted p-3 mb-0 description">{!! $package->description !!}</div>
                                        <div class="p-3 m-2 bg-light rounded d-flex justify-content-between align-items-center">
                                            <div class="">
                                                <h3 class="amount d-inline-block">${{$package->price}}</h3>
                                                <small class="font-12 text-muted">/{{$package->duration}} months</small>
                                            </div>
                                            <div>
                                                <i class="dripicons-feed font-30 text-success"></i>
                                            </div>
                                        </div>

                                        <ul class="list-unstyled pricing-content-2 text-left py-3 border-0 mb-0">
                                            <li>Add Customers</li>
                                            <li>Add Services</li>
                                            <li>Create Survey Forms</li>
                                            <li>Get Customer feedback</li>
                                        </ul>

                                        <a href="{{url('/packages/company/recommendation/store/'. $package->id)}}" class="btn btn-dark py-2 px-5 font-16"><span>Select Plan</span></a>
                                    </div><!--end pricingTable-->
                                </div><!--end card-body-->
                            </div> <!--end card-->
                          </div><!--end col-->
                        @endforeach
                        <!-- End of Packages Plans -->
                    </div>
                </div>
            </div>
         </div>
      </div>
    </div>
  </form>
@endsection

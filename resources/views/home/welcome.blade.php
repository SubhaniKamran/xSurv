<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="X-Survey">
    <meta name="keywords" content="X-Survey">
    <meta name="description" content="X-Survey">
    <title>X-Survey</title>
    <!-- Loading Bootstrap -->
    <link href="{{asset('public/asset2/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Loading Template CSS -->
    <link href="{{asset('public/asset2/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('public/asset2/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('public/asset2/css/style-magnific-popup.css')}}" rel="stylesheet">
    <!-- Awsome Fonts -->
    <link rel="stylesheet" href="{{asset('public/asset2/css/all.min.css')}}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <!-- Font Favicon -->
    <link rel="shortcut icon" href="{{ asset('public/storage/logo/' . $logo) }}">
		<style>
		.navbar {
		  width: 100%;
		  z-index: 9999;
		  padding-top: 0px;
		  padding-bottom: 0px;
		}
		ul.pricing-list li.price-value {
	    font-family: 'Roboto', sans-serif;
	    font-size: 50px;
	    line-height: 70px;
	    font-weight: 500;
	    display: block;
	    margin-top: 20px;
	    margin-bottom: 10px;
		}
		</style>
</head>
<body>
    <!--begin header -->
    <header class="header">
        <!--begin navbar-fixed-top -->
        <nav class="navbar navbar-expand-lg navbar-default navbar-fixed-top">
            <!--begin container -->
            <div class="container">
                    <!--begin logo -->
                    <a class="navbar-brand" href="{{url('/')}}">
											<img src="{{ asset('public/storage/logo/' . $logo) }}" class="img-fluid" style="width: 80px;"/>
										</a>
                    <!--end logo -->
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                    </button>
                    <div class="navbar-collapse collapse" id="navbarCollapse" style="">
                        <!--begin navbar-nav -->
                        <ul class="navbar-nav ml-auto">
                            <li><a href="#home">Home</a></li>
                            <li><a href="#features">Features</a></li>
                            <li><a href="#pricing">Pricing</a></li>
                            <li><a href="#contact">Contact us</a></li>
										  @if (Route::has('login'))
							                @auth
							                    <li><a href="{{ url('/home') }}">Dashboard</a></li>
							              	@else
							                    <li><a href="{{ route('login') }}">Login</a></li>
							                    @if (Route::has('register'))
							                      <li><a href="{{ route('register') }}" class="discover-btn">Register</a></li>
							                    @endif
							                @endif
							              @endif
                        </ul>
                    </div>
                    <!--end navbar-collapse -->
            </div>
    		<!--end container -->
        </nav>
    	<!--end navbar-fixed-top -->
    </header>
    <!--end header -->
    <!--begin home section -->
    <section class="home-section" id="home">
        <div class="home-section-overlay"></div>
		<!--begin container -->
		<div class="container">
	        <!--begin row -->
	        <div class="row align-items-center">
                <!--begin col-md-8-->
                <div class="col-md-8 mx-auto text-center">
                    <h1>X-Survey</h1>
                    <p class="hero-text">X-Survey is the new wave you need to get on.</p>
                    <a href="{{url('/register')}}" class="btn-white scrool">Get Started Now</a><br>
                    <a href="#features" class="arrow-down scrool"><i class="fas fa-chevron-down"></i></a>
                </div>
                <!--end col-md-8-->
	        </div>
	        <!--end row -->
		</div>
		<!--end container -->
    </section>
    <!--end home section -->
       <!--begin features section -->
    <section class="section-white" id="features">
        <!--begin container -->
        <div class="container">
            <!--begin row -->
            <div class="row">
                <!--begin col-md-12-->
                <div class="col-md-12 text-center padding-bottom-10">
                    <h2 class="section-title">Amazing Features</h2>
                    <p class="section-subtitle">Quis autem velis ets reprehender net etid quiste voluptate.</p>
                </div>
                <!--end col-md-12 -->
            </div>
            <!--end row -->
            <!--begin row -->
            <div class="row">
                <!--begin col-md-4-->
                <div class="col-md-4">
                    <div class="feature-box light-green">
                        <i class="fas fa-tools"></i>
                        <div class="feature-box-text">
                            <h4>Survey Management</h4>
                            <p>System facilitates creating and publishing surveys and collecting feedback to provide assistance in business decision making process</p>
                        </div>
                    </div>
                </div>
                <!--end col-md-4 -->
                <!--begin col-md-4-->
                <div class="col-md-4">
                    <div class="feature-box light-blue">
                        <i class="fas fa-mail-bulk"></i>
                        <div class="feature-box-text">
                            <h4>Email Scheduling</h4>
                            <p>X-Survey allows you to send survey-based emails, scheduled on a specific date and time.</p>
                        </div>
                    </div>
                </div>
                <!--end col-md-4 -->
                <!--begin col-md 4-->
                <div class="col-md-4">
                    <div class="feature-box orange">
                        <i class="fas fa-tasks"></i>
                        <div class="feature-box-text">
                            <h4>Record Management</h4>
                            <p>X-Survey provides the record management of customers feedback and reaction to perform analysis on the basis of records.</p>
                        </div>
                    </div>
                </div>
                <!--end col-md-4 -->
            </div>
            <!--end row -->
            <!--begin row -->
            <div class="row">
                <!--begin col-md-4-->
                <div class="col-md-4">
                    <div class="feature-box dark-blue">
                        <i class="fas fa-bell"></i>
                        <div class="feature-box-text">
                            <h4>Notifications</h4>
                            <p>X-Survey notifies the companies about the registration, package purchase, before package expiry and when package expired.</p>
                        </div>
                    </div>
                </div>
                <!--end col-md-4 -->
                <!--begin col-md-4-->
                <div class="col-md-4">
                    <div class="feature-box light-red">
                        <i class="fas fa-piggy-bank"></i>
                        <div class="feature-box-text">
                            <h4>Cost Effective</h4>
                            <p>X-Survey is cost effective system which allow companies to analyze and improve the buissness at a very low cost.</p>
                        </div>
                    </div>
                </div>
                <!--end col-md-4 -->
                <!--begin col-md-4-->
                <div class="col-md-4">
                    <div class="feature-box dark-green">
                        <i class="far fa-user"></i>
                        <div class="feature-box-text">
                            <h4>User Friendly</h4>
                            <p>User friendly interface is not overly complex, but instead is straightforward, providing quick access to common features or commands</p>
                        </div>
                    </div>
                </div>
                <!--end col-md-4 -->
            </div>
            <!--end row -->
        </div>
        <!--end container -->
    </section>
    <!--end features section -->
    <!--begin pricing section -->
    <section class="section-grey" id="pricing">
        <!--begin container -->
        <div class="container">
            <!--begin row -->
            <div class="row align-items-center">
                 <div class="col-md-3">
                 </div>
            	<div class="col-md-9">
            		<h2 class="section-title">Best value at affordable prices.</h2><br><br>
            	</div>

							<?php
								$total_count = sizeof($package_details);
							?>

							@if($total_count == 1)
								@foreach($package_details as $package)
								<div class="col-lg-4"></div>
								<div class="col-md-4 col-sm-6 wow bounceIn" data-wow-delay="0.25s" style="visibility: visible; animation-delay: 0.25s; animation-name: bounceIn;">
										<div class="<?php if($package->recommend_status == "recommend"){ echo "price-box-grey";} else{echo "price-box-white";}  ?>">
												<ul class="pricing-list">
														<li class="price-title">{{$package->package_name}}</li>
														<li class="price-value">${{$package->price}}</li>
														<li class="price-subtitle">/{{$package->duration}} mo.</li>
														<li class="price-tag"><a href="{{url('/register')}}">GET STARTED</a></li>
														<li class="price-text">Amazing freatures.</li>
												</ul>
										</div>
								</div>
								<div class="col-lg-4"></div>
								@endforeach
							@elseif($total_count == 2)
								<div class="col-lg-2"></div>
								@foreach($package_details as $package)
								<div class="col-md-4 col-sm-6 wow bounceIn" data-wow-delay="0.25s" style="visibility: visible; animation-delay: 0.25s; animation-name: bounceIn;">
										<div class="<?php if($package->recommend_status == "recommend"){ echo "price-box-grey";} else{echo "price-box-white";}  ?>">
												<ul class="pricing-list">
														<li class="price-title">{{$package->package_name}}</li>
														<li class="price-value">${{$package->price}}</li>
														<li class="price-subtitle">/{{$package->duration}} mo.</li>
														<li class="price-tag"><a href="{{url('/register')}}">GET STARTED</a></li>
														<li class="price-text">Amazing freatures.</li>
												</ul>
										</div>
								</div>
								@endforeach
								<div class="col-lg-2"></div>
							@elseif($total_count == 3)
								@foreach($package_details as $package)
								<div class="col-md-4 col-sm-6 wow bounceIn" data-wow-delay="0.25s" style="visibility: visible; animation-delay: 0.25s; animation-name: bounceIn;">
										<div class="<?php if($package->recommend_status == "recommend"){ echo "price-box-grey";} else{echo "price-box-white";}  ?>">
												<ul class="pricing-list">
														<li class="price-title">{{$package->package_name}}</li>
														<li class="price-value">${{$package->price}}</li>
														<li class="price-subtitle">/{{$package->duration}} mo.</li>
														<li class="price-tag"><a href="{{url('/register')}}">GET STARTED</a></li>
														<li class="price-text">Amazing freatures.</li>
												</ul>
										</div>
								</div>
								@endforeach
							@endif
            </div>
            <!--end row -->
        </div>
        <!--end container -->
    </section>
    <!--end pricing section -->
    <!--begin contact section -->
    <section class="section-bg-1" id="contact">
        <!--begin container-->
        <div class="container">
            <!--begin row -->
            <div class="row">
                <!--begin col-md-12-->
                <div class="col-md-12 text-center padding-bottom-10">
                    <h3 class="section-title white-text">Get In Touch</h3>
                </div>
                <!--end col-md-12 -->
            </div>
            <!--end row -->
            <!--begin row-->
            <div class="row justify-content-md-center">
                <div class="col-md-8 text-center margin-top-10">
                    <div class="contact-form-wrapper wow bounceIn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: bounceIn;">
                        <div>
                            <p class="contact_success_box" style="display:none;">We received your message and you will hear from us soon. Thank You!</p>
                            <form id="contact-form" class="row contact-form contact" action="{{url('/dropusaline')}}" method="POST">
																@csrf
																<input type="hidden" name="_token" value="{{csrf_token()}}" />
                                <div class="col-md-6">
                                    <input class="contact-input" required="" name="name" placeholder="Your Name*" type="text">
                                </div>
                                <div class="col-md-6">
                                    <input class="contact-input" required="" name="email" placeholder="Email Adress*" type="email">
                                </div>
                                <div class="col-md-12">
                                    <textarea class="contact-input" rows="2" cols="20" name="message" placeholder="Your Message..."></textarea>
                                    <input value="Get In Touch" class="contact-submit" type="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end container-->
    </section>
    <!--end contact section -->
    <!--begin footer -->
    <div class="footer">
        <!--begin container -->
        <div class="container">
            <!--begin row -->
            <div class="row">
                <!--begin col-md-5 -->
                <div class="col-md-5"></div>
                   <div class="col-md-7">
                    <p>© 2020 <span class="template-name">X-Survey</span>
                </div>
                <!--end col-md-5 -->
                <!--begin col-md-2 -->
                <div class="col-md-2"></div>
                <!--end col-md-2 -->
                <!--begin col-md-5 -->
                <!--end col-md-5 -->
            </div>
            <!--end row -->
        </div>
        <!--end container -->
    </div>
    <!--end footer -->
<!-- Load JS here for greater good =============================-->
<script src="{{asset('public/asset2/js/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('public/asset2/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/asset2/js/jquery.scrollTo-min.js')}}"></script>
<script src="{{asset('public/asset2/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('public/asset2/js/jquery.nav.js')}}"></script>
<script src="{{asset('public/asset2/js/wow.js')}}"></script>
<script src="{{asset('public/asset2/js/plugins.js')}}"></script>
<!-- <script src="{{asset('public/asset2/js/custom.js')}}"></script> -->
</body>
</html>

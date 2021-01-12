<!DOCTYPE html>
<html lang="en">
@include('company.includes.head')
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap" rel="stylesheet">
<style>
    body{
        background-color: #ffffff;
    }
    .page-wrapper {
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        padding: 0;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
         margin-top: 20px;
    }
    .heading{
        font-family: 'Ubuntu', sans-serif;
        color: #2f0090;
    }
    .description{
        font-family: 'Ubuntu', sans-serif;
        color: #2f0090;
        font-weight: 400;
    }
    .emoji{
        width:25%;
        cursor:pointer;
    }
    .redirects{
        text-align:center;
        margin-top: 50px;
        color: grey;
        display:none;
    }
</style>
<body>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mt-1">
                    <center><img src="{{ asset('public/storage/logo/' . $logo) }}" class="img-fluid" style="width: 200px; height: 200px;" /></center>
                </div>
                 <div class="col-md-12 text-center mt-2">
                    <center><img src="{{asset('public/assets/images/Divisor_Lines.png')}}" class="img-fluid"/></center>
                </div>
                <div class="col-md-12 text-center">
                    <center><h2 class="heading pt-2">DROP US A LINE</h2></center>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4 text-center">
                  <center><h4>Name: {{$name}}</h4></center>
                  <center><h4>Email: {{$email}}</h4></center>
                  <center><h4>Message: {{$message_drop}}</h4></center>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
@include('emails.includes.scripts')
</body>
</html>

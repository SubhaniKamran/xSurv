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
                    <img src="{{asset('public/assets/images/Thanks.png')}}" style="width: 50%" class="img-fluid"/>
                </div> 
                <div class="col-md-12 text-center">
                    <h3 class="heading pt-2">We Appreciate your feedback!</h3>
                </div>
                <div class="col-md-12 text-center mt-2">
                    <img src="{{asset('public/assets/images/Divisor_Lines.png')}}" class="img-fluid"/>
                </div> 
                <div class="col-md-1"></div>
                <div class="col-md-10 mt-5">
                    <p class="description pt-2">Hope this email finds you well!</p>
                    <p class="description">We saw you filled out our survey, thank you so much for your feedback - it's truly appreciated. We just wanted you to know that your feedback has been recieved. Your insight is so important for us!</p>
                    <p class="description">Regards,<br>X Survey</p>
                </div>
                <div class="col-md-1"></div>
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
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
</style>
<body>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center mt-5">
                    <img src="{{asset('public/assets/images/Thanks_filled.png')}}" style="width: 50%" class="img-fluid"/>
                </div> 
                <div class="col-md-12 text-center">
                    <h3 class="heading pt-2">You have already filled this survey. Thanks for the feedback!</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
@include('company.includes.scripts')
</body>
</html>
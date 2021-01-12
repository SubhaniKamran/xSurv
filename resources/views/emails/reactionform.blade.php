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
                    <img src="{{asset('public/assets/images/Results_Illustration.png')}}" style="width: 50%" class="img-fluid"/>
                </div> 
                <div class="col-md-12 text-center">
                    <h3 class="heading pt-2">Got a minute?</h3>
                </div>
                <div class="col-md-2 text-center"></div>
                <div class="col-md-8 text-center">
                    <p class="description pt-2">Thanks for being a customer. We'd appreciate if you take just a few minutes of your time to share your thoughts, so we can improve our contents and services. Thank you for taking our quick survey!</p>
                </div>
                <div class="col-md-2 text-center"></div>
                <div class="col-md-12 text-center mt-2">
                    <img src="{{asset('public/assets/images/Divisor_Lines.png')}}" class="img-fluid"/>
                </div> 
            </div>
            <div class="row mt-5">
                <div class="col-md-4 text-center">
                    <img src="{{asset('public/assets/images/happy.jpg')}}" class="img-fluid emoji" id="happy" onclick="reactionChecking(this.id);" />
                </div>
                <div class="col-md-4 text-center">
                    <img src="{{asset('public/assets/images/sad.jpg')}}" class="img-fluid emoji" id="sad" onclick="reactionChecking(this.id);" />
                </div>
                <div class="col-md-4 text-center">
                    <img src="{{asset('public/assets/images/neutral.jpg')}}" class="img-fluid emoji" id="neutral" onclick="reactionChecking(this.id);" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p class="redirects">You will be redirected in <strong><span class="timeremaning">2</span></strong> seconds</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
@include('emails.includes.scripts')
<script>
    let service = '<?= $service; ?>';
    let customerServiceId = '<?= $CustomerServiceId; ?>';
</script>
</body>
</html>
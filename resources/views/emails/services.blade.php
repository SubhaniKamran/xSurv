<!DOCTYPE html>
<html lang="en">
@include('company.includes.head')
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap" rel="stylesheet">
<body>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <center><img src="{{asset('public/assets/images/Invite_Illustration.png')}}" style="width: 70%" class="img-fluid"/></center>
                    </div>
                    <div class="col-md-12">
                        <center><h1 class="heading pt-2" style="font-family: 'Ubuntu', sans-serif;color: #2f0090;">Got a minute?</h1></center>
                    </div>
                    <div class="col-md-12" style="margin-left:80px; margin-right:80px;">
                        <center><p class="description pt-2" style="padding-top: 10px;font-family: 'Ubuntu', sans-serif;color: #2f0090;font-size:14px;padding-left: 30px;padding-right:30px;">Thanks for being a customer. We'd appreciate if you take just a few minutes of your time to share your thoughts, so we can improve our contents and services. Thank you for taking our quick survey!</p></center>
                    </div>
                    <div class="col-md-12" style="margin-top:15px;margin-bottom:15px;">
                        <center>
                            <a href="{{url($details['survey_url'])}}" style="text-decoration:none;color: #fff;background-color: #343a40;border-color: #343a40;font-weight: 400;text-align: center;padding: 5px 10px;;vertical-align: middle;font-size: 1rem;border-radius: .25rem;border: 1px solid transparent;">Go to Survey</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

@include('company.includes.scripts')
</body>
</html>

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
    .questions{
        font-family: 'Ubuntu', sans-serif;
        color: #2f0090;
        font-size: 18px;
        font-weight: 600;
    }
    .btn-gradient-primary {
        background: linear-gradient(14deg, #2f0090 0%, #2f0090) !important;
    }
</style>
<body>
<?php
    $SurveyQuestions = json_decode($survey_questions);
    $customerServiceId = $customerServiceId;
?>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mt-1">
                    <img src="{{asset('public/assets/images/Invite_Illustration.png')}}" style="width: 50%;" class="img-fluid"/>
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
            <form method="POST" class="form-horizontal well" action="{{url('/survey/results')}}">
                @csrf
                <input type="hidden" name="service" value="{{$service}}" />
                <input type="hidden" name="customer_service_id" value="{{$customerServiceId}}" />
                <input type="hidden" name="reaction_status" value="{{$reaction}}" />
                <div class="row mt-5">
                    <div class="col-md-12">
                        @foreach($SurveyQuestions as $survey)
                        <?php
                          $survey = str_replace("~", ",", $survey);
                        ?>
                            <div class="form-group mt-2">
                                <p class="questions">{{$survey}}</p>
                                <input type="text" class="form-control" name="answers[]" required>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group row mb-0 mt-3">
                        <div class="col-sm-12 text-center">
                            <input type="submit" value="Submit Feedback" name="Submit" class="btn btn-gradient-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
@include('emails.includes.scripts')
</body>
</html>

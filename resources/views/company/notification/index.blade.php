@extends('company.layouts.app')
@section('content')
<style>
  .img_round{
    height:45px; width: 45px;border-radius: 50%;float: left;
  }
  .alertSetting{
    margin-left: 70px;
    margin-top: 3px;
    background: #2b4376;
    width: auto;
    padding: 8px;
    border: none;
    border-radius: 7px;
    color: white;
  }
</style>
<br>
<br>
<div class="row">
  <div class="col-12">
    @foreach($company_notifications as $notification)
      <div class="row mt-4">
        <div class="col-8">
          <img class="img-fluid img_round" src="{{asset('public/storage/profile/' . $notification->profileImage)}}">
          <div class="alertSetting">
            {{$notification->message}}
          </div>
        </div>
        <div class="col-2">
          <p class="pt-2">{{$notification->created_at}}</p>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection

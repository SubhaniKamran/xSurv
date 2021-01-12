<!DOCTYPE html>
<html lang="en">
@include('company.includes.head')
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap" rel="stylesheet">
<body>
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <img src="{{ asset('public/storage/logo/' . $general_settings[0]->logo_url) }}" style="width: 10%;margin-top:10px;" />
        </div>
        <div class="col-md-12">
          <h3 class="text-center">TERMS AND CONDITIONS</h3>
        </div>
        <div class="col-md-12 mt-5">
          @if($terms_conditions != "")
            <p>{!! $terms_conditions[0]->termscondition !!}</p>
          @endif
        </div>
      </div>
    </div>
</body>

@include('company.includes.scripts')
</body>
</html>

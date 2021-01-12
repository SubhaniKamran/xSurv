<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="{{asset('public/asset3/css/style.css')}}" type="text/css" />
    <meta charset="utf-8">
    <title>X Survey-Invoice</title>
    <style>
      .invoiceHeading{
        font-family: Arial;
      }
      .thanksMsg{
        font-family: 'Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif;
        font-size: 24px;
        color: #50649c;
        line-height: 1.2em;
        font-weight: 600;
        text-align: center;
      }
      .titleSetting{
        font-size: 1.1em;
        text-align: right;
      }
    </style>
  </head>
  <body class="bg-white">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12" style="text-align: center;">
              <img style="height:150px" src="{{ asset('public/storage/logo/' . $logo) }}" alt="" class="img-fluid" />
          </div>
      </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <h4 class="thanksMsg">Thanks for using X-Survey</h4>
        </div>
      </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12" style="margin-left:10px;">
          <div class="row">
            <table>
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="titleSetting">Company:</span></td>
                  <td><p>{{$company_name}}</p></td>
                </tr>
                <br>
                <tr>
                  <td style="padding-top:8px;"><span class="titleSetting">Invoice #</span></td>
                  <td style="padding-top:8px;"><p>{{$data[0]->id}}</p></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
    <br>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered" style="text-align: center;">
              <thead>
              <tr>
                  <th style="width: 20%;">Package Name</th>
                  <th style="width: 20%;">Price</th>
                  <th style="width: 20%;">Duration</th>
                  <th style="width: 20%;">End Date</th>
                  <th style="width: 20%;">Amount Paid</th>
              </tr>
              </thead>
              <tbody>
                @foreach($data as $package)
                  <tr>
                    <td>{{$package->package_name}}</td>
                    <td>${{$package->package_price}}</td>
                    <td>{{$package->package_duration}} Months</td>
                    <td>{{$package->end_date}}</td>
                    <td>${{$package->amount_paid}}</td>
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>

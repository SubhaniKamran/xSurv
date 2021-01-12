<!DOCTYPE html>
<html lang="en">
@include('company.includes.head')

<body>
<!-- Top Bar Start -->
@include('company.includes.header')
<!-- Top Bar End -->
<!-- Left Sidenav -->
@include('company.includes.sidenav')
<style>
.dataTables_paginate{
  float: right;
}
.dataTables_filter{
  float: right;
}
.dataTables_length{
  margin-top: 5px;
  margin-bottom: 5px;
}
#success-message{
  display: none;
}
#error-message{
  display: none;
}
</style>

<!-- end left-sidenav-->
<div class="page-wrapper">
    <!-- Page Content-->
    <div class="page-content">
        <div class="container-fluid">
        @yield('content')
        <!-- container -->
        @include('company.includes.footer')
        <!--end footer-->
        </div>
    </div>
    <!-- end page content -->
</div>
<!-- end page-wrapper -->

<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
<script src="{{ asset('assets/js/waves.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

<script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>
<script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.canvaswrapper.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.colorhelpers.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.saturated.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.browser.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.drawSeries.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot.uiConstants.js') }}"></script>
<script src="{{ asset('assets/plugins/flot-chart/jquery.flot-dataType.js') }}"></script>
<script src="{{ asset('assets/pages/jquery.crm_dashboard.init.js') }}"></script>
<!--Wysiwig js-->
<script src="{{asset('assets/plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/pages/jquery.form-editor.init.js')}}"></script>
<!-- Required datatable js -->
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/pages/jquery.datatable.init.js')}}"></script>
<script src="{{asset('assets/plugins/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('assets/pages/jquery.form-repeater.js')}}"></script>
<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>
<script>
$(document).ready(function () {
  window.setInterval(function () {
    $.ajax({
        type: "post",
        url: "{{url('/company/unread/notifications')}}",
        data: {}
    }).done(function (data) {
        data = JSON.parse(data);
        $(".total_notifications").html('').html(data.Total);
        $("#notification-list").html('').html(data.Items);
    });
  }, 2500);
});

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>

@include('company.includes.scripts')
</body>
</html>

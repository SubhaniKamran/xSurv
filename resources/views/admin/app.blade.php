<!DOCTYPE html>
<html lang="en">

@include('admin/include/head')
<script type="text/javascript">
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 50).slideUp(500, function () {
            $(this).remove();
        });
    }, 2000);
</script>
<body>

<!-- Top Bar Start -->
@include('admin/include/header')
<!-- Top Bar End -->
<!-- Left Sidenav -->
@include('admin/include/sidenav')
<!-- end left-sidenav-->
<div class="page-wrapper">
    <!-- Page Content-->
    <div class="page-content">
        <div class="container-fluid">
        @yield('content')
        <!-- container -->
        @include('admin/include/footer')
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
@include('admin.include.scripts')
</body>
</html>

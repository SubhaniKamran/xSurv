<style>
.disable {
 pointer-events: none;
 cursor: default;
}
</style>
<div class="left-sidenav">
    <?php
      $current_date = date('Y-m-d');
      $package_end_date = Session::get('ExpiryDate');
      $date1 = strtotime($current_date);
      $date2 = strtotime($package_end_date);
    ?>
    @if($date1 > $date2)
    <ul class="metismenu left-sidenav-menu">
        <li>
            <a href="{{url('home')}}"><i class="ti-bar-chart"></i><span>Dashboard</span></a>
        </li>
        <li>
            <a href="javascript: void(0);" class="disable"><i class="ti-layers-alt"></i><span>Templates</span></a>
        </li>
        <li>
            <a href="javascript: void(0);" class="disable"><i class="ti-server"></i><span>Services</span></a>
        </li>
        <li>
            <a href="javascript: void(0);" class="disable"><i class="ti-user"></i><span>Customer</span></a>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="ti-user"></i><span>Package</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{url('/packages/company/active')}}"><i class="ti-control-record"></i>Active Package</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/packages/company/history')}}"><i class="ti-control-record"></i>History Invoice</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/packages/company/recommendation')}}"><i class="ti-control-record"></i>Recommendation</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);" class="disable"><i class="ti-email"></i><span>Emails</span></a>
        </li>
        <li>
            <a href="javascript: void(0);" class="disable"><i class="ti-settings"></i><span>Settings</span></a>
        </li>
    </ul>
    @else
    <ul class="metismenu left-sidenav-menu">
        <li>
            <a href="{{url('home')}}"><i class="ti-bar-chart"></i><span>Dashboard</span></a>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="ti-layers-alt"></i><span>Templates</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{url('/survey/add')}}"><i class="ti-control-record"></i>New Survey</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/survey/all')}}"><i class="ti-control-record"></i>All Surveys</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/survey/templates')}}"><i class="ti-control-record"></i>Templates</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="ti-server"></i><span>Services</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{url('/service/add')}}"><i class="ti-control-record"></i>New Service</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/service/all')}}"><i class="ti-control-record"></i>All Services</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="ti-user"></i><span>Customer</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{url('/customer/add')}}"><i class="ti-control-record"></i>New customer</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/customer/all')}}"><i class="ti-control-record"></i>All Customers</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="ti-user"></i><span>Package</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{url('/packages/company/active')}}"><i class="ti-control-record"></i>Active Package</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/packages/company/history')}}"><i class="ti-control-record"></i>History Invoice</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/packages/company/recommendation')}}"><i class="ti-control-record"></i>Recommendation</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="ti-email"></i><span>Emails</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{url('/pending/view')}}"><i class="ti-control-record"></i>Pending</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/sent/view')}}"><i class="ti-control-record"></i>Sent</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/record/view')}}"><i class="ti-control-record"></i>Record</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/scheduling/view')}}"><i class="ti-control-record"></i>Schedule</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="ti-settings"></i><span>Settings</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{url('/googlereview/add')}}"><i class="ti-control-record"></i>Google Review </a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/company/notification/setting')}}"><i class="ti-control-record"></i>Notification </a></li>
            </ul>
        </li>
    </ul>
    @endif
</div>

<div class="left-sidenav">
    <ul class="metismenu left-sidenav-menu">
        <li>
            <a href="{{route('admin.dashboard')}}"><i class="ti-bar-chart"></i><span>Dashboard</span></a>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="ti-layers-alt"></i><span>Companies</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{route('admin.company.create')}}"><i class="ti-control-record"></i>Register Company</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('admin.company.index')}}"><i class="ti-control-record"></i>All Companies</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="ti-layers-alt"></i><span>Package</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{route('admin.package.create')}}"><i class="ti-control-record"></i>New Package</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('admin.package.index')}}"><i class="ti-control-record"></i>All Packages</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="ti-layers-alt"></i><span>Survey Template</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{route('admin.survey.create')}}"><i class="ti-control-record"></i>New Template</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('admin.survey.index')}}"><i class="ti-control-record"></i>All Templates</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('admin/survey/companies/all')}}"><i class="ti-control-record"></i>All Surveys</a></li>
            </ul>
        </li>
        <li>
            <a href="{{url('admin/termsconditions/create')}}"><i class="ti-layers-alt"></i><span>Company Terms</span></a>
        </li>
        <li>
            <a href="javascript: void(0);"><i class="ti-settings"></i><span>Settings</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{url('admin/settings/logo')}}"><i class="ti-control-record"></i>Logo</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('/admin/notification/setting')}}"><i class="ti-control-record"></i>Notification </a></li>
            </ul>
        </li>
    </ul>
</div>

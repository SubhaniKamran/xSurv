<style>
  .topSetting{
    padding-top: 1em;
  }
  .notificalbox{
    height:150px;
    overflow-y: scroll;
  }
</style>
<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <a href="{{route('admin.dashboard')}}" class="logo">
            <span>
                <img src="{{ asset('public/storage/logo/' . Session::get('logo')) }}" alt="logo-small" style="width: 70px; height: 70px;">
            </span>
            <!-- <span>
                <img src="{{ asset('public/storage/logo/' . Session::get('logo')) }}" alt="logo-large" class="logo-lg logo-light">
                <img src="{{ asset('public/storage/logo/' . Session::get('logo')) }}" alt="logo-large" class="logo-lg">
            </span> -->
        </a>
    </div>
    <!--end logo-->
    <!-- Navbar -->
    <nav class="navbar-custom">
        <ul class="list-unstyled topbar-nav float-right mb-0">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#"
                   role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <i class="ti-bell noti-icon"></i>
                    <span class="badge badge-danger badge-pill noti-icon-badge total_notifications">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">
                    <h6 class="dropdown-item-text font-15 m-0 py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                        Notifications <span class="badge badge-light badge-pill total_notifications">0</span>
                    </h6>
                    <div class="slimscroll notification-list notificalbox" id="notification-list">
                        <!-- Display all the list of notifications -->
                    </div>
                    <!-- All-->
                    <a href="{{url('admin/all/notifications')}}" class="dropdown-item text-center text-primary">
                        View all <i class="fi-arrow-right"></i>
                    </a>
                </div>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#"
                   role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('public/storage/profile/' . Session::get('profile')) }}" alt="profile-user" class="rounded-circle"/>
                    <span class="ml-1 nav-user-name hidden-sm">{{ Session::get('name') }} <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{url('admin/profile/create/')}}"><i
                                class="ti-user text-muted mr-2"></i>Profile</a>
                    <div class="dropdown-divider mb-0"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                       <i class="ti-power-off text-muted mr-2"></i>{{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                </div>
            </li>
        </ul><!--end topbar-nav-->

        <ul class="list-unstyled topbar-nav mb-0">
            <li>
                <button class="nav-link button-menu-mobile waves-effect waves-light">
                    <i class="ti-menu nav-icon"></i>
                </button>
            </li>
        </ul>
    </nav>
    <!-- end navbar-->
</div>
<script>
$(document).ready(function () {
  window.setInterval(function () {
    $.ajax({
        type: "post",
        url: "{{url('/admin/unread/notifications')}}",
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

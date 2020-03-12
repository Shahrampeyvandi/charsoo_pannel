<nav class="navbar">
    <div class="container-fluid">
        <div class="header-logo">
            <a href="#">
                <img src="{{route('BaseUrl')}}/Pannel/img/c.jpg" alt="...">
                <span class="logo-text d-none d-lg-block">چهارسو - مدیریت خدمات</span>
            </a>
        </div>

        <div class="header-body">
            <ul class="navbar-nav">
                {{-- <li class="nav-item">
                    <a href="#" class="d-lg-none d-sm-block nav-link search-panel-open">
                        <i class="fa fa-search"></i>
                    </a>
                </li> --}}
                <li class="nav-item datetime" >
                    <a  href="#" class="nav-link" >
                        تاریخ

                        <span class="date">
                            
                            {{\Morilog\Jalali\Jalalian::forge('today')->format('%A, %d %B %y')}}
                        </span>

                        ساعت
                        <span class="date" id='server_time' style="width:75px;">

                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-notify " data-sidebar-target="#notifications">
                        <i class="fa fa-bell"></i>
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" aria-expanded="false">
                        <figure class="avatar avatar-sm avatar-state-success">
                            <img class="rounded-circle" src="{{route('BaseUrl')}}/Pannel/img/profile.png" alt="...">
                        </figure>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="profile.html" class="dropdown-item"
                        data-toggle="modal" data-target=".modal-profile"
                        >پروفایل</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{route('User.Logout')}}" class="text-danger dropdown-item">خروج</a>
                    </div>
                </li>
             
                <li class="nav-item d-lg-none d-sm-block">
                    <a href="#" class="nav-link side-menu-open">
                        <i class="ti-menu"></i>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>

<div class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content content-profile">

    </div>
  </div>
</div>
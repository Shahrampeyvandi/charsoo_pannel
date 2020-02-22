<div class="side-menu">
    <div class="side-menu-body">
        <ul>
            <li class="side-menu-divider">فهرست</li>
           
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Dashboard')
                class="active"
            @endif href="Dashboard"><i class="icon ti-home"></i> <span>داشبورد</span> </a></li>
            <li><a href=""><i class="icon ti-user"></i>  <span> کاربران </span></a>
                <ul>
                    <li><a 
                        @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.User.List')
                        class="active"
                    @endif href="{{route('Pannel.User.List')}}">   <span> مدیریت کاربران </span> </a> </li>
                    <li><a 
                        @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Roles')
                        class="active"
                    @endif href="{{route('Pannel.Roles')}}">   <span> نقش ها </span> </a> </li>
                </ul>
            </li>
            
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.Category')
                class="active"
            @endif href=" {{route('Pannel.Services.Category')}} "><i class="icon ti-list"></i> <span>دسته بندی خدمات</span> </a></li>
            
            
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.Questions')
                class="active"
            @endif href=" {{route('Pannel.Services.Questions')}} "><i class="icon ti-tag"></i> <span> خدمات </span> </a></li>

            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.Personels')
                class="active"
            @endif href=" {{route('Pannel.Services.Personels')}} "><i class="icon ti-hummer"></i> <span> خدمت رسان ها </span> </a></li>


            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Cunsomers.List')
                class="active"
            @endif href=" {{route('Pannel.Cunsomers.List')}} "><i class="icon ti-user"></i> <span> مشتریان </span> </a></li>

            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.City.List')
                class="active"
            @endif href=" {{route('Pannel.City.List')}} "><i class="icon ti-layout-accordion-list"></i> <span> شهر </span> </a></li>

          
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.OnlinePersonals')
                class="active"
            @endif href=" {{route('Pannel.Services.OnlinePersonals')}}"><i class="icon ti-rss-alt"></i> <span> خدمت رسان های انلاین </span> </a></li>
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.TrackPersonals')
                class="active"
            @endif href=" {{route('Pannel.Services.TrackPersonals')}} "><i class="icon ti-rss-alt"></i> <span> مسیر حرکت خدمت رسان ها </span> </a></li>
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Setting')
                class="active"
            @endif href=" {{route('Pannel.Setting')}}"><i class="icon ti-layout"></i> <span> تنظیمات </span> </a></li>
            
            
            
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Customers.Orders')
                class="active"
            @endif href=" {{route('Pannel.Customers.Orders')}} "><i class="icon ti-money"></i> <span> گردش کار</span> </a></li>


        </ul>
    </div>
</div>
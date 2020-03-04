<div class="side-menu">
    <div class="side-menu-body">
        <ul>
            <li class="side-menu-divider">فهرست</li>
           
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Dashboard')
                class="active"
            @endif href="Dashboard"><i class="icon ti-home"></i> <span>داشبورد</span> </a></li>
            @if (auth()->user()->can('user_menu'))
             <li><a href=""><i class="icon ti-user"></i>  <span> کاربران </span></a>
                <ul>
                   <li><a 
                    @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.User.List')
                    class="active"
                    @endif href="{{route('Pannel.User.List')}}">   <span> مدیریت کاربران </span> </a> </li>
                  
                   @if (auth()->user()->hasRole('admin_panel'))
                       <li><a 
                        @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Roles')
                        class="active"
                        @endif href="{{route('Pannel.Roles')}}">   <span> نقش ها </span> </a> </li>
                   @endif   
                </ul>
             </li>
            @endif
            @if (auth()->user()->can('category_menu'))
                <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.Category')
                    class="active"
                @endif href=" {{route('Pannel.Services.Category')}} "><i class="icon ti-list"></i> <span>دسته بندی خدمات</span> </a></li>
            @endif
            @if (auth()->user()->can('service_menu'))
                <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.Questions')
                    class="active"
                @endif href=" {{route('Pannel.Services.Questions')}} "><i class="icon ti-tag"></i> <span> خدمات </span> </a></li>
            @endif
            @if (auth()->user()->can('personal_menu'))
                <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.Personels')
                    class="active"
                @endif href=" {{route('Pannel.Services.Personels')}} "><i class="icon ti-hummer"></i> <span> خدمت رسان ها </span> </a></li>
            @endif

            @if (auth()->user()->can('customer_menu'))
                <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Cunsomers.List')
                    class="active"
                @endif href=" {{route('Pannel.Cunsomers.List')}} "><i class="icon ti-user"></i> <span> مشتریان </span> </a></li>

            @endif
            @if (auth()->user()->can('city_menu'))
                <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.City.List')
                    class="active"
                @endif href=" {{route('Pannel.City.List')}} "><i class="icon ti-layout-accordion-list"></i> <span> شهر </span> </a></li>
           @endif

           @if(auth()->user()->can('orders_menu'))
                <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Customers.Orders')
                    class="active"
                @endif href=" {{route('Pannel.Customers.Orders')}} "><i class="icon ti-money"></i> <span> گردش کار</span> </a></li>
            @endif
        @if(auth()->user()->can('accounting'))
           <li><a href=""><i class="icon ti-money"></i><span> حسابداری</span></a>
                <ul>
                   @if (auth()->user()->can('user_accounts'))
                        <li><a 
                        @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.User.List')
                        class="active"
                        @endif href="{{route('Pannel.Acounting.PersonalAcounts')}}">   <span> حساب های کاربران </span> </a> </li>
                   @endif
                   @if (auth()->user()->can('user_transactions'))
                        <li><a 
                            @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Roles')
                            class="active"
                        @endif href="{{route('Pannel.Acounting.Transactions')}}">   <span> گزارش تراکنش ها </span> </a> </li>
                    @endif
                    @if (auth()->user()->can('checkout_personals'))
                        <li><a 
                            @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Roles')
                            class="active"
                        @endif href="{{route('Pannel.Acounting.CheckoutPersonals')}}">   <span> تسویه حساب خدمت رسان ها </span> </a> </li>
                    @endif    
                </ul>
            </li>
        @endif   
        
        @if (auth()->user()->can('personal_online_menu'))
            <li><a href=""><i class="icon ti-rss-alt"></i>  <span> رهگیری خدمت رسان ها </span></a>
                <ul>
                    <li><a 
                        @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Personals.Online')
                        class="active"
                    @endif href="{{route('Pannel.Personals.Online')}}">   <span> خدمت رسان های انلاین  </span> </a> </li>
                    <li><a 
                        @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Personals.Track')
                        class="active"
                    @endif href="{{route('Pannel.Personals.Track')}}">   <span> مسیر حرکت خدمت رسان ها </span> </a> </li>
                  </ul>
             </li>
        @endif     
            {{-- <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.OnlinePersonals')
                class="active"
            @endif href=" {{route('Pannel.Services.OnlinePersonals')}}"><i class="icon ti-rss-alt"></i> <span> خدمت رسان های انلاین </span> </a></li>
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.TrackPersonals')
                class="active"
            @endif href=" {{route('Pannel.Services.TrackPersonals')}} "><i class="icon ti-rss-alt"></i> <span> مسیر حرکت خدمت رسان ها </span> </a></li>
             --}}
             @if (auth()->user()->hasRole('admin_panel'))
                <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Setting')
                    class="active"
                @endif href=" {{route('Pannel.Setting')}}"><i class="icon ti-layout"></i> <span> تنظیمات </span> </a></li>
            @endif

        </ul>
    </div>
</div>
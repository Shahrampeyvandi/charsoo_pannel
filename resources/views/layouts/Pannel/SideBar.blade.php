<div class="side-menu">
    <div class="side-menu-body">
        <ul>
            <li class="side-menu-divider">فهرست</li>
           
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'index.html')
                class="active"
            @endif href="index.html"><i class="icon ti-home"></i> <span>داشبورد</span> </a></li>
            
            <li><a 
                @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.User.List')
                class="active"
            @endif href="{{route('Pannel.User.List')}}"> <i class="icon ti-user"></i>  <span> کاربران </span> </a> </li>
           
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.Category')
                class="active"
            @endif href=" {{route('Pannel.Services.Category')}} "><i class="icon ti-list"></i> <span>دسته بندی خدمات</span> </a></li>
            
            
            <li><a @if (Illuminate\Support\Facades\Route::currentRouteName() == 'Pannel.Services.Questions')
                class="active"
            @endif href=" {{route('Pannel.Services.Questions')}} "><i class="icon ti-tag"></i> <span> خدمات </span> </a></li>

        </ul>
    </div>
</div>
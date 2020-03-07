<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <title>چهارسو | پنل مدیریت</title>
    <link rel="stylesheet" href="{{route('BaseUrl')}}/Pannel/assets/vendors/bundle.css" type="text/css">
    @yield('css')
    <link rel="stylesheet" href="{{route('BaseUrl')}}/Pannel/assets/css/app.css" type="text/css">
    <link rel="stylesheet" href="{{route('BaseUrl')}}/Pannel/assets/css/custom.css" type="text/css">
    <link rel="stylesheet" href="{{route('BaseUrl')}}/Pannel/assets/vendors/select2/css/select2.min.css"
        type="text/css">
    <link rel="stylesheet"
        href="{{route('BaseUrl')}}/Pannel/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{route('BaseUrl')}}/Pannel/assets/vendors/datepicker/daterangepicker.css">
    {{-- <link rel="stylesheet" href="{{route('BaseUrl')}}/Pannel/assets/vendors/clockpicker/bootstrap-clockpicker.min.css" 
         type="text/css"> --}}
    <link rel="shortcut icon" href="{{route('BaseUrl')}}/Pannel/assets/media/image/icon.png">

    <link rel="stylesheet" href="{{route('BaseUrl')}}/Pannel/assets/css/Style.css" type="text/css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- begin::theme color -->
    <meta name="theme-color" content="#8dc63f" />
    <!-- end::theme color -->





</head>

<body class="layout-container dark icon-side-menu" >
    @include('sweet::alert')

    <!-- begin::page loader-->
    <div class="page-loader">
        <div class="spinner-border"></div>
        <span>در حال بارگذاری ...</span>
    </div>
    <!-- end::page loader -->

   

    <!-- Pannel SideBar -->
    @include('Layouts.Pannel.SideBar')
    <!-- End Pannel SideBar -->

    <!-- Pannel NavBar -->
    @include('Layouts.Pannel.NavBar')
    <!-- End Pannel NavBar -->

    <!-- Main -->
    <main class=" main-content">
        @yield('content')
    </main>

    


    <script src="{{route('BaseUrl')}}/Pannel/assets/vendors/bundle.js"></script>
    <script src="{{route('BaseUrl')}}/Pannel/assets/js/app.js"></script>
    <script src="{{route('BaseUrl')}}/Pannel/assets/vendors/select2/js/select2.min.js"></script>

    <script src="{{route('BaseUrl')}}/Pannel/assets/js/examples/select2.js"></script>
    <script src="{{route('BaseUrl')}}/Pannel/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.js"></script>
    <script src="{{route('BaseUrl')}}/Pannel/assets/vendors/datepicker-jalali/bootstrap-datepicker.fa.min.js"></script>
    <script src="{{route('BaseUrl')}}/Pannel/assets/vendors/datepicker/daterangepicker.js"></script>
    <script src="{{route('BaseUrl')}}/Pannel/assets/js/examples/datepicker.js"></script>
    {{-- <script src="{{route('BaseUrl')}}/Pannel/assets/js/examples/clockpicker.js"></script> --}}
    {{-- <script src="{{route('BaseUrl')}}/Pannel/assets/vendors/clockpicker/bootstrap-clockpicker.min.js"></script> --}}
    <script src="{{route('BaseUrl')}}/Pannel/assets/js/examples/sweet-alert.js"></script>

    <!-- begin::dataTable -->
    <script src="{{route('BaseUrl')}}/Pannel/assets/vendors/dataTable/jquery.dataTables.min.js"></script>
    <script src="{{route('BaseUrl')}}/Pannel/assets/vendors/dataTable/dataTables.bootstrap4.min.js"></script>
    <script src="{{route('BaseUrl')}}/Pannel/assets/vendors/dataTable/dataTables.responsive.min.js"></script>
    <script src="{{route('BaseUrl')}}/Pannel/assets/js/examples/datatable.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>



    @yield('js')

    <script>

function checknationalcode(meli_code) {
 if (meli_code.length == 10) {
     if (meli_code == '1111111111' || meli_code == '0000000000' || meli_code == '2222222222' || meli_code == '3333333333' || meli_code == '4444444444' || meli_code == '5555555555' || meli_code == '6666666666' || meli_code == '7777777777' || meli_code == '8888888888' || meli_code == '9999999999') {
      swal("", "کد ملی وارد شده معتبر نمیباشد", "error", {
			button: "باشه"
    });
    document.getElementById("user_national_num").value = ''
     }
     c = parseInt(meli_code.charAt(9));
     n = parseInt(meli_code.charAt(0)) * 10 + parseInt(meli_code.charAt(1)) * 9 + parseInt(meli_code.charAt(2)) * 8 + parseInt(meli_code.charAt(3)) * 7 + parseInt(meli_code.charAt(4)) * 6 + parseInt(meli_code.charAt(5)) * 5 + parseInt(meli_code.charAt(6)) * 4 + parseInt(meli_code.charAt(7)) * 3 + parseInt(meli_code.charAt(8)) * 2;
     r = n - parseInt(n / 11) * 11;
     if ((r == 0 && r == c) || (r == 1 && c == 1) || (r > 1 && c == 11 - r)) {
        
     } else {
      swal("", "کد ملی وارد شده معتبر نمیباشد", "error", {
			button: "باشه"
    });
    document.getElementById("user_national_num").value = ''
     }
 } else {
  swal("", "کد ملی وارد شده معتبر نمیباشد", "error", {
			button: "باشه"
    });
    document.getElementById("user_national_num").value = ''
 }
}


var _h = 0;
var _m = 0;
var _s = 0;
$.ajax({ 
    url: '{{route("getOnlineTime")}}',
    type: 'GET',
    dataType: 'JSON', 
    cache:true,
    success: function(res) {
        var timer = setInterval(serverTime,1000);
        function serverTime(){
            h = parseInt(res.hour)+_h;
            m = parseInt(res.minute)+_m;
            s = parseInt(res.second)+_s;
            if (s>59){                  
                s=s-60;
                _s=_s-60;                   
            }
            if(s==59){
                _m++;   
            }
            if (m>59){
                m=m-60;
                _m=_m-60;                   
            }
            if(m==59&&s==59){
                _h++;   
            }   
            _s++;
            $('#server_time').html(append_zero(h)+':'+append_zero(m)+':'+append_zero(s));               }
        function append_zero(n){
            if(n<10){
                return '0'+n;
            }
            else
                return n;
        }
    }
});




// function display_c(){
// var refresh=1000; // Refresh rate in milli seconds
// mytime=setTimeout('display_ct()',refresh)
// }

// function display_ct() {
// var x = new Date();

// if (x.getHours() < 10 && x.getHours() > 0 ) {
//     var h = '0' + x.getHours();
// }else{
//     var h = x.getHours();
// }
// if (x.getMinutes() < 10 && x.getMinutes() > 0) {
//     var m = '0' + x.getMinutes();
// }else{
//     var m = x.getMinutes();
// }

// x1 = h + ":" + m + ":" +  x.getSeconds();
// document.getElementById('ct').innerHTML = x1;
// display_c();
//  }
 
    </script>
    
</body>

</html>
@extends('Layouts.Pannel.Template')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="row">
            <div class="col-lg-12 col-xs-6 my-3">
               <h4 class="text-center bg-primary mx-3 p-2" style="box-shadow: 0 3px 9px 1px #777474;
               border-radius: 4px;">{{$broker_name}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-xs-6 my-3">
                <!-- small box -->
                <div class="small-box mx-5" style=" display: flex;
                justify-content: space-between; padding: 21px;   box-shadow: 0 6px 20px 0 rgba(255,202,40,.5)!important; background: linear-gradient(-45deg,#ff6f00,#ffca28)!important;color: #fff;border-radius: 7px;">
                    <div class="inner">
                        <h3>
                            {{$pending_orders}}
                        </h3>

                        <p> سفارشات معلق</p>
                    </div>
                    <div class="icon" style="padding: 31px 0 10px 34px;
                    font-size: 50px;">
                        <i class="fa fa-exclamation"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-xs-6 my-3">
                <!-- small box -->
                <div class="small-box mx-5" style="display: flex;justify-content: space-between; padding: 20px;
                box-shadow: 0 6px 20px 0 rgba(255, 53, 19, 0.5)!important;
                background: linear-gradient(-45deg,#9c1405,#e91d26)!important;
                color: #fff;
                border-radius: 7px;">
                    <div class="inner">
                        <h3>
                           {{$doing_orders}}
                        </h3>

                        <p> خدمات در حال انجام</p>
                    </div>
                    <div class="icon" style="padding: 31px 0 10px 34px;
                    font-size: 50px;">
                        <i class="fa fa-exclamation"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-xs-6 my-3">
                <!-- small box -->
                <div class="small-box mx-5" style="        display: flex;        justify-content: space-between; padding: 20px;
                box-shadow: 0 6px 20px 0 rgba(29,233,182,.5)!important;
                background: linear-gradient(-45deg,#43a047,#1de9b6)!important;
                color: #fff;
                border-radius: 7px;">
                    <div class="inner">
                        <h3>
                            3

                        </h3>

                        <p> سفارشات معلق</p>
                    </div>
                    <div class="icon" style="padding: 31px 0 10px 34px;
                    font-size: 50px;">
                        <i class="fa fa-exclamation"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

   @if (auth()->user()->id == 1)
   <div class="card">
    <div class="card-body">
        <div class="card-title">
          <h5 class="text-center">لیست کارگزاری ها</h5>
          <hr>
        </div>
        <div style="overflow-x: auto;">
          <table  id="" class="table table-striped  table-bordered" >
            <thead>
              <tr>
                <th>ردیف</th>
                <th>
                  نام کارگزاری
                </a>
                </th>
                <th>
                    کارهای در حال انجام
                  </a>
                </th>
                <th>
                    کارهای ارجاعی 
                </th>
                <th>کارهای انجام شده</th>
              </tr>
            </thead>
            <tbody class="tbody">
                {!! $broker_lists !!}
            </tbody>
            
            
          </table>
        </div>
        </div>
</div>
   @endif

   
        <div class="row">
           
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                      <h5 class="text-center">نمودار درخواست ها به تفکیک خدمات</h5>
                      <hr>
                    </div>
                    <div class="card-body">
                        <canvas id="chart_demo_4"></canvas>
                    </div>
                </div>
            </div>
   
</div>       
@endsection

@section('js')
<script src="{{route('BaseUrl')}}/Pannel/assets/vendors/charts/chart.min.js"></script>
<script>
    Chart.defaults.global.defaultFontFamily = '"primary-font", "segoe ui", "tahoma"';
var chartColors = {
    primary: {
        base: '#3f51b5',
        light: '#c0c5e4'
    },
    danger: {
        base: '#f2125e',
        light: '#fcd0df'
    },
    success: {
        base: '#0acf97',
        light: '#cef5ea'
    },
    warning: {
        base: '#ff8300',
        light: '#ffe6cc'
    },
    info: {
        base: '#00bcd4',
        light: '#e1efff'
    },
    dark: '#37474f',
    facebook: '#3b5998',
    twitter: '#55acee',
    linkedin: '#0077b5',
    instagram: '#517fa4',
    whatsapp: '#25D366',
    dribbble: '#ea4c89',
    google: '#DB4437',
    borderColor: '#e8e8e8',
    fontColor: '#999'
};

chart_demo_4();

     function chart_demo_4() {
        if ($('#chart_demo_4').length) {
            var ctx = document.getElementById("chart_demo_4").getContext("2d");
            var densityData = {
                backgroundColor: chartColors.success.base,
                data: [10, 20, 40, 60, 80, 40, 60, 80, 40, 80, 20, 59]
            };
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo $service_list_chart; ?>,
                    datasets: [densityData]
                },
                options: {
                    scaleFontColor: "#FFFFFF",
                    legend: {
                        display: false,
                        labels: {
                            fontColor: chartColors.fontColor
                        }
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                color: chartColors.primary.light
                            },
                            ticks: {
                                fontColor: chartColors.dark
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                color: chartColors.primary.light
                            },
                            ticks: {
                                fontColor: chartColors.warning,
                                min: 0,
                                max: 100,
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    }
</script>
@endsection

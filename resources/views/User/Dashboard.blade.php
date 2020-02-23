@extends('Layouts.Pannel.Template')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="row">
            <div class="col-lg-4 col-xs-6 my-3">
                <!-- small box -->
                <div class="small-box mx-5" style=" display: flex;
                justify-content: space-between; padding: 21px;   box-shadow: 0 6px 20px 0 rgba(255,202,40,.5)!important; background: linear-gradient(-45deg,#ff6f00,#ffca28)!important;color: #fff;border-radius: 7px;">
                    <div class="inner">
                        <h3>
                            {{$orders}}

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
                            3

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
</div>       
@endsection

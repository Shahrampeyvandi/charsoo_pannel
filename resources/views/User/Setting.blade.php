@extends('Layouts.Pannel.Template')

@section('css')



@endsection
@section('content')


     {{-- filtering --}}
     <div class="card filtering container-fluid" >
        <div class="card-body">
          <div class="card-title">
            <h5 class="text-center">تنظیمات</h5>
            <hr>
        </div>
          <div class="row" >
            <div class="col-md-12">

              <form method="POST">
                <!-- form-group -->
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>ضریب ستاره مشتری برای انجام کار در هفته </label>
                      <input type="number" name="zarib_setare_moshtari" class="form-control" placeholder="">
                      <div class="valid-feedback">
                          صحیح است!
                      </div>
                  </div><!-- form-group -->
                  <div class="form-group col-md-6">
                      <label>ضریب تعداد سر وقت رسیدن به محل کار</label>
                      <input type="number" name="service_offered_price" id="service_offered_price" class="form-control" placeholder="">
                      <div class="valid-feedback">
                          صحیح است!
                      </div>
                  </div><!-- form-group -->
              </div>



              <!-- form-group -->
              <div class="row">
                <div class="form-group col-md-6">
                  <label>ضریب تعداد دیر رسیدن به محل کار </label>
                    <input type="number" name="service_percentage" id="service_percentage" class="form-control" placeholder="">
                    <div class="valid-feedback">
                        صحیح است!
                    </div>
                </div><!-- form-group -->
                <div class="form-group col-md-6">
                    <label>ضریب تعداد قطعی های کنسل شده در هفته خدمت رسان</label>
                    <input type="number" name="service_offered_price" id="service_offered_price" class="form-control" placeholder="">
                    <div class="valid-feedback">
                        صحیح است!
                    </div>
                </div><!-- form-group -->
            </div>



            <!-- form-group -->
            <div class="row">
              <div class="form-group col-md-6">
                <label>ضریب تعداد شروع به کار کنسل شده در هفته خدمت رسان</label>
                <input type="number" name="service_percentage" id="service_percentage" class="form-control" placeholder="">
                  <div class="valid-feedback">
                      صحیح است!
                  </div>
              </div><!-- form-group -->
              <div class="form-group col-md-6">
                  <label>ضریب تعداد پیشنهادات داده شده در هفته</label>
                  <input type="number" name="service_offered_price" id="service_offered_price" class="form-control" placeholder="">
                  <div class="valid-feedback">
                      صحیح است!
                  </div>
              </div><!-- form-group -->
          </div>


          <!-- form-group -->
          <div class="row">
            <div class="form-group col-md-6">
              <label>ضریب تعداد کار های ثبت نام اولیه فعال شده در هفته </label>
                <input type="number" name="service_percentage" id="service_percentage" class="form-control" placeholder="">
                <div class="valid-feedback">
                    صحیح است!
                </div>
            </div><!-- form-group -->
            <div class="form-group col-md-6">
                <label>حد اول امتیاز خدمت رسان</label>
                <input type="number" name="service_offered_price" id="service_offered_price" class="form-control" placeholder="">
                <div class="valid-feedback">
                    صحیح است!
                </div>
            </div><!-- form-group -->
        </div>



        <!-- form-group -->
        <div class="row">
          <div class="form-group col-md-6">
            <label>حد دوم امتیاز خدمت رسان</label>
            <input type="number" name="service_percentage" id="service_percentage" class="form-control" placeholder="">
              <div class="valid-feedback">
                  صحیح است!
              </div>
          </div><!-- form-group -->
          <div class="form-group col-md-6">
            <label>حد سوم امتیاز خدمت رسان</label>
            <input type="number" name="service_offered_price" id="service_offered_price" class="form-control" placeholder="">
              <div class="valid-feedback">
                  صحیح است!
              </div>
          </div><!-- form-group -->
      </div>



      <!-- form-group -->
      <div class="row">
        <div class="form-group col-md-6">
          <label>تعداد روز تعلیق </label>
            <input type="number" name="service_percentage" id="service_percentage" class="form-control" placeholder="">
            <div class="valid-feedback">
                صحیح است!
            </div>
        </div><!-- form-group -->
        <div class="form-group col-md-6">
            <label>لینک سوالات متداول</label>
            <input name="service_offered_price" id="service_offered_price" class="form-control" placeholder="">
            <div class="valid-feedback">
                صحیح است!
            </div>
        </div><!-- form-group -->
    </div>



    <!-- form-group -->
    <div class="row">
      <div class="form-group col-md-6">
        <label>لینک قوانین و مقررات</label>
        <input  name="service_percentage" id="service_percentage" class="form-control" placeholder="">
          <div class="valid-feedback">
              صحیح است!
          </div>
      </div><!-- form-group -->
      <div class="form-group col-md-6">
        <label>لینک اپ متخصص</label>
        <input  name="service_offered_price" id="service_offered_price" class="form-control" placeholder="">
          <div class="valid-feedback">
              صحیح است!
          </div>
      </div><!-- form-group -->
  </div>




  <!-- form-group -->
  <div class="row">
    <div class="form-group col-md-6">
      <label>شماره اپراتور </label>
        <input  name="service_percentage" id="service_percentage" class="form-control" placeholder="">
        <div class="valid-feedback">
            صحیح است!
        </div>
    </div><!-- form-group -->
    <div class="form-group col-md-6">
        <label>شماره پشتیبانی</label>
        <input name="service_offered_price" id="service_offered_price" class="form-control" placeholder="">
        <div class="valid-feedback">
            صحیح است!
        </div>
    </div><!-- form-group -->
</div>



<div class="row">
  <div class="form-group col-md-10">

  </div>
  <div class="form-group col-md-2">

    <button type="submit" class="btn btn-outline-primary">ذخیره سازی</button>
  </div>

</form>
</div>


          </div>
        </div>
      </div>
  {{-- end filtering --}}



@endsection

@section('js')





@endsection

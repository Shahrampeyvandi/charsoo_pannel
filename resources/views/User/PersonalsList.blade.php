@extends('Layouts.Pannel.Template')

@section('content')
{{-- modal for delete --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">اخطار</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          موارد علامت زده شده حذف شوند؟
        </div>
        <div class="modal-footer">
          <a type="button" class="delete btn btn-danger text-white">حذف!  </a>
        </div>
      </div>
    </div>
  </div>


  {{-- modal for create --}}

  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        
        <div class="modal-body">
            <div id="wizard2">
            <form id="example-advanced-form" method="post" action="{{route('Service.technician.Submit')}}" enctype="multipart/form-data">
                @csrf
                <h3>مشخصات فردی</h3>
                <section>
                    
                       <div class="row">
                        <div class="form-group col-md-6">
                            <label>نام </label>
                            <input type="text" id="firstname" name="firstname" class="form-control" placeholder="نام" >
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->

                        <div class="form-group col-md-6">
                            <label>نام خانوادگی</label>
                            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="نام" >
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->
                       </div>


                        <div class="row">
                           
                            <div class="form-group col-md-6">
                                <label>تاریخ تولد </label>
                                <input type="text" name="birth_year" class="date-picker-shamsi form-control" placeholder="" >
                                <div class="valid-feedback">
                                    صحیح است!
                                </div>
                            </div><!-- form-group -->
                            
                               
                            <div class="form-group col-md-6">
                                <label>کد ملی </label>
                                <input type="number" name="national_num" id="national_num" class="form-control" placeholder="" >
                                <div class="valid-feedback">
                                    صحیح است!
                                </div>
                            </div><!-- form-group -->
                        </div>
                        
                       <div class="row">
                       
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">وضعیت تاهل: </label>
                            <select  name="marriage_status"   class="form-control" id="exampleFormControlSelect2">
                                <option value="ارجاع اتوماتیک">مجرد</option>
                                <option value="ارجاع دستی">متاهل</option>  
 
                            </select>
                        </div> 
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">اخرین مدرک تحصیلی </label>
                            <select  name="education_status"   class="form-control" id="exampleFormControlSelect2">
                                <option value="سیکل">سیکل</option>
                                <option value="دیپلم">دیپلم</option>  
                                <option value="فوق دیپلم">فوق دیپلم</option>  
                                <option value="لیسانس">لیسانس</option>  
                            </select>
                        </div> 
                       </div>
                </section>
                <h3>اطلاعات تماس</h3>
                <section>
                    
                    
                       <div class="row">
                        <div class="form-group col-md-6" style="padding-top: 11px;">
                            <label class="form-control-label"> <span class="text-danger">*</span> تلفن همراه </label>
                            <input id="email" class="form-control text-right" name="mobile" placeholder="" type="text"  dir="ltr">
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">نام شهر: </label>
                            <select  name="education_status"   class="form-control" id="exampleFormControlSelect2">
                                <option value="مشهد">مشهد</option>
                                <option value="نیشابور">نیشابور</option>  
                                <option value="فریمان">فریمان</option>  
                                <option value="سبزوار">سبزوار</option>  
                            </select>
                        </div> 
                       </div>


                       <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-control-label"> کد پستی:  </label>
                            <input id="postal_code" class="form-control text-right" type="num" name="postal_code" placeholder="0" type="text"  dir="ltr">
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->


                        
                       </div>
                       <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-control-label"> نشانی دقیق منزل:  </label>
                            <textarea id="address" 
                            class="form-control text-right" 
                            type="text" name="address" 
                              dir="ltr">
                            </textarea>
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->
                       </div>


                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-control-label"> تلفن منزل:  </label>
                                <input id="tel_home" class="form-control text-right" type="num" name="tel_home" placeholder="0" type="text"  dir="ltr">
                                <div class="valid-feedback">
                                    صحیح است!
                                </div>
                            </div><!-- form-group -->
    
    
                            <div class="form-group col-md-6">
                                <label class="form-control-label"> تلفن محل کار: </label>
                                <input id="tel_work" class="form-control text-right" type="num" name="tel_work" placeholder="0" type="text"  dir="ltr">
                                <div class="valid-feedback">
                                    صحیح است!
                                </div>
                            </div><!-- form-group -->
    
                        </div>

                      
                        
                        
                    
                </section>
                <h3>مدارک اولیه: </h3>
                <section>
                   <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-control-label"> تصویر دو صفحه اول شناسنامه:  </label>
                        <input id="first_page_certificate" class="form-control text-right" type="file" name="first_page_certificate" placeholder="0" type="text"  dir="rtl">
                        <div class="valid-feedback">
                            صحیح است!
                        </div>
                    </div><!-- form-group -->

                    <div class="form-group col-md-6">
                        <label class="form-control-label"> تصویر دو صفحه دوم شناسنامه:  </label>
                        <input id="first_page_certificate" class="form-control text-right" type="file" name="first_page_certificate" placeholder="0" type="text"  dir="rtl">
                        <div class="valid-feedback">
                            صحیح است!
                        </div>
                    </div><!-- form-group -->
                   </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-control-label"> تصویر کارت پایان خدمت:   </label>
                            <input id="Card_Service" class="form-control text-right" type="file" name="Card_Service" placeholder="0" type="text"  dir="rtl">
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->
    
                        <div class="form-group col-md-6">
                            <label class="form-control-label"> تصویر برگه عدم سوء پیشینه:   </label>
                            <input id="antecedent_report_card" class="form-control text-right" type="file" name="antecedent_report_card" placeholder="0" type="text"  dir="rtl">
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-control-label"> تصویر روی کارت ملی:  </label>
                            <input id="national_card_front_pic" class="form-control text-right" type="file" name="national_card_front_pic" placeholder="0" type="text"  dir="rtl">
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->

                        <div class="form-group col-md-6">
                            <label class="form-control-label"> تصویر پشت کارت ملی:  </label>
                            <input id="national_card_back_pic" class="form-control text-right" type="file" name="national_card_back_pic" placeholder="0" type="text"  dir="rtl">
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->


                   
                   
                </div>
                  



                </section>
                <h3>مشخصات حرفه ای: </h3>
                <section>
                   <div class="row">
                    <div class="form-group col-md-12">
                        <label class="form-control-label"> درباره تخصص:   </label>
                        <textarea id="about_specialization" 
                        class="form-control text-right" 
                        type="text" name="about_specialization" 
                          dir="rtl">
                        </textarea>
                        <div class="valid-feedback">
                            صحیح است!
                        </div>
                    </div><!-- form-group -->
                   </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">تعداد ماه سابقه کار:  </label>
                            <input id="work_experience_month_num" class="form-control text-right" type="number" name="work_experience_month_num"  type="number"  dir="rtl">
    
                        </div> 
    
                        <div class="form-group col-md-6">
                            <label for="recipient-name" class="col-form-label">تعداد سال سابقه کار:  </label>
                            <input id="work_experience_year_num" class="form-control text-right" type="number" name="work_experience_year_num"  type="number"  dir="rtl">
    
                        </div> 
                    </div>
                </section>


                <h3>تخصص:  </h3>
                <section>
                   <div class="row">
                    <div class="form-group col-md-6">
                        <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                            <input type="checkbox" id="service_1" name="1" 
                            class="custom-control-input"
                            value="1"
                            >
                            <label class="custom-control-label" for="service_1">خدمات و تغییر فصل</label>
                        </div>
                    </div><!-- form-group -->

                    <div class="form-group col-md-6">
                        <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                            <input type="checkbox" id="service_2" name="service_2" 
                            class="custom-control-input"
                            value="1"
                            >
                            <label class="custom-control-label" for="service_2">مورد تایید است</label>
                        </div>
                    </div><!-- form-group -->
                   </div>

                   <div class="row">
                    <div class="form-group col-md-6">
                        <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                            <input type="checkbox" id="service_3" name="3" 
                            class="custom-control-input"
                            value="1"
                            >
                            <label class="custom-control-label" for="service_3">نصب هواساز ایرواشر</label>
                        </div>
                    </div><!-- form-group -->

                    <div class="form-group col-md-6">
                        <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                            <input type="checkbox" id="service_4" name="4" 
                            class="custom-control-input"
                            value="1"
                            >
                            <label class="custom-control-label" for="service_4">مورد تایید است</label>
                        </div>
                    </div><!-- form-group -->
                   </div>
                   
                </section>

                <h3>مدارک فنی:  </h3>
                <section>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-control-label"> بارگذاری:   </label>
                            <input id="national_card_front_pic" class="form-control text-right" type="file" name="national_card_front_pic" type="text"  dir="rtl">
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->
                    </div>
                </section>

                <h3>مدارک تحصیلی:   </h3>
                <section>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-control-label"> بارگذاری:   </label>
                            <input id="national_card_front_pic" class="form-control text-right" type="file" name="national_card_front_pic" type="text"  dir="rtl">
                            <div class="valid-feedback">
                                صحیح است!
                            </div>
                        </div><!-- form-group -->
                    </div>
                </section>
    
                </form>
            </div>
        </div>
        
      </div>
</div>
</div>
</div>

{{-- modal for edit --}}

<div class="modal fade bd-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ویرایش کاربر</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
           <div class="row">
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">نام:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
              <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">نام خانوادگی:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
           </div>
           <div class="row">
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">پسورد:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
              <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">تکرار پسورد:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
           </div>
           <div class="row">
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">ایمیل:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
              <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">نام کاربری:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
           </div>
          <div class="row">
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">موبایل:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
              <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">کد ملی:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
           </div>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">تصویر:</label>
              <input type="file" class="form-control" id="recipient-name">
            </div>
            <p>انتخاب نقش: </p>
            <div class="row">
                
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1" name="customRadioInline1"
                     class="custom-control-input checkbox__" value="tester">
                    <label class="custom-control-label " for="customRadioInline1">tester</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="customRadioInline1"
                     class="custom-control-input checkbox__" value="مشتری">
                    <label class="custom-control-label" for="customRadioInline2">مشتری</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline3" name="customRadioInline1" 
                    class="custom-control-input" value="خدمت رسان">
                    <label class="custom-control-label" for="customRadioInline3">خدمت رسان</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline4" name="customRadioInline1"
                     class="custom-control-input" value="مدیریت">
                    <label class="custom-control-label" for="customRadioInline4">مدیریت</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline5" name="customRadioInline1"
                     class="custom-control-input" value="adminbuilding">
                    <label class="custom-control-label" for="customRadioInline5">adminbuilding</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline6" name="customRadioInline1"
                     class="custom-control-input" value="unitbuilding">
                    <label class="custom-control-label" for="customRadioInline6">unitbuilding</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline7" name="customRadioInline1" 
                    class="custom-control-input" value="zitco">
                    <label class="custom-control-label" for="customRadioInline7">zitco</label>
                </div>
            </div>
  
           
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
          <button type="button" class="btn btn-primary">ذخیره</button>
        </div>
      </div>
</div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="container_icon card-body d-flex justify-content-end">
           
          

          <div class="delete-edit" > 
           
        </div>
        <div>
          <a href="#" class="mx-2 btn--filter"  title="فیلتر اطلاعات">
            <span class="__icon bg-info">
                <i class="fa fa-search"></i>
            </span>
        </a>

            <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg" title="افزودن کاربر">
                <span class="__icon bg-success">
                    <i class="fa fa-plus"></i>
                </span>
            </a>
            <a href="#" title="تازه سازی" class="mx-2" onclick="location.reload()">
                <span class="__icon bg-primary">
                    <i class="fa fa-refresh"></i>
                </span>
            </a>
           </div>


        </div>
    </div>


    {{-- filtering --}}
    <div class="card filtering" style="display:none;">
      <div class="card-body">
        <div class="row " >
            
          <div class="form-group col-md-6">
            <label for="recipient-name" class="col-form-label">فیلتر اطلاعات براساس: </label>
            <select required name="type_send"   class="form-control" id="exampleFormControlSelect2">
                <option value="نام">نام</option>
                <option value="نام خانوادگی">نام خانوادگی</option>  
                <option value="نام کاربری">نام کاربری</option>  
                <option value="کد ملی">کد ملی</option>  
                <option value="شماره موبایل">شماره موبایل</option> 
                
            </select>
        </div>
        <div class="form-group col-md-6">
          <label for="recipient-name" class="col-form-label">عبارت مورد نظر: </label>
          <input type="text" class="form-control" id="recipient-name">
        </div>
        </div>
        <div class="row">
          <div class="form-group col-md-6">

            <button type="submit" class="btn btn-outline-primary">جست و جو</button>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h5 class="text-center">مدیریت خدمت رسان</h5>
                <hr>
            </div>
            <div class="table-responsive">
                <table class="table table-striped  table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>ردیف</th>
                        <th>نام</th>
                        <th>نام خانوادگی</th>
                        <th>شماره همراه</th>
                        <th>فعال</th>
                        <th>جنسیت</th>
                        <th>وضعیت تاهل</th>
                        <th>اخرین مدرک تحصیلی</th>
                        <th>تلفن منزل</th>
                        <th>تلفن محل کار</th>         
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                                <input type="checkbox" id="1" name="customCheckboxInline1" 
                                class="custom-control-input"
                                value="1"
                                >
                                <label class="custom-control-label" for="1"></label>
                            </div>
                        </td>
                        <td>1</td>
                        <td>رضا</td>
                        <td>تبریزی</td>
                        <td>09123232334</td>
                        <td class="text-success">
                            <i class="fa fa-check"></i>
                        </td>
                        <td>مجرد</td>
                        <td>بی سواد</td>
                        <td>سیکل</td>
                        <td>0514-3331233</td>
                        <td>09121234567</td>
                       
                    </tr>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                                <input type="checkbox" id="2" name="customCheckboxInline1" 
                                class="custom-control-input" value="2">
                                <label class="custom-control-label" for="2"></label>
                            </div>
                        </td>
                        <td>2</td>
                        <td>رضا</td>
                        <td>تبریزی</td>
                        
                        <td>09123232334</td>
                        <td class="text-success">
                            <i class="fa fa-check"></i>
                        </td>
                        <td>مجرد</td>
                        <td>بی سواد</td>
                        <td>سیکل</td>
                        <td>0514-3331233</td>
                        <td>09121234567</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                                <input type="checkbox" id="3" name="customCheckboxInline1" 
                                class="custom-control-input" value="3">
                                <label class="custom-control-label" for="3"></label>
                            </div>
                        </td>
                        <td>3</td>
                        <td>رضا</td>
                        <td>تبریزی</td>
                        
                        <td>09123232334</td>
                        <td class="text-success">
                            <i class="fa fa-check"></i>
                        </td>
                        <td>مجرد</td>
                        <td>بی سواد</td>
                        <td>سیکل</td>
                        <td>0514-3331233</td>
                        <td>09121234567</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                                <input type="checkbox" id="4" name="customCheckboxInline1" 
                                class="custom-control-input" value="4">
                                <label class="custom-control-label" for="4"></label>
                            </div>
                        </td>
                        <td>4</td>
                        <td>رضا</td>
                        <td>تبریزی</td>
                        
                        <td>09123232334</td>
                        <td class="text-success">
                            <i class="fa fa-check"></i>
                        </td>
                        <td>مجرد</td>
                        <td>بی سواد</td>
                        <td>0514-3331233</td>
                        <td>09121234567</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                                <input type="checkbox" id="5" name="customCheckboxInline1" 
                                class="custom-control-input" value="5">
                                <label class="custom-control-label" for="5"></label>
                            </div>
                        </td>
                        <td>5</td>
                        <td>رضا</td>
                        <td>تبریزی</td>
                        
                        <td>09123232334</td>
                        <td class="text-success">
                            <i class="fa fa-check"></i>
                        </td>
                        <td>مجرد</td>
                        <td>بی سواد</td>
                        <td>سیکل</td>
                        <td>0514-3331233</td>
                        <td>09121234567</td>
                    </tr>
                   
                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
    
    <!-- begin::form wizard -->
    <link rel="stylesheet" href="{{route('BaseUrl')}}/Pannel/assets/vendors/form-wizard/jquery.steps.css" type="text/css">
    <!-- end::form wizard -->
   
@endsection

@section('js')
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<!-- begin::form wizard -->
<script src="{{route('BaseUrl')}}/Pannel/assets/vendors/form-wizard/jquery.steps.min.js"></script>
<script src="{{route('BaseUrl')}}/Pannel/assets/js/examples/form-wizard.js"></script>
<!-- end::form wizard -->
<script>
    $(document).ready(function(){
    
       
        $('.btn--filter').click(function(){
          $('.filtering').toggle(200)
        })

           $('table input[type="checkbox"]').change(function(){
            var array=[]
            $('table input[type="checkbox"]').each(function(){
                if($(this).is(':checked')){
                array.push($(this).val())

               }
            if(array.length !== 0){

                if (array.length !== 1) {
                    $('.container_icon').removeClass('justify-content-end')
                    $('.container_icon').addClass('justify-content-between')
                    $('.delete-edit').html(`
                    <a href="#" title="حذف " data-toggle="modal" data-target="#exampleModal" class="sweet-multiple mx-2">
            <span class="__icon bg-danger">
                <i class="fa fa-trash"></i>
            </span>
           </a>
                    `)
                }else{

                    $('.container_icon').removeClass('justify-content-end')
                    $('.container_icon').addClass('justify-content-between')
                    $('.delete-edit').html(`
                    <a href="#" title="حذف " data-toggle="modal" data-target="#exampleModal" class="sweet-multiple mx-2">
            <span class="__icon bg-danger">
                <i class="fa fa-trash"></i>
            </span>
           </a>

           <a href="#" title="تازه سازی" data-toggle="modal" data-target=".bd-example-modal-lg-edit" class="mx-2" >
            <span class="__icon bg-info">
                <i class="fa fa-edit"></i>
            </span>
           </a>
                    `)
                }
            }
            else{
                $('.container_icon').removeClass('justify-content-between')
                $('.container_icon').addClass('justify-content-end')
                $('.delete-edit').html('')
            }
        })
            
    })

    $('.delete').click(function(e){
                e.preventDefault()
                console.log(array)

                // ajax request

            })

})
</script>
@endsection

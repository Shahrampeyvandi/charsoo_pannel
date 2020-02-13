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
                <form id="example-advanced-form" action="{{route('Service.Submit')}}" enctype="multipart/form-data">
                    @csrf
                    <h3>خدمت</h3>
                    <section>
                        
                            <div class="form-group wd-xs-300">
                                <label>عنوان </label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="نام" >
                                
                            </div><!-- form-group -->
                            
                                <div class="form-group wd-xs-300">
                                    <label for="recipient-name" class="col-form-label">دسته:</label>
                                    <select  size="7"  class="form-control" name="service_category" id="service_category">
                                        <option>پیک</option>
                                        <option>خدمات پس از فروش</option>
                                        <optgroup class="level-1">
                                            <option>1.1</option>
                                            <option>1.2</option>
                                            <option>1.3</option>
                                            
                                        </optgroup>
                                        <option>تاسیسات</option>
                                        <option>دکوراسیون و ساختمانی</option>
                                        <option>شست و شو و نظافت</option>
                                        <option>آموزش</option>
                                    </select>
                                                      
                                <div class="valid-feedback">
                                    صحیح است!
                                </div>
                            </div><!-- form-group -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>درصد پورسانت </label>
                                    <input type="number" name="service_percentage" id="service_percentage" class="form-control" placeholder="">
                                    <div class="valid-feedback">
                                        صحیح است!
                                    </div>
                                </div><!-- form-group -->
                                <div class="form-group col-md-6">
                                    <label>قیمت ارسال پیشنهاد </label>
                                    <input type="number" name="service_price" id="service_price" class="form-control" placeholder="">
                                    <div class="valid-feedback">
                                        صحیح است!
                                    </div>
                                </div><!-- form-group -->
                            </div>
                            <div class="form-group wd-xs-300">
                                <label>توضیحات </label>
                                <textarea type="text" class="form-control" placeholder="">
                                </textarea>
                                <div class="valid-feedback">
                                    صحیح است!
                                </div>
                            </div><!-- form-group -->
                            <div class="form-group wd-xs-300">
                                <label>تذکرات </label>
                                <input type="text" class="form-control" placeholder="" >
                                <div class="valid-feedback">
                                    صحیح است!
                                </div>
                            </div><!-- form-group -->

                            <p>شهر  </p>
                            <div class="form-group wd-xs-300">
                                
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input required type="radio" id="customRadioInline1" name="customRadioInline1"
                                     class="custom-control-input checkbox__" value="مشهد" checked>
                                    <label class="custom-control-label " for="customRadioInline1">مشهد</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input required type="radio" id="customRadioInline2" name="customRadioInline1"
                                     class="custom-control-input checkbox__" value="نیشابور">
                                    <label class="custom-control-label" for="customRadioInline2">نیشابور</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input required type="radio" id="customRadioInline3" name="customRadioInline1"
                                     class="custom-control-input checkbox__" value="سبزوار">
                                    <label class="custom-control-label" for="customRadioInline3">سبزوار</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input required type="radio" id="customRadioInline4" name="customRadioInline1"
                                     class="custom-control-input checkbox__" value="فریمان">
                                    <label class="custom-control-label" for="customRadioInline4">فریمان</label>
                                </div>
                            </div> 
                            <div class="form-group wd-xs-300">
                                <label for="recipient-name" class="col-form-label">نوع ارجاع:</label>
                                <select required name="type_send"   class="form-control" id="exampleFormControlSelect2">
                                    <option value="ارجاع اتوماتیک">ارجاع اتوماتیک</option>
                                    <option value="ارجاع دستی">ارجاع دستی</option>  
                                    <option value="ارجاع منتخب">ارجاع منتخب</option>  
                                    <option value="ارجاع به کمترین فاصله">ارجاع به کمترین فاصله</option>  
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>نقش </label>
                                    <input type="text" class="form-control" placeholder="" >
                                    <div class="valid-feedback">
                                        صحیح است!
                                    </div>
                                </div><!-- form-group -->
                                <div class="form-group col-md-6">
                                    <label>ایکون </label>
                                    <input type="file" class="form-control" placeholder="" >
                                    <div class="valid-feedback">
                                        صحیح است!
                                    </div>
                                </div><!-- form-group -->
                            </div>
                               
                       
                    </section>
                    <h3> قیمت</h3>
                    <section>
                        
                        
                            <div class="form-group wd-xs-300">
                                <label class="form-control-label"> <span class="text-danger">*</span> عنوان قیمت: </label>
                                <input id="email" class="form-control text-right" name="price_title" placeholder="" type="text"  dir="ltr">
                                <div class="valid-feedback">
                                    صحیح است!
                                </div>
                            </div><!-- form-group -->
                            <div class="form-group wd-xs-300">
                                <label for="recipient-name" class="col-form-label">نوع :</label>
                                <select  name="type_send"   class="form-control" id="exampleFormControlSelect2">
                                    <option value="رقمی"> رقمی</option>
                                    <option value="توافقی"> توافقی</option>
                                    <option value="طبق لیست"> طبق لیست</option>
                                 </select>
                            </div><!-- form-group -->
                            <div class="form-group wd-xs-300">
                                <label class="form-control-label"> قیمت: </label>
                                <input id="email" class="form-control text-right" name="text" placeholder="0" type="text"  dir="ltr">
                                <div class="valid-feedback">
                                    صحیح است!
                                </div>
                            </div><!-- form-group -->
                           
                            <div class="form-group wd-xs-300">
                                <label class="form-control-label"> تصویر 1: </label>
                                <input id="email" class="form-control text-right" name="pic_1"  type="file"  dir="ltr">
                                <div class="valid-feedback">
                                    صحیح است!
                                </div>
                            </div><!-- form-group -->
                            <div class="form-group wd-xs-300">
                                <label class="form-control-label"> تصویر 2: </label>
                                <input id="email" class="form-control text-right" name="pic_2"  type="file"  dir="ltr">
                                <div class="valid-feedback">
                                    صحیح است!
                                </div>
                            </div><!-- form-group -->
                            
                        
                    </section>
                    <h3>انتخاب سوالات از بانک</h3>
                    <section>
                    </section>
                    <h3>پیشنهاد ویژه</h3>
                    <section>
                        <div class="form-group wd-xs-300">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="service_offered_status" id="customCheck" checked>
								<label class="custom-control-label" for="customCheck">به عنوان پیشنهاد ویژه در نظر گرفته شود</label>
                            </div>     
                            
                        </div>   
                        <div class="form-group wd-xs-300">
                            <label for="recipient-name" class="col-form-label">این سرویس در چه خدماتی به عنوان ویژه در نظر گرفته شود: </label>
                            <select  name="service_special_category"   class="form-control" id="exampleFormControlSelect2">
                                <option value="ارجاع اتوماتیک">ارجاع اتوماتیک</option>
                                <option value="ارجاع دستی">ارجاع دستی</option>  
                                <option value="ارجاع منتخب">ارجاع منتخب</option>  
                                <option value="ارجاع به کمترین فاصله">ارجاع به کمترین فاصله</option>  
                            </select>
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
          <h5 class="modal-title" id="exampleModalLabel">ویرایش دسته بندی خدمات</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
           <div class="row">
            <div class="form-group col-md-12">
                <label for="recipient-name" class="col-form-label">عنوان:</label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
              
           </div>
           <div class="row">
            <div class=" col-md-6">
                <h5 class="card-title">دسته: </h5>
                <div id="jstree_demo1"></div>
              </div>
           </div>
           <div class="row">
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">نوع:</label>
                <select name="type" class="js-example-basic-single" dir="rtl">
                    <option></option>
                    <option value="France">خدمات شرکتی</option>
                    <option value="Brazil">فروشگاه</option>
                    <option value="Yemen">خدمات پس از فروش</option>
                    <option value="United States">خدمات اصلی</option>
                    <option value="China">پیشنهاد ویژه</option>
                    <option value="Argentina">خدمات فرعی</option>
                </select>  
            </div>
              <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label"> ایکون:</label>
                <input type="file" class="form-control" id="recipient-name">
              </div>
           </div>
           <div class="row">
            <div class="form-group col-md-12">
                <label for="recipient-name" class="col-form-label">توضیحات تکمیلی:</label>
                <textarea type="text" class="form-control" id="recipient-name">
                </textarea>
              </div>
             
           </div>
           <div class="row">
            <div class="form-group col-md-12">
                <label for="recipient-name" class="col-form-label">توضیحات عمومی:</label>
                <textarea type="text" class="form-control" id="recipient-name">
                </textarea>
              </div>
           </div>
           <h6>نمایش در صفحه اصلی: </h6>
              <br>
          <div class="row">
              
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">تصویر:</label>
                <input type="file" class="form-control" id="recipient-name">
              </div>
              <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">قیمت ارسال پیشنهاد: </label>
                <input type="text" class="form-control" id="recipient-name">
              </div>
           </div>
            
            
            
  
           
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
          <button type="button" class="btn btn-primary">ارسال</button>
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
              <select  name="type_send"   class="form-control" id="exampleFormControlSelect2">
                  <option value="عنوان">عنوان</option>
                  <option value="نوع">نوع</option>  
                  <option value="دسته بندی خدمات">دسته بندی خدمات</option>  
                  <option value="نقش">نقش</option>  
                  <option value="فاصله">فاصله</option> 
                  <option value="نوع خدمت">نوع خدمت</option> 
                  <option value="نوع ارجاع">نوع ارجاع</option> 
                 
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
                <h5 class="text-center">مدیریت خدمات</h5>
                <hr>
            </div>
                <table id="example1" class="table table-striped  table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>ردیف</th>
                        <th>عنوان</th>
                        <th> توضیحات</th>
                        <th> نوع</th>
                        <th>دسته بندی خدمات</th>
                        <th> نقش</th>
                        <th>فاصله</th>
                        <th>درصد پورسانت</th>
                        <th>پیشنهاد ویژه در خدمات زیر</th>
                        <th>نوع خدمت</th>

                        <th>نوع ارجاع</th>
                        <th>عکس</th>

                        
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="__table custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                                <input type="checkbox" id="1" name="customCheckboxInline1" 
                                class="custom-control-input"
                                value="1"
                                >
                                <label class="custom-control-label" for="1"></label>
                            </div>
                        </td>
                        <td>1</td>
                        <td> پیک</td>
                        <td></td>
                        <td>شرکتی</td>
                        <td></td>
                        <td>zitco</td>
                        <td>2000</td>
                       
                        <td>
                          10%
                        </td>
                        <td></td>
                        <td>
                            لیست
                        </td>
                        <td>
                            ارجاع اتوماتیک
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="__table custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                                <input type="checkbox" id="2" name="customCheckboxInline1" 
                                class="custom-control-input" value="2">
                                <label class="custom-control-label" for="2"></label>
                            </div>
                        </td>
                        <td>2</td>
                        <td> پیک</td>
                        <td></td>
                        <td>شرکتی</td>
                        <td></td>
                        <td>zitco</td>
                        <td>2000</td>
                       
                        <td>
                          10%
                        </td>
                        <td></td>
                        <td>
                            لیست
                        </td>
                        <td>
                            ارجاع اتوماتیک
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="__table custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                                <input type="checkbox" id="3" name="customCheckboxInline1" 
                                class="custom-control-input" value="3">
                                <label class="custom-control-label" for="3"></label>
                            </div>
                        </td>
                        <td>3</td>
                        <td> پیک</td>
                        <td></td>
                        <td>شرکتی</td>
                        <td></td>
                        <td>zitco</td>
                        <td>2000</td>
                       
                        <td>
                          10%
                        </td>
                        <td></td>
                        <td>
                            لیست
                        </td>
                        <td>
                            ارجاع اتوماتیک
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="__table custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                                <input type="checkbox" id="4" name="customCheckboxInline1" 
                                class="custom-control-input" value="4">
                                <label class="custom-control-label" for="4"></label>
                            </div>
                        </td>
                        <td>4</td>
                        <td> پیک</td>
                        <td></td>
                        <td>شرکتی</td>
                        <td></td>
                        <td>zitco</td>
                        <td>2000</td>
                       
                        <td>
                          10%
                        </td>
                        <td></td>
                        <td>
                            لیست
                        </td>
                        <td>
                            ارجاع اتوماتیک
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="__table custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                                <input type="checkbox" id="5" name="customCheckboxInline1" 
                                class="custom-control-input" value="5">
                                <label class="custom-control-label" for="5"></label>
                            </div>
                        </td>
                        <td>5</td>
                        <td> پیک</td>
                        <td></td>
                        <td>شرکتی</td>
                        <td></td>
                        <td>zitco</td>
                        <td>2000</td>
                       
                        <td>
                          10%
                        </td>
                        <td></td>
                        <td>
                            لیست
                        </td>
                        <td>
                            ارجاع اتوماتیک
                        </td>
                        <td></td>
                    </tr>
                   
                    </tbody>
                   
                </table>
            
        </div>
    </div>
</div>
@endsection

@section('css')

    
    <!-- begin::form wizard -->
    <link rel="stylesheet" href="{{route('BaseUrl')}}/Pannel/assets/vendors/form-wizard/jquery.steps.css" type="text/css">
    <!-- end::form wizard -->

    <style></style>
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
        
            $(document).on('change','.__table input[type="checkbox"]',function(){
                if( $(this).is(':checked')){
                $(this).parents('tr').css('background-color','#41f5e07d');
                }else{
                    $(this).parents('tr').css('background-color','');

                }
             array=[]
            
            $('.__table input[type="checkbox"]').each(function(){
                if($(this).is(':checked')){
                array.push($(this).val())

               }
            if(array.length !== 0){

                if (array.length !== 1) {
                    $('.container_icon').removeClass('justify-content-end')
                    $('.container_icon').addClass('justify-content-between')
                    $('.delete-edit').html(`
                    <a href="#" title="حذف " data-toggle="modal" data-target="#exampleModal" class=" mx-2">
            <span class="__icon bg-danger">
                <i class="fa fa-trash"></i>
            </span>
           </a>
                    `)
                }else{

                    $('.container_icon').removeClass('justify-content-end')
                    $('.container_icon').addClass('justify-content-between')
                    $('.delete-edit').html(`
                    <a href="#" title="حذف " data-toggle="modal" data-target="#exampleModal" class=" mx-2">
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

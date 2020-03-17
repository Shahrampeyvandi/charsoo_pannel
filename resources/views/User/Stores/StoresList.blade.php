@extends('Layouts.Pannel.Template')

@section('content')

<div class="modal fade" id="showStore" tabindex="-1" role="dialog" aria-labelledby="showStoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="" class="w-100 img-fluid">
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">مناطق تحت پوشش</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body locations">

            </div>

        </div>
    </div>
</div>
{{-- modal for delete --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                <a type="button" class="delete btn btn-danger text-white">حذف! </a>
            </div>
        </div>
    </div>
</div>


{{-- modal for create --}}

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div id="wizard2">
                    <form id="example-advanced-form" method="post" action="{{route('Pannel.Services.submitStore')}}"
                        enctype="multipart/form-data">
                        @csrf
                        <h3>مشخصات فردی</h3>
                        <section>
                            <div class="row">
                                <div class="col-md-12"
                                    style="display: flex;align-items: center;justify-content: center;">
                                    <div class="profile-img">
                                        <div class="chose-img">
                                            <input type="file" class="btn-chose-img" name="owner_profile"
                                                title="نوع فایل میتواند png , jpg  باشد">
                                        </div>
                                        <img style="border-radius: 50%;object-fit: contain; background: #fff; max-width: 100%; height: 100%; width: 100%;"
                                            src="{{route('BaseUrl')}}/Pannel/img/temp_logo.jpg" alt="">
                                        <p class="text-chose-img"
                                            style="position: absolute;top: 44%;left: 14%;font-size: 13px;">انتخاب
                                            پروفایل</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6" style="padding-top: 11px;">
                                    <label class="form-control-label"> <span class="text-danger">*</span> تلفن همراه
                                    </label>
                                    <input class="form-control text-right" id="p_mobile" name="mobile" placeholder=""
                                        type="number" dir="ltr">

                                </div><!-- form-group -->
                                <div class="form-group col-md-6">
                                    <label>نام </label>
                                    <input type="text" id="firstname" name="firstname" class="form-control"
                                        placeholder="نام">
                                    <div class="valid-feedback">
                                        صحیح است!
                                    </div>
                                </div><!-- form-group -->
                            </div>
                            <div class="row">




                                <div class="form-group col-md-6">
                                    <label>نام خانوادگی</label>
                                    <input type="text" id="lastname" name="lastname" class="form-control"
                                        placeholder="نام خانوادگی">
                                    <div class="valid-feedback">
                                        صحیح است!
                                    </div>
                                </div><!-- form-group -->
                                <div class="form-group col-md-6">
                                    <label>تاریخ تولد </label>
                                    <input type="text" class="form-control ltr" name="birth_year" id="birth_year"
                                        data-inputmask="'mask': '9999/99/99'" data-mask>
                                    <div class="valid-feedback">
                                        صحیح است!
                                    </div>
                                </div><!-- form-group -->
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>کد ملی </label>
                                    <input type="number" onblur="checknationalcode(this.value)" name="national_num"
                                        id="user_national_num" class="form-control" placeholder="">
                                    <div class="valid-feedback">
                                        صحیح است!
                                    </div>
                                </div><!-- form-group -->
                                <div class="form-group col-md-6">
                                    <label for="recipient-name" class="col-form-label">جنسیت: </label>
                                    <select name="gender" class="form-control" id="exampleFormControlSelect2">
                                        <option value="مرد">مرد</option>
                                        <option value="زن">زن</option>
                                    </select>
                                </div>
                            </div>




                        </section>
                        <h3>اطلاعات تماس</h3>
                        <section>
                            <div class="row">   
                                
                                <div class="form-group col-md-6">
                                <label class="form-control-label"><span class="text-danger">*</span> تلفن محل
                                    کار</label>
                                <input id="tel_work" class="form-control text-right" name="tel_work"
                                    onblur="validatePhone(event,this.value)" placeholder="" type="number" dir="ltr">

                            </div><!-- form-group -->
                                <div class="form-group col-md-6">
                                    <label class="form-control-label"> تلفن منزل: </label>
                                    <input id="tel_home" class="form-control text-right" name="tel_home"
                                        onblur="validatePhone(event,this.value)" placeholder="" type="number" dir="ltr">

                                </div><!-- form-group -->
                           
                            </div>




                        </section>
                        <h3>مشخصات فروشگاه </h3>
                        <section>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-control-label"><span class="text-danger">*</span> نام فروشگاه:
                                    </label>
                                    <input id="store_name" class="form-control text-right" name="store_name"
                                        placeholder="" type="text" dir="ltr">
                                </div><!-- form-group -->
                                <div class="form-group col-md-12">
                                    <label class="form-control-label">حوزه فعالیت</label>
                                    <input id="store_type" class="form-control text-right" name="store_type"
                                        placeholder="" type="text" dir="ltr">
                                </div><!-- form-group -->

                                <div class="form-group col-md-12">
                                    <label for="recipient-name" class="col-form-label">توضیحات تکمیلی: </label>
                                    <textarea id="store_descripton" class="form-control text-right"
                                        name="store_descripton" type="text" dir="rtl"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="form-control-label">تصویر فروشگاه:</label>
                                    <input id="store_picture" class="form-control text-right" name="store_picture"
                                        placeholder="" type="file" dir="rtl">
                                </div><!-- form-group -->
                                <div class="form-group col-md-6">
                                    <label for="recipient-name" class="col-form-label">نام شهر: </label>
                                    <select name="city" class="form-control" id="exampleFormControlSelect2">

                                        <option value="مشهد">مشهد</option>
                                        <option value="نیشابور">نیشابور</option>
                                        <option value="فریمان">فریمان</option>
                                        <option value="سبزوار">سبزوار</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="recipient-name" class="col-form-label">نام خیابان اصلی: </label>
                                    <input id="store_main_street" class="form-control text-right"
                                        name="store_main_street" type="text" dir="rtl">
                                </div>



                                <div class="form-group col-md-12">
                                    <label for="recipient-name" class="col-form-label">نام خیابان فرعی: </label>
                                    <input id="store_secondary_street" class="form-control text-right"
                                        name="store_secondary_street" type="text" dir="rtl">
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="recipient-name" class="col-form-label">شماره پلاک </label>
                                    <input id="store_pluck_num" class="form-control text-right" type="number"
                                        name="store_pluck_num" dir="rtl">
                                </div>

                            </div>
                        </section>
                        <h3>ادرس فروشگاه </h3>
                        <section>


                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="recipient-name" class="col-form-label">نام شهر: </label>
                                    <select name="store_city" class="form-control" id="store_city">
                                        <option value="">باز کردن فهرست انتخاب</option>
                                        <option value="مشهد">مشهد</option>
                                        <option value="نیشابور">نیشابور</option>
                                        <option value="فریمان">فریمان</option>
                                        <option value="سبزوار">سبزوار</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 regions">

                                </div>
                            </div>


                        </section>
                        <h3>محصولات</h3>
                        <section>
                            <div class="row product-detail mb-2" style="position: relative;">
                                <div class="form-group col-md-6">
                                    <label for="recipient-name" class="col-form-label">نام محصول</label>
                                    <input id="product_name" class="form-control text-right" name="product_name[]"
                                        type="text" dir="rtl">

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="recipient-name" class="col-form-label">قیمت محصول</label>
                                    <input id="product_price" class="form-control text-right" name="product_price[]"
                                        type="number" dir="rtl">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="recipient-name" class="col-form-label">تصویر محصول</label>
                                    <input id="product_picture" class="form-control text-right" name="product_picture[]"
                                        type="file" dir="rtl">
                                </div>
                                {{-- <div class="form-group  col-md-6 pt-4">
                                    <span>وضعیت محصول</span>
                                    <div class="">
                                        <label class="" for="">فعال</label>
                                        <input style="display:inline-block;" value="1" type="checkbox" class=""
                                            name="product_status[]" id="">
                                    </div>
                                </div> --}}
                                <div class="form-group col-md-12">
                                    <label for="recipient-name" class="col-form-label">توضیح محصول: </label>
                                    <textarea id="product_description" class="form-control text-right"
                                        name="product_description[]" type="text" dir="rtl"></textarea>
                                </div>
                            </div>
                            <div class="clone"></div>
                            <a href="#" class="clone-bottom">افزودن محصول</a>
                        </section>
                        <h3>محصولات متفرقه: </h3>
                        <section>
                            <div class="row sundry-product-detail mb-2" style="position: relative;">
                                <div class="form-group col-md-6">
                                    <label for="recipient-name" class="col-form-label">نام محصول</label>
                                    <input id="sundry_product_name" class="form-control text-right"
                                        name="sundry_product_name[]" type="text" dir="rtl">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="recipient-name" class="col-form-label">قیمت محصول</label>
                                    <input id="sundry_product_price" class="form-control text-right"
                                        name="sundry_product_price[]" type="number" dir="rtl">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="recipient-name" class="col-form-label">تصویر محصول</label>
                                    <input id="sundry_product_picture" class="form-control text-right"
                                        name="sundry_product_picture[]" type="file" dir="rtl">
                                </div>
                            </div>
                            <div class="clone"></div>
                            <a href="#" class="sundry-clone-bottom">افزودن محصول</a>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

{{-- modal for edit --}}

<div class="modal fade bd-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content edit-modal-content">
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="container_icon card-body d-flex justify-content-end">
            <div class="delete-edit" style="display:none;">
                @if (auth()->user()->hasRole('admin_panel'))
                <a href="#" title="حذف " data-toggle="modal" data-target="#exampleModal" class="order-delete   m-2">
                    <span class="__icon bg-danger">
                        <i class="fa fa-trash"></i>
                    </span>
                </a>
                @endif
                @if (auth()->user()->can('personal_edit'))

                <a href="#" title="تازه سازی" data-toggle="modal" data-target=".bd-example-modal-lg-edit" class="mx-2">
                    <span class="edit-personal __icon bg-info">
                        <i class="fa fa-edit"></i>
                    </span>
                </a>
                @endif
            </div>
            <div>
                <a href="#" class="mx-2 btn--filter" title="فیلتر اطلاعات">
                    <span class="__icon bg-info">
                        <i class="fa fa-search"></i>
                    </span>
                </a>
                @if (auth()->user()->can('personal_insert'))
                <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg" title="افزودن کاربر">
                    <span class="__icon bg-success">
                        <i class="fa fa-plus"></i>
                    </span>
                </a>
                @endif
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
            <form action=" {{route('Personals.FilterData')}} " method="post">
                @csrf
                <div class="row ">

                    <div class="form-group col-md-6">
                        <label for="recipient-name" class="col-form-label">فیلتر اطلاعات براساس: </label>
                        <select required name="type_send" class="form-control" id="personal-filter">

                            <option value="نام">نام</option>
                            <option value="نام خانوادگی">نام خانوادگی</option>
                            <option value="وضعیت">وضعیت</option>
                            <option value="نام کاربری">نام کاربری</option>
                            <option value="کد ملی">کد ملی</option>
                            <option value="شماره موبایل">شماره موبایل</option>

                        </select>
                    </div>
                    <div class="word_field form-group col-md-6" style="display:block;">
                        <label for="recipient-name" class="col-form-label">عبارت مورد نظر: </label>
                        <input type="text" name="word" class="form-control" id="word">
                    </div>
                    <div class="status_options form-group col-md-6" style="display:none;">
                        <label for="recipient-name" class="col-form-label">وضعیت: </label>
                        <select required name="word" class="form-control" id="word">
                            <option value="فعال">فعال</option>
                            <option value="غیر فعال">غیر فعال</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">

                        <button type="submit" class="btn btn-outline-primary">جست و جو</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h5 class="text-center">مدیریت فروشگاه ها</h5>
                <hr>
            </div>
            <div style="overflow-x: auto;">
                <table id="example1" class="table table-striped  table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ردیف</th>
                            <th>
                                نام فروشگاه
                                {{-- <a href="#" data-id="name" class="store_field text-white">
                                    نام فروشگاه
                                    <i class="fa fa-angle-down"></i>
                                </a> --}}
                            </th>
                            <th>مالک فروشگاه</th>
                            <th>شماره تماس فروشنده</th>
                            <th>
                                ادرس فروشگاه
                                {{-- <a href="#" data-id="family" class="store_field text-white">
                                    ادرس فروشگاه
                                    <i class="fa fa-angle-down"></i>
                                </a> --}}
                            </th>
                            <th>درباره فروشگاه</th>
                            <th>
                                نام شهر
                            </th>
                            <th>تعداد محصولات</th>
                            <th>مناطق تحت پوشش</th>
                            <th>عکس فروشگاه</th>

                        </tr>
                    </thead>
                    <tbody class="tbody">
                        @foreach ($stores as $key=>$store)
                        <tr>
                            <td>
                                <div class="checkpersonal custom-control custom-checkbox custom-control-inline"
                                    style="margin-left: -1rem;">
                                    <input data-id="{{$store->id}}" type="checkbox" id="{{ $key}}" name="checkbox"
                                        class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="{{$key}}"></label>
                                </div>
                            </td>
                            <td> {{$key+1}} </td>
                            <td>{{$store->store_name}}</td>
                            <td>
                                @php
                                $personal = \App\Models\personals\personal::where('id',$store->owner_id)->first();
                                @endphp
                                @if (!is_null($personal))
                                {{$personal->personal_firstname .' '.$personal->personal_lastname}}
                                @endif
                            </td>
                            <td>
                                {{$personal->personal_mobile}}
                            </td>
                            <td>{{$store->store_city . ' - '.$store->store_main_street . ' - '.$store->store_secondary_street .' - '.$store->store_pelak}}
                            </td>
                            <td>
                                @if ($store->store_description !== null)
                                {{$store->store_description}}
                                @else
                                --
                                @endif

                            </td>
                            <td>{{$store->store_city}}</td>
                            <td>
                                {{$store->products->count() }}
                            </td>
                            <td>
                                <a href="#" title="مشاهده مناطق " data-id="{{$store->id}}" data-toggle="modal"
                                    data-target="#locationModal">
                                    <i class="fa fa-map-marker fa-2x"></i>
                                </a>
                            </td>
                            <td>
                                @if ($store->store_picture !== '' && $store->store_picture !== null)
                                <a href="#" title="مشاهده تصویر" data-toggle="modal" data-target="#showStore">
                                    <img width="75px" class="img-fluid "
                                        src="{{asset("uploads/stores/$store->store_picture")}} " />
                                </a>
                                @else
                                --
                                @endif
                            </td>
                        </tr>
                        @endforeach
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
<!-- begin::form wizard -->
<script src="{{route('BaseUrl')}}/Pannel/assets/vendors/form-wizard/jquery.steps.min.js"></script>
<script src="{{route('BaseUrl')}}/Pannel/assets/js/examples/form-wizard.js"></script>
<!-- end::form wizard -->
<script src="{{route('BaseUrl')}}/Pannel/assets/input-mask/jquery.inputmask.js"></script>
<script src="{{route('BaseUrl')}}/Pannel/assets/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="{{route('BaseUrl')}}/Pannel/assets/input-mask/jquery.inputmask.extensions.js"></script>
<script>
    function isValidDate(dtValue2) {
    // your desired pattern
    
    var pattern = /^(\d{4})\/(\d{2})\/(\d{2})$/
    var m = dtValue2.match(pattern);
    if (!m){
        swal("", "تاریخ تولد صحیح نمیباشد", "error", {
			button: "باشه"
        });
        document.getElementById('birth_year1').value = "";
    }
   

}

    $(function () {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


//  //Datemask dd/mm/yyyy
//  $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
//     //Datemask2 mm/dd/yyyy
//     $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()
       
        $('.btn--filter').click(function(){
          $('.filtering').toggle(200)
        })

           $('.checkpersonal input[type="checkbox"]').change(function(){
            array=[]
            $('.checkpersonal input[type="checkbox"]').each(function(){
                if($(this).is(':checked')){
                  array.push($(this).attr('data-id'))
               }
            if(array.length !== 0){
                $('.delete-edit').show()
                if (array.length !== 1) {
                    $('.container_icon').removeClass('justify-content-end')
                    $('.container_icon').addClass('justify-content-between')
                    $('.edit-personal').hide()
                }else{

                    $('.container_icon').removeClass('justify-content-end')
                    $('.container_icon').addClass('justify-content-between')
                    $('.edit-personal').show() 
                }
            }
            else{
                $('.container_icon').removeClass('justify-content-between')
                $('.container_icon').addClass('justify-content-end')
                $('.delete-edit').hide()
            }
        })
            
    })

$(document).on('click','.clone-bottom',function(e){
  e.preventDefault()
  let cloned = $(this).siblings('.product-detail').clone()
  cloned.find('input[type="text"]').val('')
  cloned.find('input[type="hidden"]').val('')
  cloned.find('input[type="file"]').val('')
  cloned.find('input[type="number"]').val('')
  cloned.find('img').attr('src','')
  cloned.find('textarea').val('')
  cloned.find('.delete_status').remove()
  cloned.find('p.text-chose-img').text('انتخاب تصویر')
  cloned.prepend(`<a class="remove-product" href="#" >
                                    <i class="fa fa-close"></i>
                                </a>`)
  $(this).prev('.clone').append(cloned)
})
$(document).on('click','.sundry-clone-bottom',function(e){
  e.preventDefault()
  let cloned = $(this).siblings('.row').clone()
  cloned.prepend(`<a class="remove-product" href="#" >
                                    <i class="fa fa-close"></i>
                                </a>`)
 $(this).prev('.clone').append(cloned)

})


$(document).on('click','.remove-product',function(e){
    e.preventDefault()
    $(this).parents('.product-detail').remove()
  
})
$(document).on('click','.remove-product',function(e){
    e.preventDefault()
    $(this).parents('.sundry-product-detail').remove()
  
})






$(document).on('shown.bs.modal','.bd-example-modal-lg',function(){
    $('.date-picker-shamsi-list').datepicker({
		dateFormat: "yy/mm/dd",
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true
	});
})
$('#locationModal').on('shown.bs.modal', function (event) {
    
  let store_id = $(event.relatedTarget).data('id')
    $.ajax({
    type:'post',
    url:'{{route("Store.getLocations")}}',
    cache: false,
    async: true,
    data:{store_id:store_id},
    success:function(data){
       $('.locations').html(data)
    }
})
})
// Edit
$('.bd-example-modal-lg-edit').on('shown.bs.modal', function (event) {
   store_id =  $('tbody input[name="checkbox"]:checked').attr('data-id')
    $.ajax({
    type:'post',
    url:'{{route("Store.Edit.getData")}}',
    cache: false,
    async: true,
    data:{store_id:store_id},
    success:function(data){
       $('.edit-modal-content').html(data)
    //    $('.js-example-basic-single').select2({
    //      placeholder: 'انتخاب کنید'
    //     });
        editform= $('#edit--form')
        var form = $("#example-advanced-form1").show();
    form.validate({
        rules: {
            firstname:{
                required:true
            },
            lastname:{
                required:true
            },
            tel_work: {
            required:true
        },
        store_name: {
            required:true
        },
        store_city : {
            required:true
        },
        store_main_street:{
            required:true
        },
        store_pluck_num:{
            required:true
        },
        mobile:{
            required:true
        }
        
         
            
        
        },
        messages: {
            firstname: {
            required:' نام فروشنده را وارد نمایید'
        },
        lastname: {
            required:' نام خانوادگی فروشنده را وارد نمایید'
        },
            store_name: {
            required:' نام فروشگاه را وارد نمایید'
        },
        store_city: {
            required:' نام شهر را وارد نمایید'
        },
        store_main_street:{
            required: 'نام خیابان اصلی را وارد نمایید'
        },
        store_pluck_num:{
            required: 'شماره پلاک را وارد نماید'
        },
        mobile:{
            required: 'شماره موبایل را وارد کنید'
        },
        tel_work: {
            required:'شماره محل کار را وارد نمایید'
        },
        }
      });
    form.steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    labels: {
        cancel: 'انصراف',
        current: 'قدم کنونی:',
        pagination: 'صفحه بندی',
        finish: 'ثبت اطلاعات',
        next: 'بعدی',
        previous: 'قبلی',
        loading: 'در حال بارگذاری ...'
    },
    onStepChanging: function (event, currentIndex, newIndex)
    {
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex)
        {
            return true;
        }
        // Forbid next action on "Warning" step if the user is to young
        if (newIndex === 3 && Number($("#age-2").val()) < 18)
        {
            return false;
        }
        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex)
        {
            // To remove error styles
            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }
        
        return form.valid();
    },
    onStepChanged: function (event, currentIndex, priorIndex)
    {
        // Used to skip the "Warning" step if the user is old enough.
        if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
        {
            form.steps("next");
        }
        // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
        if (currentIndex === 2 && priorIndex === 3)
        {
            form.steps("previous");
        }
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        form.submit()
        
    }
}).validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {
        confirm: {
            equalTo: "#password-2"
        }
    }
});
 //Datemask dd/mm/yyyy
 $('#birth_year').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
$('#birth_year').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
   

        $('[data-mask]').inputmask()
    

         }
    
      });
    
    }); 




   




// Delete
   

    $('.delete').click(function(e){
                e.preventDefault()
                console.log(array)

                // ajax request
      $.ajax({
                type:'post',
                url:'{{route("Personal.Delete")}}',
                data:{array:array},
                success:function(data){
                  swal("حذف با موفقیت انجام شد", {
                    icon: "success",
					          button: "تایید"
                       });
                       setTimeout(()=>{
                        location.reload()
                       },2000)
                }
        })
    })
//check national num 
$(document).on('blur','#national_num',function(){
    var personal_national_code = $(this).val();
    var thiss = $(this);
    var personal_id = $(this).attr('data-id');
$.ajax({
type:'post',
url:'{{route("Personal.CheckNationalNum")}}',
data:{personal_national_code:personal_national_code,
    personal_id:personal_id
},
success:function(data){
    if (data.error) {
        swal("خطا!", data.error, "error", {
			button: "باشه"
        });
        thiss.val('')
    }
}
})
})

$('#personal-filter').click(function(){
    if ($(this).val() == 'وضعیت') {
        $('.word_field').hide()
        $('.status_options').show()
    }else{
        $('.status_options').hide()
        $('.word_field').show()
    }
})

// OrderBy Personals
var namefield = $('.name_field')
namefield.click(function(e){
  e.preventDefault();
 var data = $(this).attr('data-id');
 $.ajax({
type:'post',
url:'{{route("Personal.OrderBy.Table")}}',
data:{data:data},
success:function(data){ 
   $('.tbody').html(data)
   }
 })
})
$('#p_mobile').blur(function(){
var mobile = $(this).val();
var thiss = $(this);
if(mobile !== ''){
    $.ajax({
type:'post',
url:'{{route("Store.getOwnerData")}}',
data:{mobile:mobile},
success:function(data){
    $('#firstname').val(data.personal_firstname)
    $('#lastname').val(data.personal_lastname)
    $('#user_national_num').val(data.personal_national_code)
    $('#birth_year').val(data.personal_birthday)

}
})
}
})

$(document).on('change','#store_city_edit',function(){


let city_name = $(this).val();
let store_id = $(this).data('id')
$.ajax({
type:'post',
url:'{{route("Store.Edit.getCityRegions")}}',
data:{city_name:city_name,store_id:store_id},
success:function(data){ 
    $('.regions').html(data)
}
})
})
$(document).on('change','#store_city',function(){


    let city_name = $(this).val();
    $.ajax({
    type:'post',
    url:'{{route("Store.getCityRegions")}}',
    data:{city_name:city_name},
    success:function(data){ 
        $('.regions').html(data)
    }
  })
})
$('#showStore').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.find('img').attr('src') // Extract info from data-* attributes
  var modal = $(this)
  modal.find('img').attr('src',recipient)
})
})
</script>
@endsection
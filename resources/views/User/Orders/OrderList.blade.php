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

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ثبت کاربر</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="user--form" method="post" action=" {{route('User.Submit')}} " enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          
          <div class="row">
            <div class="form-group col-md-6">
              <label for="user_name" class="col-form-label"><span class="text-danger">*</span> نام: </label>
              <input type="text" class="form-control" name="user_name" id="user_name">
            </div>
            <div class="form-group col-md-6">
              <label for="user_family" class="col-form-label"><span class="text-danger">*</span> نام خانوادگی:</label>
              <input type="text" class="form-control" name="user_family" id="user_family">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="user_pass" class="col-form-label"><span class="text-danger">*</span> شماره همراه:</label>
              <input type="text" class="form-control" name="user_pass" id="user_pass">
            </div>
            <div class="form-group col-md-6">
              <label for="confirm_user_pass" class="col-form-label"><span class="text-danger">*</span> 
                توضیحات:</label>
              <textarea type="text" class="form-control" name="confirm_user_pass" id="confirm_user_pass">

              </textarea>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label for="user_email" class="col-form-label">انتخاب شهر:</label>
              <input type="text" class="form-control" name="user_email" id="user_email">
            </div>
            <div class="form-group col-md-6">
              <label for="username" class="col-form-label"><span class="text-danger">*</span> ادرس دقیق: </label>
              <textarea type="text" class="form-control" name="username" id="username">
              </textarea>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">انتخاب ساعت اول درخواستی:</label>
                <select required name="type_send"   class="form-control" id="exampleFormControlSelect2">
                    <option value="8-12">8-12</option>
                    <option value="12-16">12-16</option>  
                    <option value="16-20">16-20</option>  
                    <option value="20-24">20-24</option>  
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="user_email" class="col-form-label">انتخاب تاریخ اول درخواستی: </label>
                <input type="text"
                 class="date-picker-shamsi form-control"
                  name="user_email" id="user_email"
                  autocomplete="off"
                  >
              </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
                <label for="recipient-name" class="col-form-label">انتخاب ساعت دوم درخواستی:</label>
                <select required name="type_send"   class="form-control" id="exampleFormControlSelect2">
                    <option value="8-12">8-12</option>
                    <option value="12-16">12-16</option>  
                    <option value="16-20">16-20</option>  
                    <option value="20-24">20-24</option>  
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="user_email" class="col-form-label">انتخاب تاریخ دوم درخواستی: </label>
                <input type="text"
                 class="date-picker-shamsi form-control"
                  name="user_email" id="user_email"
                  autocomplete="off"
                  >
              </div>
          </div>
          
         
         


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
          <button type="submit" class="btn btn-primary">ذخیره</button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- modal for edit --}}

<div class="modal fade bd-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">    <div class="modal-dialog modal-lg">
    <div class="modal-content edit-modal-content">
      
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
            <a href=" {{route('Pannel.Services.Questions')}} " title="تازه سازی" class="mx-2" >
                <span class="__icon bg-primary">
                    <i class="fa fa-refresh"></i>
                </span>
            </a>
           </div>
        </div>
    </div>

      {{-- filtering --}}
      <div class="card filtering" style="display:none;">
        <form action=" {{route('Service.FilterData')}} " method="post">
            @csrf
            <div class="card-body">
                <div class="row " >
                  <div class="form-group col-md-6">
                    <label for="recipient-name" class="col-form-label">فیلتر اطلاعات براساس: </label>
                    <select  name="type_send"   class="form-control" id="filtering">
                        <option value="عنوان">عنوان</option>
                        <option value="نوع">نوع</option>  
                        <option value="نقش">نقش</option>  
                        <option value="نوع قیمت">نوع قیمت</option> 
                        <option value="نوع ارجاع">نوع ارجاع</option> 
                       
                    </select>
                </div>
                <div class="form-group col-md-6 search-box">
                  <label for="recipient-name" class="col-form-label">عبارت مورد نظر: </label>
                  <input type="text" class="form-control" name="word" id="word">
                </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
        
                    <button type="submit" class="btn btn-outline-primary">جست و جو</button>
                  </div>
                </div>
              </div>
        </form>
      </div>


    <div class="card">
        <div class="card-body" >
            <div class="card-title">
                <h5 class="text-center">مدیریت خدمات</h5>
                <hr>
            </div>
               <div style="overflow-x: auto;">
                <table  id="example1" class="table table-striped  table-bordered" >
                    <thead>
                    <tr>
                        <th></th>
                        <th>ردیف</th>
                        <th>
                            <a href="#" data-id="title" class="name_field text-white">
                                عنوان
                                <i class="fa fa-angle-down"></i>  
                              </a>
                        </th>
                        <th>
                            <a href="#" data-id="broker_name" class="name_field text-white" >
                                نام کارگزاری
                                <i class="fa fa-angle-down"></i>  
                              </a>
                        </th>
                        <th> توضیحات</th>
                        <th>دسته بندی خدمات</th>
                        <th> نقش</th>
                        <th>فاصله</th>
                        <th>
                            <a  href="#" data-id="persent" class="name_field text-white">
                                درصد پورسانت
                                <i class="fa fa-angle-down"></i>  
                            </a>
                        </th>
                        <th>پیشنهاد ویژه در خدمات زیر</th>
                        <th>نوع خدمت</th>
                        <th>نوع ارجاع</th>

                        <th>عکس</th> 
                    </tr>
                    </thead>
                    <tbody class="tbody">
                        @foreach ($orders as $key=> $order)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox custom-control-inline" style="margin-left: -1rem;">
                                <input data-id=" {{$order->id}} " type="checkbox" id="{{ $key}}" name="customCheckboxInline1" class="custom-control-input" value="1">
                                  <label class="custom-control-label" for="{{$key}}"></label>
                                </div>
                            </td>
                            <td> {{$key+1}} </td>
                            <td>{{$order->order_title}}</td>
                            <td>{{$order->order_broker_name}}</td>
                            <td>
                                @if ($order->order_desc !== null)
                                {{$order->order_desc}}
                                @else
                                --
                                @endif
                            
                            </td>
                            <td>
                                @if ($service->relationCategory !== null)
                                {{$service->relationCategory->category_title}} 
                                @else
                                    ندارد
                                @endif
                            </td>
                            <td>{{$service->service_rol}}</td>
                            <td>--</td>
                            <td>
                              {{$service->service_percentage . '%'}}
                            </td>
                            <td>
                                {{$service->service_special_category}}
                            </td>
                            <td>{{$service->price_type}}</td>
                            <td>{{$service->service_type_send}}</td>
                            <td> 
                            @if ($service->service_icon !== '')
                                <img width="75px" class="img-fluid " src=" {{asset("uploads/service_icons/$service->service_title/$service->service_icon")}} " />
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

    <style>
         select {
      font-family: 'FontAwesome', 'sans-serif';
      font-size: 15px;
    font-weight: 600;
    }
    </style>
@endsection

@section('js')
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<!-- begin::form wizard -->
<script src="{{route('BaseUrl')}}/Pannel/assets/vendors/form-wizard/jquery.steps.min.js"></script>
<script src="{{route('BaseUrl')}}/Pannel/assets/js/examples/form-wizard.js"></script>
<!-- end::form wizard -->
    <script>
    $(document).ready(function(){
    $.ajaxSetup({

         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

     $('#price_type').click(function(){
         if($(this).val() == 'رقمی'){
             
             $('#price-wrapper').show(250)
         }else{
            $('#price-wrapper').hide(250)
  
         }
     })


        $('.btn--filter').click(function(){
          $('.filtering').toggle(200)
        })
        
            $(document).on('change','.table input[type="checkbox"]',function(){
                if( $(this).is(':checked')){
                $(this).parents('tr').css('background-color','#41f5e07d');
                }else{
                    $(this).parents('tr').css('background-color','');

                }

             array=[]
            
            $('.table input[type="checkbox"]').each(function(){
                if($(this).is(':checked')){
                    array.push($(this).attr('data-id'))

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

$('.bd-example-modal-lg-edit').on('shown.bs.modal', function (event) {
   category_id =  $('table input[type="checkbox"]:checked').attr('data-id')
    $.ajax({
    type:'post',
    url:'{{route("Service.Edit.getData")}}',
    cache: false,
    async: true,
    data:{category_id:category_id},
    success:function(data){
       $('.edit-modal-content').html(data)
       $('.js-example-basic-single').select2({
         placeholder: 'انتخاب کنید'
        });
        editform= $('#edit--form')
        var form = $("#example-advanced-form1").show();
    form.validate({
        rules: {
          title: {
            required: true,
            // digits: true,
            // minlength: 5,
            // maxlength: 5
          },
          
          service_percentage: {
            required: true,
            range:[0,100]
          },
          firstname: {
            required:true
        }, 
        lastname: {
            required:true
        },
        national_num:{
            required:true,
            
            maxlength:10
        },
        work_experience_month_num: {
            required:true,
            range:[0,12]
        }
        },
        messages: {
          title: {
            //minlength: jQuery.format("Zip must be {0} digits in length"),
            //maxlength: jQuery.format("Please use a {0} digit zip code"),
            required: "لطفا عنوان را وارد نمایید"
          },
          service_category: {
            required:'سرگروه خدمت را انتخاب نمایید'
        },
        service_percentage: {
            required:'درصد پورسانت را وارد نمایید',
            range:'پورسانت حداکثر 100% میباشد'
        },
        firstname: {
            required:'لطفا نام خود را وارد نمایید'
        }, 
        lastname: {
            required:'لطفا نام خانوادگی خود را وارد نمایید'
        },
        national_num:{
            required: ' کد ملی خود را وارد نمایید',
            maxlength:'کد ملی بایستی حداکثر 10 رقم باشد'
        },
        work_experience_month_num: {
            required:'فیلد اجباری است',
            range:'ماه باید در بازه 0 تا12 باشد',
           
        }
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
        // var file =$('#service_icon')
        // var formData = new FormData($(this)[0]);
        // formData.append('file',$('#service_icon'))
        // console.log(formData)
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
         }
    
      });
    
    }); 


    // filtering
    $('#filtering').change(function(){
        if ($(this).val() == 'نوع قیمت') {
            $('.search-box').html(
                ` <div class="form-group wd-xs-300">
                                <label for="recipient-name" class="col-form-label">نوع خدمت:</label>
                                <select required name="word"   class="form-control" id="exampleFormControlSelect2">
                                    <option value="توافقی">توافقی</option>
                                    <option value="طبق لیست">طبق لیست</option>  
                                    <option value="رقمی">رقمی</option>  
                                </select>
                </div>`
            )
        }

        if ($(this).val() == 'نوع ارجاع') {

              $('.search-box').html(
                `  <div class="form-group wd-xs-300">
                                <label for="recipient-name" class="col-form-label">نوع ارجاع:</label>
                                <select required name="word"   class="form-control" id="exampleFormControlSelect2">
                                    <option value="ارجاع اتوماتیک">ارجاع اتوماتیک</option>
                                    <option value="ارجاع دستی">ارجاع دستی</option>  
                                    <option value="ارجاع منتخب">ارجاع منتخب</option>  
                                    <option value="ارجاع به کمترین فاصله">ارجاع به کمترین فاصله</option>  
                                </select>
                   </div>`
            )
        }
    });

    // Delete
    $('.delete').click(function(e){
                e.preventDefault()
                  $.ajax({

                type:'post',
                url:'{{route("Service.Delete")}}',
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


// OrderBy Services

var namefield = $('.name_field')
namefield.click(function(e){
  e.preventDefault();
 var data = $(this).attr('data-id');
 $.ajax({
type:'post',
url:'{{route("Service.OrderBy.Table")}}',
data:{data:data},
success:function(data){ 
   $('.tbody').html(data)
   }
 })
})

// Validate Icons

$("#service_icon").on("change", function () {
    
    var fileInput = $("#service_icon")[0],
    file = fileInput.files && fileInput.files[0];
  if( file ) {
    var img = new Image();
    img.src = window.URL.createObjectURL( file );
    img.onload = function() {
    var width = img.naturalWidth,
        height = img.naturalHeight;
    window.URL.revokeObjectURL( img.src );
    if(width <= 400 && height <= 400 ) {}else{
      swal("اخطار!", "فایل ایکون حداکثر باید در ابعاد 400X400 باشد", "warning", {
			button: "باشه"
    });
    $("#service_icon").val('')
    }
  }
  }
});

})
</script>
@endsection
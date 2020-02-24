@extends('Layouts.Pannel.Template')

@section('content')
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
                    <form id="example-advanced-form" method="post" action="{{route('Role.Submit')}}"
                        enctype="multipart/form-data">
                        @csrf
                        <h3>نقش</h3>
                        <section>
                            <div class="form-group wd-xs-300">
                                <label>نام </label>
                                <input type="text" id="role_name" name="role_name" class="form-control"
                                    placeholder="نام">

                            </div><!-- form-group -->

                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="broker_status" name="broker_status" class="custom-control-input"
                                  value="1">
                                <label class="custom-control-label" for="broker_status">به عنوان کارگزاری در نظر
                                    گرفته شود</label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="sub_broker_status" name="broker_status" class="custom-control-input"
                                  value="1">
                                <label class="custom-control-label" for="sub_broker_status">به عنوان زیر مجموعه کارگزاری در نظر گرفته شود
                                    </label>
                              </div>
                           
                            
                            <div class="form-group wd-xs-300 broker-select" style="display:none;">
                                <label for="recipient-name" class="col-form-label">نام کارگزاری</label>
                                <select  name="broker_id"   class="form-control" id="exampleFormControlSelect2">
                                    <option value="" selected="">باز کردن فهرست انتخاب</option>
                                  @foreach ($brokers as $broker)
                                  <option value="{{$broker->id}}">{{$broker->name}}</option>  
                                  @endforeach
                                </select>
                            </div>
                        </section>
                        <h3> مجوز ها</h3>
                        <section>
                            <p>کاربران</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="user_menu" name="user_menu"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="user_menu">منو کاربر</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row user--permisions" style="display:none;">
                                <div class="col-md-6">
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="user_list" name="user_list"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="user_list">لیست کاربر</label>
                                        </div>

                                    </div>
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="insert_user" name="insert_user"
                                                class="custom-control-input" value="1" >
                                            <label class="custom-control-label" for="insert_user">ثبت کاربر</label>
                                        </div>

                                    </div>
                                
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="user_pass" name="user_pass"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="user_pass">تغییر پسورد
                                                کاربر</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="user_delete" name="user_delete"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="user_delete">حذف کاربر</label>
                                        </div>

                                    </div>
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="user_edit" name="user_edit"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="user_edit">ویرایش کاربر</label>
                                        </div>
                                    </div>
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="user_transaction" name="user_transaction"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="user_transaction">تراکنش های
                                                کاربر</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <hr>
                            <p>گزارش خدمت رسان های انلاین</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="personal_online_menu" name="personal_online_menu"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="personal_online_menu">منو خدمت رسان
                                                های انلاین</label>
                                        </div>

                                    </div>
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="personal_online_list" name="personal_online_list"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="personal_online_list">لیست خدمت
                                                رسان های انلاین</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <p>شهر</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="city_insert" name="city_insert"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="city_insert">ثبت شهر</label>
                                        </div>

                                    </div>
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="city_edit" name="city_edit"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="city_edit">ویرایش شهر</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="city_delete" name="city_delete"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="city_delete">حذف شهر</label>
                                        </div>
                                    </div>
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="city_menu" name="city_menu"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="city_menu">منوی شهر</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="city_list" name="city_list"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="city_list">لیست شهر</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <p>مشتری</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="customer_menu" name="customer_menu"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="customer_menu">منوی مشتری</label>
                                        </div>

                                    </div>
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="customer_list" name="customer_list"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="customer_list">لیست مشتری</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="customer_delete" name="customer_delete"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="customer_delete">حذف مشتری</label>
                                        </div>
                                    </div>
                                    <div class="form-group wd-xs-300">
                                        <div class="custom-control custom-checkbox custom-control-inline"
                                            style="margin-left: -1rem;">
                                            <input type="checkbox" id="customer_excel" name="customer_excel"
                                                class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="customer_excel">خروجی اکسل</label>
                                        </div>
                                    </div>
                                </div>

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


<div class="modal fade bd-example-modal-lg-edit" id="exampleModal2" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content edit-modal-content">

        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="container_icon card-body d-flex justify-content-end">
            <div class="delete-edit">
            </div>
            <div>
                <a href="#" class="mx-2 btn--filter" title="فیلتر اطلاعات">
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
            <div class="row ">
                <div class="form-group col-md-6">
                    <label for="recipient-name" class="col-form-label">فیلتر اطلاعات براساس: </label>
                    <select required name="type_send" class="form-control" id="exampleFormControlSelect2">
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
                <h5 class="text-center">مدیریت نقش ها</h5>
                <hr>
            </div>
            <div style="overflow-x: auto;">
                <table id="example1" class="table table-striped  table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ردیف</th>
                            <th>نام نقش</th>
                            <th>کارگزاری مربوطه</th>
                            <th> مجوز ها</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key=>$role)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox custom-control-inline"
                                    style="margin-left: -1rem;">
                                    <input data-id=" {{$role->id}} " type="checkbox" id="{{ $key}}"
                                        name="customCheckboxInline1" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="{{$key}}"></label>
                                </div>
                            </td>
                            <td> {{$key+1}} </td>
                            <td>{{$role->name}}</td>
                            <td>
                                @if ($role->sub_broker !== null)
                                {{Spatie\Permission\Models\Role::where('id',$role->sub_broker)->first()->name}}
                                @endif
                               
                            </td>
                            <td>
                                @foreach (\Spatie\Permission\Models\Role::findByName($role->name)->permissions as
                                $permission)

                                @switch($permission->name)
                                @case('user_transaction')
                                <span> تراکنش</span>
                                @break
                                @case('user_pass')
                                <span>تغییر پسورد کاربر</span>
                                @break
                                @case('insert_user')
                                <span> ثبت کاربر</span>
                                @break
                                @case('user_menu')
                                <span> منو کاربر</span>
                                @break
                                @case('user_list')
                                <span> لیست کاربر</span>
                                @break
                                @case('user_delete')
                                <span> حذف کاربر</span>
                                @break
                                @case('user_edit')
                                <span> ویرایش کاربر</span>
                                @break
                                @case('personal_online_menu')
                                <span> منو خدمت رسان های انلاین</span>
                                @break
                                @case('personal_online_list')
                                <span> لیست خدمت رسان های انلاین</span>
                                @break
                                @case('city_insert')
                                <span> ثبت شهر</span>
                                @break
                                @case('city_delete')
                                <span> حذف شهر</span>
                                @break
                                @case('city_list')
                                <span> لیست شهر</span>
                                @break
                                @case('city_menu')
                                <span> منوی شهر</span>
                                @break
                                @case('city_edit')
                                <span> ویرایش شهر</span>
                                @break
                                @case('customer_menu')
                                <span> منوی مشتری</span>
                                @break
                                @case('customer_list')
                                <span> لیست مشتری</span>
                                @break
                                @case('customer_delete')
                                <span> حذف مشتری</span>
                                @break
                                @case('customer_excel')
                                <span> خروجی اکسل مشتری</span>
                                @break
                                @default
                                @endswitch
,,
                                @endforeach

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

      $('#sub_broker_status').click(function(){
          if ($(this).is(':checked')) {
              $('.broker-select').slideDown()
          }else{
            $('.broker-select').slideUp()

          }
      })  

      $('#broker_status').click(function(){
         
            $('.broker-select').slideUp()

          
      })  

      $('#create--city').validate({
     
        rules: {
          city_name: {
            required: true,
            // digits: true,
            // minlength: 5,
            maxlength: 20
          }
        },
        messages: {
          city_name: {
            //minlength: jQuery.format("Zip must be {0} digits in length"),
            maxlength:'نام حداکثر 20 کاراکتر میتواند داشته باشد',
            required: "لطفا نام شهر را وارد نمایید"
          },
        }
      })
        $('.btn--filter').click(function(){
          $('.filtering').toggle(200)
        })

           $('table input[type="checkbox"]').change(function(){
            if( $(this).is(':checked')){
            $(this).parents('tr').css('background-color','#41f5e07d');
            }else{
                $(this).parents('tr').css('background-color','');

            }
            array=[]
            $('table input[type="checkbox"]').each(function(){
                if($(this).is(':checked')){
                  array.push($(this).attr('data-id'))
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

           <a href="#" title="تازه سازی" data-toggle="modal" data-target="#exampleModal2" class="mx-2" >
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


                  // edit 

$('.bd-example-modal-lg-edit').on('shown.bs.modal', function (event) {
       id = $('table input[type="checkbox"]:checked').attr('data-id')
       $.ajax({
       type:'post',
       url:'{{route("Roles.Edit.getData")}}',
       cache: false,
       async: true,
       data:{id:id},
       success:function(data){
          $('.edit-modal-content').html(data)
          editform= $('#edit--city')
          var form = $("#example-advanced-form1").show();
    form.validate({
        rules: {
          role_name: {
            required: true,
            // digits: true,
            // minlength: 5,
            // maxlength: 5
          },
          
        
        },
        messages: {
          role_name: {
            //minlength: jQuery.format("Zip must be {0} digits in length"),
            //maxlength: jQuery.format("Please use a {0} digit zip code"),
            required: "لطفا عنوان را وارد نمایید"
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
         })
        })  

    $('.delete').click(function(e){
                e.preventDefault()
                console.log(array)

            // ajax request
                $.ajax({
                type:'post',
                url:'{{route("Role.Delete")}}',
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

     $('#user_menu').click(function(){
         if ($(this).is(':checked')) {
             $('.user--permisions').slideDown()
         }else{
            $('.user--permisions').slideUp()      
         }
     })
})
</script>
@endsection
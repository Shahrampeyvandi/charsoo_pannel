@extends('Layouts.Pannel.Template')

@section('content')



<div class="modal fade bd-example-modal-lg-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content edit-modal-content">
            
            
        </div>
    </div>
</div>

{{--model for add transaction--}}
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ایجاد منوی جدید</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="tranaction--form" method="post" action=" {{route('Pannel.AppManage.Menu.Submit')}} ">
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-12">
                  <label for="recipient-name" class="col-form-label">عنوان منو:</label>
                  <input type="text" class="form-control" name="title">
                </div>
              </div>
          <div class="row">
            <div class="form-group col-md-5">
              <label for="user_mobile" class="col-form-label"><span class="text-danger">*</span> اولویت نمایش:</label>
              <input type="text" class="form-control" name="priority">

       
            </div>
            <div class="form-group col-md-5">
              <label for="user_name" class="col-form-label"><span class="text-danger">*</span> نوع اطلاعات: </label>
              <select required name="type"  class="form-control" id="type">
                <option value="">انتخاب کنید</option>
                <option value="دسته بندی">دسته بندی</option>
                  <option value="خدمت">خدمت</option>  
                  <option value="فروشگاه">فروشگاه</option>  

              </select>

                      
            </div>

            <div class="form-group col-md-2">
                <label for="user_name" class="col-form-label"><span class="text-danger">*</span> پیشنهاد ویژه: </label>
                <div class="custom-control custom-switch">
                    <input style="display:inline-block;" value="1" type="checkbox" class="custom-control-input" name="sms_status" id="sms_status" >
                    <label class="custom-control-label" for="sms_status"></label>
                </div>
                        
              </div>

           
            
          </div>
          <div class="row">
            <div class="form-group col-md-6" id="categoryservice">
              <label for="user_family" class="col-form-label"><span class="text-danger">*</span>دسته بندی:</label>
              <select name="cateory" id="cateory"  class="js-example-basic-single" dir="rtl" >
                <option value="all" >همه</option>


    
            </select>
                    </div>
            <div class="form-group col-md-6" style="display:none;" id="storeorservice">
              <label for="user_desc" class="col-form-label"><span class="text-danger">*</span> 
                فروشگاه یا خدمت:</label>
                <select name="personals[]" id="personals_type"  class="js-example-basic-single" dir="rtl" multiple>
                    <option value="all" >همه</option>
                  
                    <option value="all1" >1همه</option>
                    <option value="all2" >هم2ه</option>
                    <option value="all3" >3همه</option>
        
                   
                </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <label for="user_address" class="col-form-label"> توضیحات: </label>
              <textarea type="text" class="form-control" name="description">
              </textarea>
            </div>
          </div>

  
          
      <!-- form-group -->

        </div>
        
        

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
          <button type="submit" class="btn btn-primary">ایجاد منو</button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- modal for edit --}}

<div class="container-fluid">
    <div class="card">
        <div class="container_icon card-body d-flex justify-content-end">
            <div class="delete-edit">

            </div>
            <div>
               

                <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg" title="افزودن منو">
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
   

    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h5 class="text-center">منو های اپلیکیشن مشتری</h5>
                <hr>
            </div>
            <div style="overflow-x: auto;">
                <table  id="example1" class="table table-striped  table-bordered" >
                    <thead>
                        <tr>
                            <th></th>
                            <th>اولویت</th>
                            <th>تیتر</th>
                            <th>نوع اطلاعات</th>

                            <th>ایتم ها</th>
                            <th>پیشنهاد ویژه</th>


                            <th>تاریخ ایجاد</th>
                        

                            <th>توضیحات</th>
                     
                         
                        </tr>
                    </thead>
                    <tbody class="tbody">
                        <td>
                            <div class="custom-control custom-checkbox custom-control-inline"
                                style="margin-left: -1rem;">
                                <input data-id="1" type="checkbox" id="1"
                                    name="customCheckboxInline1" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="1"></label>
            
                            </div>
                        </td>
 



                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')

<script>
    $(document).ready(function(){
 

        $('input[type="checkbox"]').change(function(){
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

    

    $(document).on('change','#type',function(){
        var data = $(this).val();

        if(data === 'دسته بندی'){
            $('#categoryservice').show()
            $('#storeorservice').hide()


            $.ajax({
type:'get',
url:'{{route("Pannel.Services.Category")}}',
success:function(data){ 
    
    $('#cateory').html(data)
   }
 })
// debugger;




        }else if(data === 'خدمت'){
            $('#categoryservice').hide()
            $('#storeorservice').show()
       }else if(data === 'فروشگاه'){
        $('#categoryservice').hide()
            $('#storeorservice').show()
                }
    


 var thiss = $(this)

})






    })
</script>
@endsection
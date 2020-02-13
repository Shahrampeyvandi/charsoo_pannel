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
                <h5 class="text-center">مدیریت مشتریان</h5>
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
                        <th>کد ملی</th>
                        <th>تاریخ ثبت</th>     
                        <th>تاریخ ویرایش</th>         
    
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
                        <td>1045044340</td>
                        <td>1/3/96</td>
                        <td>2/4/97</td>
                       
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
                        <td>1045044340</td>
                        <td>1/3/96</td>
                        <td>2/4/97</td>
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
                        <td>1045044340</td>
                        <td>1/3/96</td>
                        <td>2/4/97</td>
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
                        <td>1045044340</td>
                        <td>1/3/96</td>
                        <td>2/4/97</td>
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
                        <td>1045044340</td>
                        <td>1/3/96</td>
                        <td>2/4/97</td>
                    </tr>
                   
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
        
        $('.btn--filter').click(function(){
          $('.filtering').toggle(200)
        })

       
           $('input[type="checkbox"]').change(function(){
           if( $(this).is(':checked')){
            $(this).parents('tr').css('background-color','#41f5e07d');
            }else{
                $(this).parents('tr').css('background-color','');

            }

            var array=[]
            $('input[type="checkbox"]').each(function(){
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

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



<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">ثبت دسته بندی خدمات</h5>
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
                        <option value="خدمات شرکتی">خدمات شرکتی</option>
                        <option value="فروشگاه">فروشگاه</option>
                        <option value="خدمات پس از فروش">خدمات پس از فروش</option>
                        <option value="خدمات اصلی">خدمات اصلی</option>
                        <option value="پیشنهاد ویژه">پیشنهاد ویژه</option>
                        <option value="خدمات فرعی">خدمات فرعی</option>
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
            {{-- <a href="#" title="حذف " class="sweet-multiple mx-2">
            <span class="__icon bg-danger">
                <i class="fa fa-trash"></i>
            </span>
           </a>

           <a href="#" title="تازه سازی" data-toggle="modal" data-target=".bd-example-modal-lg-edit" class="mx-2" >
            <span class="__icon bg-info">
                <i class="fa fa-edit"></i>
            </span>
           </a> --}}
        </div>
        <div>
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
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h5 class="text-center">مدیریت دسته بندی خدمات</h5>
                <hr>
            </div>
                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>ردیف</th>
                        <th>عنوان</th>
                        <th> دسته بالا دستی</th>
                        <th> نوع</th>
                        <th>توضیحات تکمیلی</th>
                        <th> توضیحات عمومی</th>
                        <th>قیمت پیشنهادی</th>
                        <th>نمایش در صفحه اصلی</th>
                        <th>عکس</th>
                        
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
                        <td> پیک</td>
                        <td></td>
                        <td>شرکتی</td>
                        <td></td>
                        <td></td>
                        <td>2000</td>
                        <td class="text-success">
                            <i class="fa fa-check"></i>
                        </td>
                        <td>

                        </td>
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
                        <td> پیک</td>
                        <td></td>
                        <td>شرکتی</td>
                        <td></td>
                        <td></td>
                        <td>2000</td>
                        <td class="text-success">
                            <i class="fa fa-check"></i>
                        </td>
                        <td>
                            
                        </td>
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
                        <td> پیک</td>
                        <td></td>
                        <td>شرکتی</td>
                        <td></td>
                        <td></td>
                        <td>2000</td>
                        <td class="text-success">
                            <i class="fa fa-check"></i>
                        </td>
                        <td>
                            
                        </td>
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
                        <td> پیک</td>
                        <td></td>
                        <td>شرکتی</td>
                        <td></td>
                        <td></td>
                        <td>2000</td>
                        <td class="text-success">
                            <i class="fa fa-check"></i>
                        </td>
                        <td>
                            
                        </td>
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
                        <td> پیک</td>
                        <td></td>
                        <td>شرکتی</td>
                        <td></td>
                        <td></td>
                        <td>2000</td>
                        <td class="text-danger">
                            <i class="fa fa-close"></i>
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                   
                    </tbody>
                   
                </table>
            
        </div>
    </div>
</div>
@endsection

@section('css')

    <!-- begin::treeview -->
    <link rel="stylesheet" href="{{route('BaseUrl')}}/Pannel/assets/vendors/treeview/themes/default/style.min.css" type="text/css">
    <!-- end::treeview -->

    <style></style>
@endsection

@section('js')

<!-- begin::tree view -->
<script src="{{route('BaseUrl')}}/Pannel/assets/vendors/treeview/jstree.min.js"></script>
<script src="{{route('BaseUrl')}}/Pannel/assets/js/examples/treeview.js"></script>
<!-- end::tree view -->

    <script>
    $(document).ready(function(){
        
            $(document).on('change','input[type="checkbox"]',function(){
          
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

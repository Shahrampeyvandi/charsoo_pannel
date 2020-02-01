@extends('Layouts.Pannel.Template')

@section('content')


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">ثبت کاربر</h5>
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
</div>



<div class="container-fluid">
    <div class="card">
        <div class="container_icon card-body d-flex justify-content-end">
           
          

          <div class="delete-edit" style="display: none"> 
            <a href="#" title="تازه سازی" class="mx-2">
            <span class="__icon bg-danger">
                <i class="fa fa-trash"></i>
            </span>
           </a>

           <a href="#" title="تازه سازی" class="mx-2" >
            <span class="__icon bg-info">
                <i class="fa fa-edit"></i>
            </span>
           </a>
        </div>
        <div>
            <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg" title="افزودن کاربر">
                <span class="__icon bg-success">
                    <i class="fa fa-plus"></i>
                </span>
            </a>
            <a href="#" title="تازه سازی" class="mx-2">
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
                <h5 class="text-center">مدیریت کاربران</h5>
                <hr>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th></th>
                        <th>ردیف</th>
                        <th>نام</th>
                        <th>نام خانوادگی</th>
                        <th>نام کاربری</th>
                        <th>نقش</th>
                        <th>کد ملی</th>
                        <th>شماره موبایل</th>
                        <th>پروفایل عکس</th>
                        
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
                        <td>دستیار فروش</td>
                        <td>تبریز</td>
                        <td>46</td>
                        <td>2011/12/06</td>
                        <td>145,600 تومان</td>
                        <td>2011/12/06</td>
                        <td>145,600 تومان</td>
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
                        <td>دستیار فروش</td>
                        <td>تبریز</td>
                        <td>46</td>
                        <td>2011/12/06</td>
                        <td>145,600 تومان</td>
                        <td>2011/12/06</td>
                        <td>145,600 تومان</td>
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
                        <td>دستیار فروش</td>
                        <td>تبریز</td>
                        <td>46</td>
                        <td>2011/12/06</td>
                        <td>145,600 تومان</td>
                        <td>2011/12/06</td>
                        <td>145,600 تومان</td>
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
                        <td>دستیار فروش</td>
                        <td>تبریز</td>
                        <td>46</td>
                        <td>2011/12/06</td>
                        <td>145,600 تومان</td>
                        <td>2011/12/06</td>
                        <td>145,600 تومان</td>
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
                        <td>دستیار فروش</td>
                        <td>تبریز</td>
                        <td>46</td>
                        <td>2011/12/06</td>
                        <td>145,600 تومان</td>
                        <td>2011/12/06</td>
                        <td>145,600 تومان</td>
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
        

           $('input[type="checkbox"]').change(function(){
            var array=[]
            $('input[type="checkbox"]').each(function(){
                if($(this).is(':checked')){
                array.push($(this).val())

               }
            if(array.length !== 0){
                $('.container_icon').removeClass('justify-content-end')
                $('.container_icon').addClass('justify-content-between')
                $('.delete-edit').show()
            }else{
                $('.container_icon').removeClass('justify-content-between')
                $('.container_icon').addClass('justify-content-end')
                $('.delete-edit').hide()
            }
        })
            
    })

})
</script>
@endsection

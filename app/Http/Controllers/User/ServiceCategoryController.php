<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Models\Services\ServiceCategory;

class ServiceCategoryController extends Controller
{
    public function CategoryList()
    {
       $category_parent_list = ServiceCategory::where('category_parent',0)->get();
       $count = ServiceCategory::where('category_parent',0)->count();
        $list ='<option data-parent="0" value="0" class="level-1">بدون دسته بندی</option>';
       foreach ($category_parent_list as $key => $item) {
           
           $list .= '<option data-id="'.$item->id.'" value="'.$item->id.'" class="level-1">'.$item->category_title.' 
            '.(count(ServiceCategory::where('category_parent',$item->id)->get()) ? '&#xf104;  ' : '' ).'
           </option>';
          
           foreach (ServiceCategory::where('category_parent',$item->id)->get() as $key => $subitem) {
               $list .= '<option data-parent="'.$item->id.'" value="'.$subitem->id.'" class="level-2">'.$subitem->category_title.'</option>';
           }
       }

      $all_categories = ServiceCategory::latest()->get();



        return view('User.ServiceCategoryList',compact(['list','count','all_categories']));
    }


    public function getData(Request $request)
    {
        
        $category = ServiceCategory::where('id',$request->category_id)->first();
        $csrf = csrf_token();
        $category_parent_list = ServiceCategory::where('category_parent',0)->get();
        $count = ServiceCategory::where('category_parent',0)->count();


        $option ='';
        foreach ($category_parent_list as $key => $item) {
            $option .= '<option data-id="'.$item->id.'"
            '.($category->category_parent == $item->id ? 'selected=""' : '' ).'
            value="'.$item->id.'" class="level-1">'.$item->category_title.' 
             '.(count(ServiceCategory::where('category_parent',$item->id)->get()) ? '&#xf104;  ' : '' ).'
            </option>';
            foreach (ServiceCategory::where('category_parent',$item->id)->get() as $key => $subitem) {
                $option .= '<option data-parent="'.$item->id.'"
                '.($category->category_parent == $subitem->id ? 'selected=""' : '' ).'
                value="'.$subitem->id.'" class="level-2">'.$subitem->category_title.'</option>';
            }
        }


      $list =' <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">ویرایش دسته بندی خدمات</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <form id="edit--form" method="post" action="'.route('Category.Edit.Submit').'" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="'.$csrf.'">
    <input type="hidden" name="category_id" value="'.$category->id.'">
    <div class="modal-body">
       <div class="row">
       <div class="form-group col-md-12">
       <label for="category_title" class="col-form-label"><span class="text-danger">*</span> عنوان: </label>
       <input type="text" class="form-control" name="category_title"
       value="'.$category->category_title.'"
       id="category_title">
     </div>
          
       </div>
       <div class="row">
       <div class="form-group col-md-12">
       <label for="recipient-name" class="col-form-label">دسته:</label>
     <select '.( $count > 1 ?
         'size="'.$count.'"' :  'size="2"'
      ). ' class="form-control" name="category_level" id="category_level">
          '.$option.'
       </select>                      
        <div class="valid-feedback">
            صحیح است!
        </div>
         </div><!-- form-group -->
       </div>
       <div class="row">
        <div class="form-group col-md-6">
            <label for="recipient-name" class="col-form-label">نوع:</label>
            <select name="category_type" id="category_type"  class="js-example-basic-single" dir="rtl">
            <option></option>
                <option '.($category->category_type == 'خدمات شرکتی' ? 'selected=""' : '').' value="France">خدمات شرکتی</option>
                <option '.($category->category_type == 'فروشگاه' ? 'selected=""' : '').' value="Brazil">فروشگاه</option>
                <option '.($category->category_type == 'خدمات پس از فروش' ? 'selected=""' : '').'  value="Yemen">خدمات پس از فروش</option>
                <option '.($category->category_type == 'خدمات اصلی' ? 'selected=""' : '').'  value="United States">خدمات اصلی</option>
                <option '.($category->category_type == 'پیشنهاد ویژه' ? 'selected=""' : '').'  value="China">پیشنهاد ویژه</option>
                <option '.($category->category_type == 'خدمات فرعی' ? 'selected=""' : '').'  value="Argentina">خدمات فرعی</option>
            </select>  
        </div>
        <div class="form-group col-md-6">
        <label for="category_icon" class="col-form-label"> تغییر ایکون:</label>
        <input type="file" class="form-control" name="category_icon" id="category_icon">
      </div>
       </div>
       <div class="row">
       <div class="form-group col-md-12">
       <label for="recipient-name" class="col-form-label">توضیحات عمومی:</label>
       <textarea type="text" class="form-control" name="category_description" id="category_description">
       </textarea>
     </div>
         
       </div>
      
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
      <button type="submit" class="btn btn-primary">ارسال</button>
    </div>
    </form>';

       
 
         return $list;
    }

    public function SubmitCategoryEdit(Request $request)
    {
       
        
        if ($request->has('category_icon')) {
            
            File::deleteDirectory(public_path('uploads/category_icons/'.$request->category_title));

            $fileName = $request->category_title . '.' . $request->category_icon->getClientOriginalExtension();
            $fileNameWithoutEx = pathinfo($fileName, PATHINFO_FILENAME);
            $request->category_icon->move(public_path('uploads/category_icons/'.$request->category_title), $fileName);
                $array =[
                    'category_title' => $request->category_title,
                    'category_parent' => $request->category_level !== null ? $request->category_level : 0,
                    'category_type' => $request->category_type,
                    'category_icon' => $fileName,
                    'category_desc' => $request->category_description
                    ];
        }else{
            $array =[
                'category_title' => $request->category_title,
                'category_parent' => $request->category_level !== null ? $request->category_level : 0,
                'category_type' => $request->category_type,
                'category_desc' => $request->category_description
                ];
        }

        ServiceCategory::where('id',$request->category_id)->update($array);
        alert()->success('دسته بندی با موفقیت ویرایش شد', 'عملیات موفق')->autoclose(2000);
        return back();
    }

    public function SubmitServiceCategory(Request $request)
    {
        if ($request->has('category_icon')) {
            

            $fileName = $request->category_title . '.' . $request->category_icon->getClientOriginalExtension();
            $fileNameWithoutEx = pathinfo($fileName, PATHINFO_FILENAME);
            $request->category_icon->move(public_path('uploads/category_icons/'.$request->category_title), $fileName);
           
        }else{
            $fileName = '';
        }
        ServiceCategory::create([
            'category_title' => $request->category_title,
            'category_parent' => $request->category_level !== null ? $request->category_level : 0,
            'category_type' => $request->category_type,
            'category_icon' => $fileName,
            'category_desc' => $request->category_description
        ]);

        alert()->success('دسته بندی با موفقیت ثبت شد', 'عملیات موفق')->autoclose(2000);
            return back();
       


    }

    public function DeleteCategory(Request $request)
    {
        
        foreach ($request->array as $user_id) {
            ServiceCategory::where('id',$user_id)->delete();
        }
        return 'success';
    }

   

    

   
    

    public function OnlinePersonals()
    {
        return view('User.OnlinePersonals');
    }

    
}

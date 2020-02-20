<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City\City;

class CityController extends Controller
{
    public function CityList()
    {
        $cities = City::latest()->get();
        return view('User.Cities.CityList', compact('cities'));
    }

    public function SubmitCity(Request $request)
    {

        City::create([
            'city_name' => $request->city_name
        ]);

        alert()->success('شهر با موفقیت ثبت شد', 'عملیات موفق')->autoclose(2000);
        return back();
    }

    public function DeleteCity(Request $request)
    {
        foreach ($request->array as $city_id) {

            City::where('id', $city_id)->delete();
        }
        return 'success';
    }

    public function EditCity(Request $request)
    {
        City::where('id',$request->id)->update([
            'city_name' => $request->city_name,
        ]);

        alert()->success('شهر با موفقیت ویرایش شد ', 'عملیات موفق')->autoclose(2000);
        return back();
    }

    public function getData(Request $request)
    {
        $city = City::where('id', $request->id)->first();
        $csrf = csrf_token();
        $list = '<form id="edit--city" action="' . route('City.Edit.Insert') . '" method="post">
        <input type="hidden" name="_token" value="' . $csrf . '">
        <input type="hidden" name="id" value="' . $city->id . '">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ویرایش شهر</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    
      <div class="modal-body">
          <div class="form-group col-md-12">
              <label for="city_name" class="col-form-label">شهر:  </label>
              <input type="text" class="form-control"
              value="'.$city->city_name.'"
              name="city_name" id="city_name">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
          <button type="submit" class="btn btn-primary">ویرایش </button>
        </div>
    </form>';

    return $list;
    }
}

<?php

use Illuminate\Support\Facades\Auth;

Route::get('/', 'Auth\LoginController@index')->name('BaseUrl');
Route::post('/Dashboard', 'Auth\LoginController@Login')->name('Pannel.Login');
Route::get('/Logout', function () {
    Auth::logout();
    return redirect()->route('BaseUrl');
})->name('User.Logout');


Route::group(['middleware' => ['checkAuth']], function () {

    Route::get('/Dashboard', 'User\MainController@index')->name('Dashboard');

    Route::get('/UserList', 'User\MainController@UserList')->name('Pannel.User.List');

    Route::post('UserInsert', 'User\MainController@SubmitUser')->name('User.Submit');

    Route::post('UserEdit', 'User\MainController@SubmitUserEdit')->name('User.Edit.Submit');
   
    Route::post('UserOrderBy', 'User\MainController@UserOrderBy')->name('User.OrderBy.Table');

    Route::post('Users/FilterData', 'User\MainController@FilterUsers')->name('Users.FilterData');
    
    Route::post('UserDelete', 'User\MainController@DeleteUser')->name('Users.Delete');

    Route::post('getUserData', 'User\MainController@getUserData')->name('User.Edit.getData');

    Route::get('/Services/Categories', 'User\ServiceCategoryController@CategoryList')->name('Pannel.Services.Category');

    Route::post('Services/Categories', 'User\ServiceCategoryController@SubmitServiceCategory')->name('Service.Category.Submit');

    Route::post('Services/Categories/Delete', 'User\ServiceCategoryController@DeleteCategory')->name('Category.Delete');
    
    Route::post('Services/Categories/getData', 'User\ServiceCategoryController@getData')->name('Category.Edit.getData');
    
    Route::post('Services/EditCategory/Submit', 'User\ServiceCategoryController@SubmitCategoryEdit')->name('Category.Edit.Submit');

    Route::get('/Services', 'User\ServiceController@ServiceList')->name('Pannel.Services.Questions');
   
    Route::post('Services/Edit/getData', 'User\ServiceController@getData')->name('Service.Edit.getData');
    
    Route::post('Services/Edit/Submit', 'User\ServiceController@SubmitServiceEdit')->name('Service.Edit.Submit');

    Route::post('ServiceDelete', 'User\ServiceController@DeleteService')->name('Service.Delete');
    
    Route::post('Service/OrderBy', 'User\ServiceController@ServiceOrderBy')->name('Service.OrderBy.Table');

    Route::post('/SubmitService', 'User\ServiceController@SubmitService')->name('Service.Submit');

    Route::get('/Services/Personals', 'User\ServiceCategoryController@PersonalsList')->name('Pannel.Services.Personels');

    Route::post('Services/technician', 'User\ServiceCategoryController@technicianSubmit')->name('Service.technician.Submit');

    Route::get('/Cunsomers/List', 'User\CunsomerController@CunsomerList')->name('Pannel.Cunsomers.List');

    Route::get('/Cities/List', 'User\CityController@CityList')->name('Pannel.City.List');

    Route::post('Cities/List', 'User\CityController@SubmitCity')->name('Pannel.City.Insert');

    Route::get('/Services/OnlinePersonals', 'User\ServiceCategoryController@OnlinePersonals')->name('Pannel.Services.OnlinePersonals');

});  /*    E N D - R O U T E - G R O U P    */

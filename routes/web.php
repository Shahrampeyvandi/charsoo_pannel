<?php

use Illuminate\Support\Facades\Auth;

Route::get('/', 'Auth\LoginController@index')->name('BaseUrl');
Route::post('/Dashboard', 'Auth\LoginController@Login')->name('Pannel.Login');
Route::get('/Logout', function () {
    Auth::logout();
    return redirect()->route('BaseUrl');
})->name('User.Logout');

//Route::group(['middleware' => ['checkAuth']], function () {

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

Route::post('Service/FilterData', 'User\ServiceController@FilterServices')->name('Service.FilterData');

Route::post('/SubmitService', 'User\ServiceController@SubmitService')->name('Service.Submit');

Route::get('/Services/Personals', 'User\PersonalController@PersonalsList')->name('Pannel.Services.Personels');

Route::post('Services/technician', 'User\PersonalController@technicianSubmit')->name('Service.technician.Submit');

Route::post('getPersonalData', 'User\PersonalController@getPersonalData')->name('Personal.Edit.getData');

Route::post('Personal/Edit/Submit', 'User\PersonalController@SubmitPersonalEdit')->name('Personal.Edit.Submit');

Route::post('Services/Personals/N', 'User\PersonalController@CheckNationalNum')->name('Personal.CheckNationalNum');

Route::post('Services/Personals/OrderBy', 'User\PersonalController@PersonalOrderBy')->name('Personal.OrderBy.Table');

Route::post('Services/Personals/Delete', 'User\PersonalController@DeletePersonal')->name('Personal.Delete');

Route::get('/Cunsomers/List', 'User\CunsomerController@CunsomerList')->name('Pannel.Cunsomers.List');

Route::post('/Cunsomers/Delete', 'User\CunsomerController@DeleteCustomers')->name('Customers.Delete');

Route::post('/Cunsomers/getData', 'User\CunsomerController@getData')->name('Customer.Edit.getData');

Route::post('/Cunsomer/Edit', 'User\CunsomerController@EditCustomer')->name('Customer.Edit.Submit');

Route::post('Customers/OrderBy', 'User\CunsomerController@OrderBy')->name('Customers.OrderBy.Table');

Route::post('Customers/Filter', 'User\CunsomerController@FilterCustomer')->name('Customers.Filter');

Route::get('/Cities/List', 'User\CityController@CityList')->name('Pannel.City.List');

Route::post('Cities/List', 'User\CityController@SubmitCity')->name('Pannel.City.Insert');

Route::post('Cities/Delete', 'User\CityController@DeleteCity')->name('City.Delete');

Route::post('/Cities/getData', 'User\CityController@getData')->name('City.Edit.getData');

Route::post('Cities/Edit', 'User\CityController@EditCity')->name('City.Edit.Insert');

Route::get('/Services/OnlinePersonals', 'User\PersonalController@OnlinePersonals')->name('Pannel.Services.OnlinePersonals');

Route::get('/Services/TrackPersonals', 'User\PersonalController@TrackPersonals')->name('Pannel.Services.TrackPersonals');

 Route::get('/Acounting/PersonalAcounts', 'Acounting\PersonalAcountsController@index')->name('Pannel.Acounting.PersonalAcounts');
 Route::get('/Acounting/Transactions', 'Acounting\TransactionsController@index')->name('Pannel.Acounting.Transactions');
 Route::get('/Acounting/CheckoutPersonals', 'Acounting\CheckoutPersonalsController@index')->name('Pannel.Acounting.CheckoutPersonals');

Route::get('Setting', 'User\SettingController@Setting')->name('Pannel.Setting');

Route::post('Setting', 'User\SettingController@SettingChange')->name('Pannel.Setting');

Route::get('/RolesList', 'User\RoleController@RolesList')->name('Pannel.Roles');

Route::post('/InsertRole', 'User\RoleController@InsertRole')->name('Role.Submit');

Route::post('/DeleteRole', 'User\RoleController@DeleteRole')->name('Role.Delete');

Route::post('/Roles/getData', 'User\RoleController@getData')->name('Roles.Edit.getData');

Route::post('/Roles/Edit/Submit', 'User\RoleController@SubmitEditRole')->name('Roles.Edit.Submit');

Route::get('/OrderList', 'User\OrderController@OrderList')->name('Pannel.Customers.Orders');

//});  /*    E N D - R O U T E - G R O U P    */

<?php


Route::get('/', 'Auth\LoginController@index')->name('BaseUrl');
Route::get('/Dashboard', 'User\MainController@index')->name('Dashboard');

Route::post('/Dashboard', 'Auth\LoginController@Login')->name('Pannel.Login');

Route::get('/UserList', 'User\MainController@UserList')->name('Pannel.User.List');

Route::post('UserInsert', 'User\MainController@SubmitUser')->name('User.Submit');

Route::post('UserEdit', 'User\MainController@SubmitUserEdit')->name('User.Edit.Submit');

Route::post('UserDelete', 'User\MainController@DeleteUser')->name('Users.Delete');


Route::post('getUserData', 'User\MainController@getUserData')->name('User.Edit.getData');

Route::get('/Services/Categories', 'User\ServiceController@CategoryList')->name('Pannel.Services.Category');

Route::post('Services/Categories', 'User\ServiceController@SubmitServiceCategory')->name('Service.Category.Submit');



Route::get('/Services', 'User\ServiceController@ServiceList')->name('Pannel.Services.Questions');

Route::get('/SubmitService', 'User\ServiceController@SubmitService')->name('Service.Submit');

Route::get('/Services/Personals', 'User\ServiceController@PersonalsList')->name('Pannel.Services.Personels');



Route::post('Services/technician', 'User\ServiceController@technicianSubmit')->name('Service.technician.Submit');


Route::get('/Cunsomers/List', 'User\CunsomerController@CunsomerList')->name('Pannel.Cunsomers.List');

Route::get('/Cities/List', 'User\CityController@CityList')->name('Pannel.City.List');




Route::post('Cities/List', 'User\CityController@SubmitCity')->name('Pannel.City.Insert');

Route::get('/Services/OnlinePersonals', 'User\ServiceController@OnlinePersonals')->name('Pannel.Services.OnlinePersonals');





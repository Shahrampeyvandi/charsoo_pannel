<?php


Route::get('/', 'Auth\LoginController@index')->name('BaseUrl');
Route::get('/Dashboard', 'User\MainController@index')->name('Dashboard');

Route::get('/UserList', 'User\MainController@UserList')->name('Pannel.User.List');

Route::get('/Services/Categories', 'User\ServiceController@CategoryList')->name('Pannel.Services.Category');



Route::get('/Services', 'User\ServiceController@ServiceList')->name('Pannel.Services.Questions');

Route::get('/SubmitService', 'User\ServiceController@SubmitService')->name('Service.Submit');

<?php


Route::get('/', 'Auth\LoginController@index')->name('BaseUrl');
Route::get('/Dashboard', 'User\MainController@index')->name('Dashboard');

Route::get('/UserList', 'User\MainController@UserList')->name('Pannel.User.List');


<?php

// Route::post('register', 'Api\AuthController@register');
// Route::post('login', 'Api\AuthController@login');
// Route::get('logout', 'Api\AuthController@logout');
// Route::get('user', 'Api\AuthController@getAuthUser');
Route::post('personal/verify','Api\PersonalController@verify');
Route::post('personal/register','Api\PersonalController@register');
Route::get('getCities','Api\PersonalController@getCities');

Route::post('personal/referredOrders','Api\OrdersController@referredOrders');
Route::post('personal/offeringOrders','Api\OrdersController@offeringOrders');
Route::post('personal/allRelatedOrders','Api\OrdersController@allRelatedOrders');
Route::get('personal/getData','Api\PersonalController@getPersonal');
Route::put('personal/updateData','Api\PersonalController@updatePersonalData');
Route::get('sendcode','Api\SMSCodeController@sendcode');
Route::get('personal/dashboarddetail','Api\PersonalController@getPersonalDashboardDetail');
Route::POST('personal/position','Api\TrackPersonalController@sendpositions');


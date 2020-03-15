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
Route::post('personal/updatedata','Api\PersonalController@updatePersonalData');
Route::post('personal/updateprofile','Api\PersonalController@updateProfile');
Route::get('sendcode','Api\SMSCodeController@sendcode');
Route::get('personal/getorder','Api\OrdersController@getOrder');


// 15.12.1398
Route::post('personal/refferOrder','Api\OrdersController@refferOrderToPersonal');
Route::post('personal/startOrder','Api\OrdersController@startOrder');
Route::post('personal/endOrder','Api\OrdersController@endOrder');
Route::post('personal/reckoningorder','Api\OrdersController@reckoningorder'); //tasvie hesab

Route::post('personal/uploadImages','Api\OrdersController@uploadImages'); //tasvie hesab




Route::get('personal/dashboarddetail','Api\PersonalController@getPersonalDashboardDetail');
Route::POST('personal/position','Api\TrackPersonalController@sendpositions');




// اطلاعات مربوط به مشتری
Route::post('customer/verify','Api\CustomerController@verify');
Route::post('customer/register','Api\CustomerController@register');

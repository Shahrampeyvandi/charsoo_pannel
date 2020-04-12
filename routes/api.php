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
Route::post('personal/finishedOrders','Api\OrdersController@finishedOrders');
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
Route::post('personal/uploadImages','Api\OrdersController@uploadImages'); 
Route::get('personal/dashboarddetail','Api\PersonalController@getPersonalDashboardDetail');
Route::POST('personal/position','Api\TrackPersonalController@sendpositions');

// اطلاعات مربوط به مشتری
Route::post('customer/verify','Api\CustomerController@verify');
Route::post('customer/register','Api\CustomerController@register');
Route::get('customer/getData','Api\CustomerController@getCustomer');
Route::post('customer/updatedata','Api\CustomerController@updateCustomerData');
Route::post('customer/updateprofile','Api\CustomerController@updateProfile');
Route::get('customer/homedetail','Api\CustomerController@getHomePageDetail');

Route::get('customer/orders','Api\CustomerController@getAllOrders');
Route::get('customer/order','Api\CustomerController@getOrder');
Route::get('customer/addresses','Api\CustomerController@getCustomerAddresses');
Route::get('customer/categories','Api\CustomerController@getCategories');
Route::post('customer/saveaddress','Api\CustomerController@submitAddress');
Route::get('customer/services','Api\CustomerController@getServices');
Route::get('customer/categoryarrange','Api\CustomerController@getCategoryArrange');
Route::get('customer/transactions','Api\CustomerController@getTransactions');

Route::get('customer/getService','Api\ServiceController@getService');

Route::get('customer/gethomep','Api\AppCustomerController@index');

Route::get('customer/getstore','Api\StoreController@getStore');
Route::get('personal/getpersonalstore','Api\PersonalController@getPersonalStore');
Route::post('getstore','Api\StoreController@getStore');
Route::post('getpersonalstore','Api\StoreController@getPersonalStore');
Route::post('getproduct','Api\StoreController@getProduct');



<?php

namespace App\Http\Controllers\Api;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Personals\Personal;
use App\Models\Services\Service;

class OrdersController extends Controller
{
  public function referredOrders(Request $request)
  {

    $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
    $mobile = $payload->get('mobile');
    $personal = Personal::where('personal_mobile', $mobile)->first();
    //$orders = $personal->order->where('order_type','ارجاع داده شده');
    $orders = $personal->order->where('order_type', 'ارجاع داده شده');

    foreach ($orders as $key => $order) {
      $service = Service::where('id', $order->service_id)->first()->service_title;
      $order['service_name'] = $service;
    }

    $ords = [];
    foreach ($orders as $key => $or) {
      $ords[] = $or;
    }
    return response()->json([
      'data' => $ords,
    ], 200);
  }


  public function offeringOrders(Request $request)
  {
    $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
    $mobile = $payload->get('mobile');
    $personal = Personal::where('personal_mobile', $mobile)->first();
    $orders = $personal->order->where('order_type', 'پیشنهاد داده شده');
    foreach ($orders as $key => $order) {
      $service = Service::where('id', $order->service_id)->first()->service_title;
      $order['service_name'] = $service;
    }
    return response()->json([
      'data' => $orders,
    ], 200);
  }

  public function allRelatedOrders(Request $request)
  {

    $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
    $mobile = $payload->get('mobile');
    $personal = Personal::where('personal_mobile', $mobile)->first();
    $orders = $personal->order()->where('order_type', 'معلق')
      ->orWhere('order_type', 'در حال انجام')
      ->orWhere('order_type', 'انجام شده')
      ->orWhere('order_type', 'تسویه شده')->get();
    foreach ($orders as $key => $order) {
      $service = Service::where('id', $order->service_id)->first()->service_title;
      $order['service_name'] = $service;
    }
    return response()->json([
      'data' => $orders,
    ], 200);
  }

  public function getOrder(Request $request)
  {
    $Code = $request->order_code;
   $order = Order::where('order_unique_code',$Code)->first();
   if ($order !== null) {

      $service = Service::where('id', $order->service_id)->first()->service_title;
      $order['service_name'] = $service;
    
    return response()->json(
     $order
    , 200);
   }
   else{
    return response()->json([
      'data' =>'سفارشی با این کد درج نشده است',
    ], 404);
   }

  }
}

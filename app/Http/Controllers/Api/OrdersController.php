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
       $personal = Personal::where('personal_mobile',$mobile)->first();
       //$orders = $personal->order->where('order_type','ارجاع داده شده');
       $orders = $personal->order->where('order_type','ارجاع داده شده');

       foreach ($orders as $key => $order) {
        $service = Service::where('id',$order->service_id)->first()->service_title;
        $order['service_name'] = $service;
       }
       
       $ords=[];
       foreach($orders as $key=>$or){
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
    $personal = Personal::where('personal_mobile',$mobile)->first();
    $orders = $personal->order->where('order_type','پیشنهاد داده شده');
   
    foreach ($orders as $key => $order) {
     $service = Service::where('id',$order->service_id)->first()->service_title;
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
    $personal = Personal::where('personal_mobile',$mobile)->first();
    $orders = $personal->order()->where('order_type','قطعی')
    ->orWhere('order_type','شروع به کار')
    ->orWhere('order_type','اعلام هزینه')
    ->orWhere('order_type','دریافت هزینه')
    ->orWhere('order_type','اتمام کار')->get();
    foreach ($orders as $key => $order) {
     $service = Service::where('id',$order->service_id)->first()->service_title;
     $order['service_name'] = $service;
    }
    return response()->json([
     'data' => $orders,
   ], 200);
   }

}

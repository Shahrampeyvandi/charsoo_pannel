<?php

namespace App\Http\Controllers\Api;

use App\Models\Orders\Order;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Personals\Personal;
use App\Models\Services\Service;
use Carbon\Carbon;

class OrdersController extends Controller
{
  // public function referredOrders(Request $request)
  // {

  //   $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
  //   $mobile = $payload->get('mobile');
  //   $personal = Personal::where('personal_mobile', $mobile)->first();
  //   //$orders = $personal->order->where('order_type','ارجاع داده شده');
  //   $orders = $personal->order->where('order_type', 'ارجاع داده شده');

  //   foreach ($orders as $key => $order) {
  //     $service = Service::where('id', $order->service_id)->first()->service_title;
  //     $order['service_name'] = $service;
  //   }

  //   $ords = [];
  //   foreach ($orders as $key => $or) {
  //     $ords[] = $or;
  //   }
  //   return response()->json([
  //     'data' => $ords,
  //   ], 200);
  // }


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
    $orders = $personal->order()->where('order_type', 'شروع نشده')
      ->orWhere('order_type', 'در حال انجام')
      ->orWhere('order_type', 'انجام شده')->get();
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

  public function refferOrderToPersonal(Request $request)
  {
    $Code = $request->order_code;
    $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
    $mobile = $payload->get('mobile');
    $personal = Personal::where('personal_mobile', $mobile)->first();
    $orderdata = Order::where('order_unique_code', $Code)->first();
    $check_order_personal = $orderdata->personals->where('id', $personal->id);
    if (count($check_order_personal)) {
      return response()->json([
        'data' => '',
        'error' => 'سفارش به خدمت رسان ارجاع شده است',
      ], 404);
    }
    $order = Order::where('order_unique_code', $Code)->update([
      'order_type' => 'شروع نشده'
    ]);

    $personal->order()->attach($orderdata->id);
   
    return response()->json([
      'data' => $orderdata->fresh(),
    ], 200);
  }

  public function startOrder(Request $request)
  {
    $Code = $request->order_code;
    $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
    $mobile = $payload->get('mobile');
    $personal = Personal::where('personal_mobile', $mobile)->first();
    $orderdata = Order::where('order_unique_code', $Code)->first();
    if (Order::where('order_unique_code', $Code)
      ->where('order_type', 'در حال انجام')
      ->whereHas('personals', function ($q) use ($personal) {
        $q->where('id', $personal->id);
      })
      ->count()
    ) {
      return response()->json([
        'data' => '',
        'error' => 'درخواست شروع به کار توسط شما ثبت شده است',
      ], 404);
    }
    $order = Order::where('order_unique_code', $Code)->update([
      'order_type' => 'در حال انجام'
    ]);
    $orderdata->orderDetail()->create([
      'order_start_time' => Carbon::now(),
      'order_start_description' => $request->description,
      'order_start_time_positions' => $request->positions
    ]);

    if ($request->has('images')) {
      // save start images of personal
      foreach ($request->images as $key => $image) {
        $file = 'photo-' . ($key + 1) . '.' . $request->personal_profile->getClientOriginalExtension();
        $request->personal_profile->move(public_path('uploads/orders/' . $orderdata->id), $file);
        $personal_profile = $orderdata->id . '/' . $file;

        $orderdata->orderImages()->create([
          'image_type' => 'personal_images',
          'image_url' => $personal_profile

        ]);
      }
    }

    return response()->json([
      'data' => $orderdata->fresh(),
    ], 200);
  }


  // payane kar
  public function endOrder(Request $request)
  {
    $Code = $request->order_code;
    $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
    $mobile = $payload->get('mobile');
    $personal = Personal::where('personal_mobile', $mobile)->first();
    $orderdata = Order::where('order_unique_code', $Code)->first();
    if (Order::where('order_unique_code', $Code)
      ->where('order_type', 'انجام شده')
      ->whereHas('personals', function ($q) use ($personal) {
        $q->where('id', $personal->id);
      })
      ->count()
    ) {
      return response()->json([
        'data' => '',
        'error' => 'درخواست پایان کار توسط شما ثبت شده است',
      ], 404);
    }

    $order = Order::where('order_unique_code', $Code)->update([
      'order_type' => 'انجام شده'
    ]);
    $orderdata->orderDetail()->update([
      'order_end_time' => Carbon::now(),
      'order_end_description' => $request->description,
      'order_end_time_positions' => $request->positions,
      'order_recived_price' => $request->order_cast,
      'order_pieces_cast' => $request->pieces_cast

    ]);

    if ($request->has('images')) {
      // save start images of personal
      foreach ($request->images as $key => $image) {
        $file = 'photo-' . ($key + 1) . '.' . $request->personal_profile->getClientOriginalExtension();
        $request->personal_profile->move(public_path('uploads/orders/endwork/' . $orderdata->id), $file);
        $personal_profile = $orderdata->id . '/' . $file;
        $orderdata->orderImages()->create([
          'image_type' => 'personal_images',
          'image_url' => $personal_profile

        ]);
      }
    }
    return response()->json([
      'data' => $orderdata->fresh(),
    ], 200);
  }



  // tasvie hesab
  public function reckoningorder(Request $request)
  {
    $Code = $request->order_code;
    $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
    $mobile = $payload->get('mobile');
    $personal = Personal::where('personal_mobile', $mobile)->first();
    $orderdata = Order::where('order_unique_code', $Code)->first();
    if (Order::where('order_unique_code', $Code)
      ->where('order_type', 'تسویه شده')
      ->whereHas('personals', function ($q) use ($personal) {
        $q->where('id', $personal->id);
      })
      ->count()
    ) {
      return response()->json([
        'data' => '',
        'error' => 'درخواست تسویه حساب توسط شما ثبت شده است',
      ], 404);
    }

    $order = Order::where('order_unique_code', $Code)->update([
      'order_type' => 'تسویه شده'
    ]);

    if ($request->has('images')) {
      // save start images of personal
      foreach ($request->images as $key => $image) {
        $file = 'photo-' . ($key + 1) . '.' . $request->personal_profile->getClientOriginalExtension();
        $request->personal_profile->move(public_path('uploads/orders/tasvie/' . $orderdata->id), $file);
        $personal_profile = $orderdata->id . '/' . $file;
        $orderdata->orderImages()->create([
          'image_type' => 'personal_images',
          'image_url' => $personal_profile

        ]);
      }
    }
    return response()->json([
      'data' => $orderdata->fresh(),
    ], 200);
  }
}

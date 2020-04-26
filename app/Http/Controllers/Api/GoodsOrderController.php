<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personals\Personal;
use App\Models\Store\Store;
use App\Models\Store\GoodsOrders;
use App\Models\Store\GoodsOrdersImages;
use App\Models\Store\GoodsOrdersStatuses;
use App\Models\Store\StoreWorkingHours;
use App\Models\Cunsomers\Cunsomer;
use App\Models\Store\Product;
use App\Models\Acounting\Transations;
use Carbon\Carbon;
use App\Models\Acounting\UserAcounts;
use App\App\Models\Customers\CustomerAddress;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoodsOrderController extends Controller
{
    public function workinghours(Request $request){

        $store=Store::find($request->id);

        $wrkhors=$store->workinghours;
        
        $wrkhors['saturday']=explode(',',$wrkhors['saturday']);
        $wrkhors['sunday']=explode(',',$wrkhors['sunday']);
        $wrkhors['monday']=explode(',',$wrkhors['monday']);
        $wrkhors['tuesday']=explode(',',$wrkhors['tuesday']);
        $wrkhors['wednesday']=explode(',',$wrkhors['wednesday']);
        $wrkhors['thursday']=explode(',',$wrkhors['thursday']);
        $wrkhors['friday']=explode(',',$wrkhors['friday']);


        return response()->json(
            $wrkhors
            ,200);
    }

    public function order(Request $request){

        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $customer = Cunsomer::where('customer_mobile', $mobile)->first();

       

        $store=Store::find($request->store_id);

        $order=new GoodsOrders;

        $order->store_id=$store->id;

        $order->personal_mobile	=Personal::find($store->owner_id)->personal_mobile;

        $order->cunsomers_id =$customer->id;

        $order->cunsomer_mobile=$customer->customer_mobile;
 

        $order->off_code=$request->offcode;

        $order->items=implode(',',$request->items);
        //$order->items=str_replace(['[',']'],'',$request->items);

        $order->counts=implode(',',$request->counts);
        //$order->counts=str_replace(['[',']'],'',$request->counts);

        $items=$request->items;
        $counts=$request->counts;

  

    $total=0;
    for($i=0;$i<count($items);$i++){

        $product=Product::find($items[$i]);

        $total+=$product->product_price*$counts[$i];

           
         
   

    }


    $order->totalamountitems=$total;
  
    
        $order->packingprice=$store->packing_price;
    
        $order->sendingprice=$store->sending_price;
    
        $address=CustomerAddress::find($request->address_id);

        $order->address=$address->address;
    
        $order->address_id=$address->id;

        $datenow=Carbon::today();

        if($request->deliverdate=='0'){



        }else if($request->deliverdate=='1'){

            $datenow=$datenow->addDays(1);

        }else if($request->deliverdate=='2'){

            $datenow=$datenow->addDays(2);


        }
    
        $order->deliverdate=$datenow;
    
        $order->delivertime=$request->delivertime;
    
        $order->description=$request->description;
    
        $order->delivercode=rand(10000,99999);


        $order->questions=implode(',',$request->questions);
    
        $order->answers	=implode(',',$request->answers);

 

      
       // return response()->json(['items'=>$items],200);


        $order->save();

       

        $date = Carbon::parse($order->deliverdate)->timestamp;
     $Code = $this->generateRandomString($order->cunsomer_mobile, $date, $order->id);
     
     $order->orderuniquecode=$Code;

     $order->update();

     $order->items=[];
     $order->counts=[];
     $order->questions=[];
     $order->answers=[];

        return response()->json(
            $order
            ,200);
    }

    public function uploadpic(Request $request){

        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');

        $personal = Personal::where('personal_mobile', $mobile)->first();
        $customer = Cunsomer::where('customer_mobile', $mobile)->first();

      
     

        if(is_null($personal) && is_null($customer)){

            return response()->json(
                ''
                ,403);
        }


        $order=GoodsOrders::where('orderuniquecode',$request->code)->first();

        
        $file = $request->type .'_' .time(). '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('/uploads/goodsorders/' . $order->id), $file);
        $image_url = 'goodsorders/'.$order->id . '/' . $file;
        
       

        $image=new GoodsOrdersImages;
        $image->goods_orders_id=$order->id;
        $image->type=$request->type;
        $image->link=$image_url;
        $image->save();


        return response()->json(
            'ok'
            ,200);
    }

    public function getgoodsordercustomer(Request $request){

        $order=GoodsOrders::where('orderuniquecode',$request->code)->first();



        return response()->json(
            $order
            ,200);
    }

    
    public function getgoodsorderpersonal(Request $request){

        $order=GoodsOrders::where('orderuniquecode',$request->code)->first();

        $order['delivercode']=00000;
        $order['images']=$order->images;


        return response()->json(
            $order
            ,200);
    }

    
    public function getallorderscustomer(Request $request){

        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $customer = Cunsomer::where('customer_mobile', $mobile)->first();

            $orders=GoodsOrders::where('cunsomers_id',$customer->id)->get();

        
        


        foreach($orders as $order){

            $order['images']=$order->images;
            $order['statuseses']=$order->statuses;


        }


        return response()->json([
            'data'=>$orders
        ],200);
    }

    public function getallorderspersonal(Request $request){

        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $personal = Personal::where('personal_mobile', $mobile)->first();

        $store=Store::where('owner_id',$personal->id)->first();

        $orders=GoodsOrders::where('store_id',$store->id)->get();



        foreach($orders as $order){

            //$order['images']=$order->images;
            //$order['statuseses']=$order->statuses;
            $order['delivercode']=00000;
            $order->items=[];
            $order->counts=[];
            $order->questions=[];
            $order->answers=[];

        }


        return response()->json([
            'data'=>$orders
        ],200);
    }

    public function acceptorder(Request $request){

        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $personal = Personal::where('personal_mobile', $mobile)->first();
        

        $goodsorder=GoodsOrders::where('orderuniquecode',$request->code)->first();
        $goodsorder->status='تایید فروشنده';

        $status=new GoodsOrdersStatuses;

        $status->goods_orders_id=$goodsorder->id;
        $status->accept_time=Carbon::now();

        $status->save();
        $goodsorder->update();




        return response()->json($status,200);
    }

    public function prepareorder(Request $request){

        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $personal = Personal::where('personal_mobile', $mobile)->first();
        

        $goodsorder=GoodsOrders::where('orderuniquecode',$request->code)->first();
        $goodsorder->status='در حال آماده سازی';

        $status=GoodsOrdersStatuses::where('goods_orders_id',$goodsorder->id)->first();

        $status->preparation_time=Carbon::now();

        $status->save();
        $goodsorder->update();


       

        return response()->json($status,200);

    }

    public function sendorder(Request $request){

        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $personal = Personal::where('personal_mobile', $mobile)->first();
        $goodsorder=GoodsOrders::where('orderuniquecode',$request->code)->first();
        $goodsorder->status='ارسال شده';
        $customer = Cunsomer::find($goodsorder->cunsomers_id);
        $status=GoodsOrdersStatuses::where('goods_orders_id',$goodsorder->id)->first();
        $status->send_time=Carbon::now();


    $useracount_Worker=$personal->useracounts[1];
    $useracount_Customer=$customer->useracounts[0];
    $cost=$goodsorder->totalamountitems+$goodsorder->packingprice+$goodsorder->sendingprice;

    $goodsorder->payedprice=$cost;

    if($useracount_Customer->cash>=$cost){

        $transactionbardasht = new Transations();
        $transactionbardasht->user_acounts_id=$useracount_Customer->id;     
        $transactionbardasht->type='برداشت';
        $transactionbardasht->for='هزینه سفارش';
        $transactionbardasht->order_unique_code=$goodsorder->orderuniquecode;
        $transactionbardasht->amount=$cost;
        $transactionbardasht->from_to='به حساب خدمت رسان فروشنده با شناسه '.$useracount_Worker->id;
        $useracount_Customer->cash=$useracount_Customer->cash-$cost;
        $transactionbardasht->save();
        $useracount_Customer->update();

        // $transactionvariz = new Transations();
        // $transactionvariz->user_acounts_id=$useracount_Worker->id;     
        // $transactionvariz->type='واریز';
        // $transactionvariz->for='فروش کالا';
        // $transactionvariz->order_unique_code=$goodsorder->orderuniquecode;
        // $transactionvariz->amount=$cost;
        // $transactionvariz->from_to='از حساب مشتری با شناسه '.$useracount_Customer->id;
        // $useracount_Worker->cash=$useracount_Worker->cash+$cost;
        // $transactionvariz->save();
        // $useracount_Worker->update();
  
      }else{
        if($useracount_Customer->cash>0){
              //تراکنش های نقدی
          $naghd=$cost-$useracount_Customer->cash;
          $goodsorder->cashamout=$naghd;
  
          $transactionbardasht = new Transations();
          $transactionbardasht->user_acounts_id=$useracount_Customer->id;     
          $transactionbardasht->type='برداشت';
          $transactionbardasht->for='هزینه سفارش';
          $transactionbardasht->order_unique_code=$goodsorder->orderuniquecode;
          $transactionbardasht->amount=$useracount_Customer->cash;
          $transactionbardasht->from_to='به حساب خدمت رسان فروشنده با شناسه '.$useracount_Worker->id;
          $transactionbardasht->save();

          $transactionbardashtnaghd = new Transations();
          $transactionbardashtnaghd->user_acounts_id=$useracount_Customer->id;     
          $transactionbardashtnaghd->type='برداشت';
          $transactionbardashtnaghd->method='نقدی';
          $transactionbardashtnaghd->for='هزینه سفارش';
          $transactionbardashtnaghd->order_unique_code=$goodsorder->orderuniquecode;
          $transactionbardashtnaghd->amount=$naghd;
          $transactionbardashtnaghd->from_to='به صورت نقدی به حساب خدمت رسان فروشنده با شناسه '.$useracount_Worker->id;
          $transactionbardashtnaghd->description='این تراکنش به صورت نقدی و بدون اعمال در حساب خدمت رسان ثبت گردید';
          $transactionbardashtnaghd->save();

          $useracount_Customer->cash=$useracount_Customer->cash-$useracount_Customer->cash;
          $useracount_Customer->update();

        //   $transactionvariz = new Transations();
        //   $transactionvariz->user_acounts_id=$useracount_Worker->id;     
        //   $transactionvariz->type='واریز';
        //   $transactionvariz->for='فروش کالا';
        //   $transactionvariz->order_unique_code=$orderdata->order_unique_code;
        //   $transactionvariz->amount=$useracount_Customer->cash;
        //   $transactionvariz->from_to='از حساب مشتری با شناسه '.$useracount_Customer->id;
        //   $transactionvariz->save();

        //   $transactionvariznaghd = new Transations();
        //   $transactionvariznaghd->user_acounts_id=$useracount_Worker->id;     
        //   $transactionvariznaghd->type='واریز';
        //   $transactionvariznaghd->method='نقدی';
        //   $transactionvariznaghd->for='انجام سفارش';
        //   $transactionvariznaghd->order_unique_code=$orderdata->order_unique_code;
        //   $transactionvariznaghd->amount=$naghd;
        //   $transactionvariznaghd->from_to='به صورت نقد از حساب مشتری با شناسه'.$useracount_Customer->id;
        //   $transactionvariznaghd->description='این تراکنش به صورت نقدی و بدون اعمال در حساب مشتری ثبت گردید';
        //   $transactionvariznaghd->save();

        //   $useracount_Worker->cash=$useracount_Worker->cash+$useracount_Customer->cash;
        //   $useracount_Worker->update();
  
        }else{
  
  
           //تراکنش های نقدی
           $transactionbardashtnaghd = new Transations();
           $transactionbardashtnaghd->user_acounts_id=$useracount_Customer->id;     
           $transactionbardashtnaghd->type='برداشت';
           $transactionbardashtnaghd->method='نقدی';
           $transactionbardashtnaghd->for='هزینه سفارش';
           $transactionbardashtnaghd->order_unique_code=$goodsorder->orderuniquecode;
           $transactionbardashtnaghd->amount=$cost;
           $transactionbardashtnaghd->from_to='به صورت نقدی به حساب خدمت رسان فروشنده با شناسه '.$useracount_Worker->id;
           $transactionbardashtnaghd->description='این تراکنش به صورت نقدی و بدون اعمال در حساب مشتری ثبت گردید';
           $transactionbardashtnaghd->save();

        //    $transactionvariznaghd =new Transations();
        //    $transactionvariznaghd->user_acounts_id=$useracount_Worker->id;     
        //    $transactionvariznaghd->type='واریز';
        //    $transactionvariznaghd->method='نقدی';
        //    $transactionvariznaghd->for='فروش کالا';
        //    $transactionvariznaghd->order_unique_code=$orderdata->order_unique_code;
        //    $transactionvariznaghd->amount=$cost;
        //    $transactionvariznaghd->from_to='به صورت نقد از حساب مشتری با شناسه'.$useracount_Customer->id;
        //    $transactionvariznaghd->description='این تراکنش به صورت نقدی و بدون اعمال در حساب مشتری ثبت گردید';
        //    $transactionvariznaghd->save();

        }
      }








        $status->save();
        $goodsorder->update();
        return response()->json($status,200);
    }

    public function deliverorder(Request $request){

        $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        $mobile = $payload->get('mobile');
        $personal = Personal::where('personal_mobile', $mobile)->first();
        $customer = Cunsomer::find($goodsorder->cunsomers_id);
        $goodsorder=GoodsOrders::where('orderuniquecode',$request->code)->first();
        $goodsorder->status='تحویل شده';
        $status=GoodsOrdersStatuses::where('goods_orders_id',$goodsorder->id)->first();

         $delivercode=$request->confirmcode;

         if($delivercode!=$goodsorder->delivercode){



            return response()->json(
                ['data'=>'','message'=>'کد نحویل نا درست می باشد']
                                                                    ,405);
         }

         $useracount_Worker=$personal->useracounts[1];
         $useracount_Customer=$customer->useracounts[0];
         $cost=$goodsorder->totalamountitems+$goodsorder->packingprice+$goodsorder->sendingprice;

         if($goodsorder->cashamount=0){

            // $transactionbardasht = new Transations();
            // $transactionbardasht->user_acounts_id=$useracount_Customer->id;     
            // $transactionbardasht->type='برداشت';
            // $transactionbardasht->for='هزینه سفارش';
            // $transactionbardasht->order_unique_code=$goodsorder->orderuniquecode;
            // $transactionbardasht->amount=$cost;
            // $transactionbardasht->from_to='به حساب خدمت رسان فروشنده با شناسه '.$useracount_Worker->id;
            // $useracount_Customer->cash=$useracount_Customer->cash-$cost;
            // $transactionbardasht->save();
            // $useracount_Customer->update();
    
            $transactionvariz = new Transations();
            $transactionvariz->user_acounts_id=$useracount_Worker->id;     
            $transactionvariz->type='واریز';
            $transactionvariz->for='فروش کالا';
            $transactionvariz->order_unique_code=$goodsorder->orderuniquecode;
            $transactionvariz->amount=$cost;
            $transactionvariz->from_to='از حساب مشتری با شناسه '.$useracount_Customer->id;
            $useracount_Worker->cash=$useracount_Worker->cash+$cost;
            $transactionvariz->save();
            $useracount_Worker->update();
      
          }else{

            $etebarycash=$cost-$goodsorder->cashamount;


            if($etebarycash>0){
                  //تراکنش های نقدی
              $naghd=$cost-$useracount_Customer->cash;
              $goodsorder->cashamout=$naghd;
    
              $transactionvariz = new Transations();
              $transactionvariz->user_acounts_id=$useracount_Worker->id;     
              $transactionvariz->type='واریز';
              $transactionvariz->for='فروش کالا';
              $transactionvariz->order_unique_code=$goodsorder->orderuniquecode;
              $transactionvariz->amount=$etebarycash;
              $transactionvariz->from_to='از حساب مشتری با شناسه '.$useracount_Customer->id;
              $transactionvariz->save();
    
              $transactionvariznaghd = new Transations();
              $transactionvariznaghd->user_acounts_id=$useracount_Worker->id;     
              $transactionvariznaghd->type='واریز';
              $transactionvariznaghd->method='نقدی';
              $transactionvariznaghd->for='فروش کالا';
              $transactionvariznaghd->order_unique_code=$goodsorder->orderuniquecode;
              $transactionvariznaghd->amount=$goodsorder->cashamount;
              $transactionvariznaghd->from_to='به صورت نقد از حساب مشتری با شناسه'.$useracount_Customer->id;
              $transactionvariznaghd->description='این تراکنش به صورت نقدی و بدون اعمال در حساب مشتری ثبت گردید';
              $transactionvariznaghd->save();
    
              $useracount_Worker->cash=$useracount_Worker->cash+$useracount_Customer->cash;
              $useracount_Worker->update();
      
            }else{
      
              $transactionvariznaghd = new Transations();
      
               //تراکنش های نقدی
    
               $transactionvariznaghd->user_acounts_id=$useracount_Worker->id;     
               $transactionvariznaghd->type='واریز';
               $transactionvariznaghd->method='نقدی';
               $transactionvariznaghd->for='فروش کالا';
               $transactionvariznaghd->order_unique_code=$goodsorder->orderuniquecode;
               $transactionvariznaghd->amount=$goodsorder->cashamount;
               $transactionvariznaghd->from_to='به صورت نقد از حساب مشتری با شناسه'.$useracount_Customer->id;
               $transactionvariznaghd->description='این تراکنش به صورت نقدی و بدون اعمال در حساب مشتری ثبت گردید';
               $transactionvariznaghd->save();
    
            }
          }


      

        $status->deliver_time=Carbon::now();

        $status->save();
        $goodsorder->update();

        
        return response()->json($status,200);
    }
}

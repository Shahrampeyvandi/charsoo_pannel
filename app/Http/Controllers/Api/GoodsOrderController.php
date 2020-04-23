<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store\Store;
use App\Models\Store\GoodsOrders;
use App\Models\Store\GoodsOrdersImages;
use App\Models\Store\StoreWorkingHours;
use App\Models\Cunsomers\Cunsomer;
use App\Models\Store\Product;
use App\Models\Acounting\Transations;
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

        $store=Store::find($request->id);

        $order=new GoodsOrders;

        $order->store_id=$store->id;

        $order->personal_mobile	=$store->id;

        $order->cunsomers_id =$customer->id;

        $order->cunsomer_mobile=$customer->cunsomer_mobile;

        $order->off_code=$request->offcode;
    
        $order->items=implode(' , ',$request->items);

        $order->counts=implode(' , ',$request->counts);

        $total=0;
        $items=$request->items;
        $counts=$request->counts;
        for($i=0;count($items);$i++){

            $product=Product::find($items[$i]);

            $total+=$product->product_price*$counts[$i];

        }

    
        $order->totalamountitems=$total;
    
        $order->packingprice=$store->packing_price;
    
        $order->sendingprice=$store->sending_price;
    
        $address=CustomerAddress::find($request->address);

        $order->address=$address->address;
    
        $order->address_id=$address->id;
    
        $order->deliverdate=$request->deliverdate;
    
        $order->delivertime=$request->delivertime;
    
        $order->description=$request->description;
    
        $order->delivercode=rand(10000,99999);
    
        $order->questions=implode(' , ',$request->questions);
    
        $order->answers	=implode(' , ',$request->answers);

        $order->save();

        $date = Carbon::parse($order->deliverdate)->timestamp;
     $Code = $this->generateRandomString($order->cunsomer_mobile, $date, $order->id);
     
     $order->orderuniquecode=$Code;

     $order->update();


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
                $wrkhors
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

    public function getgoodsorder(Request $request){

        $order=GoodsOrders::where('orderuniquecode',$request->code)->first();



        return response()->json(
            $order
            ,200);
    }
}

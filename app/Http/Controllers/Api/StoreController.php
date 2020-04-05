<?php

namespace App\Http\Controllers\Api;

use App\Models\Store\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function getStore(Request $request)
    {
        $store_id = $request->store_id;
        
        $store = Store::where('id', $store_id)->first();
        $storeArray = [];
        $storeArray['store_name'] = $store->store_name;
        $storeArray['store_description'] = $store->store_description;
        $storeArray['store_type'] = $store->store_type;
        $storeArray['store_picture'] = $store->store_picture;
        $storeArray['store_icon'] = $store->store_icon;
        $storeArray['store_city'] = $store->store_city;
        $storeArray['store_main_street'] = $store->store_main_street;
        $storeArray['store_secondary_street'] = $store->store_secondary_street;
        $storeArray['store_pelak'] = $store->store_pelak;
        
        foreach ($store->neighborhoods as $key => $neighborhood) {
            $storeArray['neighborhoods'][$key+1]['name'] = $neighborhood->name;
            $storeArray['neighborhoods'][$key+1]['city'] = $neighborhood->city_id;
           
        }
        $storeProducts = [];
        if(!is_null($store)){
            foreach ($store->products as $key => $product) {
                $storeArray['products'][$key+1]['product_name']= $product->product_name;
                $storeArray['products'][$key+1]['product_price'] = $product->product_price;
                $storeArray['products'][$key+1]['product_picture'] = $product->product_picture;
                $storeArray['products'][$key+1]['product_description'] = $product->product_description;
                $storeArray['products'][$key+1]['product_status'] = $product->product_status;
            }
        }
        return response()->json(
            $storeArray,
            200
          );

}
}

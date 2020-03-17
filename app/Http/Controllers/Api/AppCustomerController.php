<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cunsomers\Cunsomer;
use App\Models\Services\ServiceCategory;
use App\Models\Services\Service;
use App\Models\Store\Store;
use App\Models\App\AppMenu;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AppCustomerController extends Controller
{
    public function index()
    {


       // $payload = JWTAuth::parseToken($request->header('Authorization'))->getPayload();
        //$mobile = $payload->get('mobile');

     

        $appmenus = AppMenu::orderBy('priority', 'DESC')->get();

       
        foreach($appmenus as $keym=>$appmenu){

            $array = unserialize( $appmenu->item );
    
        
            if($appmenu->type == 'دسته بندی'){
    
    
                foreach($array as $keyn=>$arr){
        
                    $category = ServiceCategory::where('id', $arr)->first();
        
                   // $cat=array();

                    $services = Service::where('service_category_id', $arr)->first();

                    $cat['title']=$services->service_title;
                    $cat['icon']='icon';

        
                    //$array[$keyn]=$category['category_title'];
                    $array[$keyn]=$cat;

    
        
                    
        
                }
        
                $appmenus[$keym]->item=$array;
    
    
            }else if($appmenu->type == 'خدمت'){
    
    
    
                foreach($array as $keyn=>$arr){
        
    
                    $service = Service::where('id', $arr)->first();

        
                    $ser['title']=$services->service_title;
                    $ser['icon']='icon';
        

                    //$array[$keyn]=$service['service_title'];
                    $array[$keyn]=$ser;

    
        
                    
        
                }
        
                $appmenus[$keym]->item=$array;
    
    
    
    
            }else if($appmenu->type == 'فروشگاه'){
    
    
                foreach($array as $keyn=>$arr){
        
                    $store = Store::where('id', $arr)->first();
        


                    $ser['title']=$store->store_name;
                    $ser['icon']='icon';
        
        
                    //$array[$keyn]=$store['store_name'];
                    $array[$keyn]=$ser;

        
                    
        
                }
        
                $appmenus[$keym]->item=$array;
    
    
    
            }
            
        }






            return response()->json([
                'data' => $appmenus,
              ], 200);
    }
}

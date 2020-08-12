<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SearchController extends Controller
{
 
    public function search(Request $request)
    {
        $keyword = $request->keyword;
         $lat = $request->lat;
       $lng = $request->lng;
        $cityname = $request->city;
       $city = ucfirst($cityname);
       $nearbystore = DB::table('store')
                    ->select('store_id',DB::raw("6371 * acos(cos(radians(".$lat . ")) 
                    * cos(radians(store.lat)) 
                    * cos(radians(store.lng) - radians(" . $lng . ")) 
                    + sin(radians(" .$lat. ")) 
                    * sin(radians(store.lat))) AS distance"))
                  ->where('store.del_range','>=','distance')
                  ->where('store.city',$city)
                  ->orderBy('distance')
                  ->first();
      if($nearbystore) {  

        $prod = DB::table('product')
                ->where('product_name', 'like', '%'.$keyword.'%')
                ->get();

        if(count($prod)>0){
            $result =array();
            $i = 0;

            foreach ($prod as $prods) {
                array_push($result, $prods);

                $app = json_decode($prods->product_id);
                $apps = array($app);
                $app = DB::table('product_varient')
                        ->whereIn('product_id', $apps)
                        ->get();
                        
                $result[$i]->varients = $app;
                $i++; 
             
            }

            $message = array('status'=>'1', 'message'=>'Products found', 'data'=>$prod);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'Products not found', 'data'=>[]);
            return $message;
        }
      }
       else{
           $message = array('status'=>'2', 'message'=>'No Products Found Nearby', 'data'=>[]);
            return $message; 
       }
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class CategoryController extends Controller
{
 public function cate(Request $request)
    {
     $cat = DB::table('categories')
          ->where('level', 0)
          ->get();

        if(count($cat)>0){
            $result =array();
            $i = 0;

            foreach ($cat as $cats) {
                array_push($result, $cats);

                $app = json_decode($cats->cat_id);
                $apps = array($app);
                $app = DB::table('categories')
                        ->whereIn('parent', $apps)
                        ->where('level',1)
                        ->get();
                        
                $result[$i]->subcategory = $app;
                $i++; 
                $res =array();
                $j = 0;
                foreach ($app as $appss) {
                    array_push($res, $appss);
                    $c = array($appss->cat_id);
                    $app1 = DB::table('categories')
                            ->whereIn('parent', $c)
                            ->where('level',2)
                            ->get();
                if(count($app1)>0){        
                    $res[$j]->subchild = $app1;
                    $j++; 
                   }
                   else{
                     $res[$j]->subchild = [];
                    $j++;  
                   }
                 }   
             
            }

            $message = array('status'=>'1', 'message'=>'data found', 'data'=>$cat);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }
    }
      
  public function cat_product(Request $request)
    {
     $cat_id =$request->cat_id;  
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
       $prod =  DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
          ->where('product.cat_id', $cat_id)
          ->where('store_products.store_id', $nearbystore->store_id)
          ->get();

        if(count($prod)>0){
            $result =array();
            $i = 0;

            foreach ($prod as $prods) {
                array_push($result, $prods);

                $app = json_decode($prods->product_id);
                $apps = array($app);
                $app =  DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'product_varient.price', 'product_varient.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price', 'deal_product.valid_from', 'deal_product.valid_to')
                         ->where('store_products.store_id', $nearbystore->store_id)
                        ->whereIn('product_varient.product_id', $apps)
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
    
    
    
 public function cat(Request $request)
    {
     $cat = DB::table('categories')
          ->where('level', 0)
          ->get();

        if(count($cat)>0){
            $result =array();
            $i = 0;

            foreach ($cat as $cats) {
                array_push($result, $cats);

                $app = json_decode($cats->cat_id);
                $apps = array($app);
                $app = DB::table('categories')
                        ->whereIn('parent', $apps)
                        ->where('level',1)
                        ->get();
                        
                        
                if(count($app)>0){
                $result[$i]->subcategory = $app;
                $i++; 
                $res =array();
                $j = 0;
                foreach ($app as $appss) {
                    array_push($res, $appss);
                    $c = array($appss->cat_id);
                    $app1 = DB::table('categories')
                            ->whereIn('parent', $c)
                            ->where('level',2)
                            ->get();
                if(count($app1)>0){        
                    $res[$j]->subchild = $app1;
                    $j++; 
                    $res2 =array();
                    $k = 0;
                    foreach ($app1 as $apps1) {
                        array_push($res2, $apps1);
                        $catt = array($apps1->cat_id);
                        $prod = DB::table('product')
                                ->whereIn('cat_id', $catt)
                                ->get();
                                
                     $res2[$k]->product = $prod;
                     $k++;   
                     }
                    
                   }
                   else{
                       $pr = DB::table('product')
                        ->whereIn('cat_id', $c)
                        ->get();    
                        $res[$j]->product = $pr;
                        $j++; 
                   }
                 }   
                }
                else{
                $app = DB::table('product')
                        ->whereIn('cat_id', $apps)
                        ->get();    
                $result[$i]->product = $app;
                $i++; 
                }
            }

            $message = array('status'=>'1', 'message'=>'data found', 'data'=>$cat);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }
    }
    
     public function varient(Request $request)
    {
        $prod_id = $request->product_id;
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
        $varient= DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                 ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
                         ->select('store_products.store_id','store_products.stock','product_varient.varient_id', 'product_varient.description', 'product_varient.price', 'product_varient.mrp', 'product_varient.varient_image','product_varient.unit','product_varient.quantity','deal_product.deal_price', 'deal_product.valid_from', 'deal_product.valid_to')
                ->where('product_id',$prod_id)
                ->where('store_products.store_id',$nearbystore->store_id)
                ->get();
        if(count($varient)>0){        
          $message = array('status'=>'1', 'message'=>'varients', 'data'=>$varient);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }        
                
    }
    
    
     public function dealproduct(Request $request)
    {
        $d = Carbon::Now();
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
        $deal_p= DB::table('deal_product')
                ->join('store_products', 'deal_product.varient_id', '=', 'store_products.varient_id')
                ->join('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                ->join('product', 'product_varient.product_id', '=', 'product.product_id')
                ->select('store_products.store_id','store_products.stock','deal_product.deal_price as price', 'product_varient.varient_image', 'product_varient.quantity','product_varient.unit', 'product_varient.mrp','product_varient.description' ,'product.product_name','product.product_image','product_varient.varient_id','product.product_id','deal_product.valid_to','deal_product.valid_from')
                ->groupBy('store_products.store_id','store_products.stock','deal_product.deal_price', 'product_varient.varient_image', 'product_varient.quantity','product_varient.unit', 'product_varient.mrp','product_varient.description' ,'product.product_name','product.product_image','product_varient.varient_id','product.product_id','deal_product.valid_to','deal_product.valid_from')
                ->where('store_products.store_id',$nearbystore->store_id)
                ->whereDate('deal_product.valid_from','<=',$d->toDateString())
                ->WhereDate('deal_product.valid_to','>',$d->toDateString())
                ->get();
          
          
          if(count($deal_p)>0){
            $result =array();
            $i = 0;
             $j = 0;
            foreach ($deal_p as $deal_ps) {
                array_push($result, $deal_ps);
                
                $val_to =  $deal_ps->valid_to;       
                $diff_in_minutes = $d->diffInMinutes($val_to); 
                $totalDuration =  $d->diff($val_to)->format('%H:%I:%S');
                $result[$i]->timediff = $diff_in_minutes;
                $i++; 
                $result[$j]->hoursmin= $totalDuration;
                $j++; 
            }

            $message = array('status'=>'1', 'message'=>'Products found', 'data'=>$deal_p);
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
    
    
       public function top_six(Request $request){
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
      $topsix = DB::table('store_products')
                 ->join ('product_varient', 'store_products.varient_id', '=', 'product_varient.varient_id')
                  ->join ('product', 'product_varient.product_id', '=', 'product.product_id')
                  ->Leftjoin ('store_orders', 'product_varient.varient_id', '=', 'store_orders.varient_id') 
                  ->Leftjoin ('orders', 'store_orders.order_cart_id', '=', 'orders.cart_id')
                  ->join ('categories', 'product.cat_id','=','categories.cat_id')
                  ->select('categories.title', 'categories.image', 'categories.description','categories.cat_id',DB::raw('count(store_orders.varient_id) as count'))
                  ->groupBy('categories.title', 'categories.image', 'categories.description','categories.cat_id')
                   ->where('store_products.store_id', $nearbystore->store_id)
                  ->orderBy('count','desc')
                  ->limit(6)
                  ->get();
         if(count($topsix)>0){
        	$message = array('status'=>'1', 'message'=>'Top Six Categories', 'data'=>$topsix);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'Nothing in Top Six', 'data'=>[]);
        	return $message;
        } 
    }
       else{
           $message = array('status'=>'2', 'message'=>'No Products Found Nearby', 'data'=>[]);
            return $message; 
       }
  }    
  
    
}
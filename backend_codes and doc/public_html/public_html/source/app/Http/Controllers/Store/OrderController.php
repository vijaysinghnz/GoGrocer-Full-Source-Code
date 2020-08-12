<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class OrderController extends Controller
{
    
    public function cancel_products(Request $request)
    {
       $id= $request->store_order_id;
       $cart = DB::table('store_orders')
            ->select('order_cart_id','varient_id','qty')
            ->where('store_order_id', $id)
            ->first();
      $curr = DB::table('currency')
            ->first();
      $cart_id = $cart->order_cart_id;
      $var = DB::table('store_orders')
    ->where('order_cart_id', $cart_id)
    ->get();
       $price2 = 0;
     
     foreach ($var as $h){
        $varient_id = $h->varient_id;
        $p = DB::table('product_varient')
            ->join('product','product_varient.product_id','=','product.product_id')
           ->where('product_varient.varient_id',$varient_id)
           ->first();
        $price = $p->price;
        $mrpprice = $p->mrp;
        $order_qty = $h->qty;
        $price2+= $price*$order_qty;
        $unit[] = $p->unit;
        $qty[]= $p->quantity;
        $p_name[] = $p->product_name."(".$p->quantity.$p->unit.")*".$order_qty;
        $prod_name = implode(',',$p_name);
        }
      $ordr = DB::table('orders')
            ->where('cart_id', $cart->order_cart_id)
            ->first();
        $v = DB::table('product_varient')
       ->where('varient_id', $cart->varient_id)
       ->first();
       
       $v_price =$v->price * $cart->qty;       
      $ordr = DB::table('orders')
            ->where('cart_id', $cart->order_cart_id)
            ->first();
       $user_id = $ordr->user_id;
       $tot_price = $ordr->total_price-$v_price;
       $rem_price = $ordr->rem_price-$v_price;
       if($rem_price>0){
          $rem_price2 = $ordr->rem_price-$v_price; 
       }else{
           $rem_price2 = 0;
       }
       if($tot_price>0){
          $tot_price2 =$ordr->total_price-$v_price; 
       }else{
           $tot_price2 = 0;
       }
       $userwa = DB::table('users')
                     ->where('user_id',$user_id)
                     ->first();
      if($ordr->payment_method == 'COD' || $ordr->payment_method == 'Cod' || $ordr->payment_method == 'cod'){         
        $newbal = $userwa->wallet;   
      }
      else{
        $newbal = $userwa->wallet + $v_price;  
      }
       $orders = DB::table('store_orders')
            ->where('order_cart_id', $cart->order_cart_id)
            ->where('store_approval',1)
            ->get();   
       
        if(count($orders)==1 || count($orders)==0){
         $email=Session::get('bamaStore');
    	 $store= DB::table('store')
    	 		   ->where('email',$email)
    	 		   ->first();
         if($ordr->cancel_by_store==0){
            $cancel=1;
          $store_id = DB::table('store')
              ->select("store_id","store_name"
            ,DB::raw("6371 * acos(cos(radians(".$store->lat . ")) 
            * cos(radians(lat)) 
            * cos(radians(lng) - radians(" . $store->lng . ")) 
            + sin(radians(" .$store->lat. ")) 
            * sin(radians(lat))) AS distance"))
           ->where('city',$store->city) 
           ->where('store_id','!=',$store->store_id)
           ->orderBy('distance')
           ->first();
           
            if($store_id){
            $ordupdate = DB::table('orders')
                     ->where('cart_id', $cart->order_cart_id)
                     ->update(['store_id'=>$store_id->store_id,
                     'cancel_by_store'=>$cancel]);
            $carte= DB::table('store_orders')
            ->where('order_cart_id', $cart->order_cart_id)
            ->where('store_approval',0)
            ->get();
         
            foreach($carte as $carts){
                $v1 = DB::table('product_varient')
               ->where('varient_id', $carts->varient_id)
               ->first();
               
               $v_price1 =$v1->price * $carts->qty;       
               $ordr1 = DB::table('orders')
                    ->where('cart_id', $carts->order_cart_id)
                    ->first();
               $user_id1 = $ordr1->user_id;
               if($ordr->payment_method != 'COD' || $ordr->payment_method != 'Cod' || $ordr->payment_method != 'cod'){
               $userwa1 = DB::table('users')
                             ->where('user_id',$user_id1)
                             ->first();
                $newbal1 = $userwa1->wallet - $v_price1;
                
                 $userwalletupdate = DB::table('users')
                     ->where('user_id',$user_id1)
                     ->update(['wallet'=>$newbal1]);
               }
            }
            
            $cart_update= DB::table('store_orders')
            ->where('order_cart_id', $cart->order_cart_id)
            ->update(['store_approval'=>1]);
               ///////send notification to store//////
              
                $notification_title = "WooHoo ! You Got a New Order";
                $notification_text = "you got an order cart id #".$cart_id." contains of " .$prod_name." of price ".$curr->currency_sign." ".$price2. ". It will have to delivered on ".$ordr->delivery_date." between ".$ordr->time_slot.".";
                
                $date = date('d-m-Y');
                $getUser = DB::table('store')
                                ->get();
        
                $getDevice = DB::table('store')
                         ->where('store_id', $store_id->store_id)
                        ->select('device_id')
                        ->first();
                $created_at = Carbon::now();
        
                
                $getFcm = DB::table('fcm')
                            ->where('id', '1')
                            ->first();
                            
                $getFcmKey = $getFcm->store_server_key;
                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
                $token = $getDevice->device_id;
                    
        
                    $notification = [
                        'title' => $notification_title,
                        'body' => $notification_text,
                        'sound' => true,
                    ];
                    
                    $extraNotificationData = ["message" => $notification];
        
                    $fcmNotification = [
                        'to'        => $token,
                        'notification' => $notification,
                        'data' => $extraNotificationData,
                    ];
        
                    $headers = [
                        'Authorization: key='.$getFcmKey,
                        'Content-Type: application/json'
                    ];
        
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$fcmUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
                     ///////send notification to store//////
             
                $dd = DB::table('store_notification')
                    ->insert(['store_id'=>$store_id->store_id,
                     'not_title'=>$notification_title,
                     'not_message'=>$notification_text]);
                    
                $results = json_decode($result);
            return redirect()->back()->withSuccess('Order cancelled successfully');
            }
            else{
            $carte= DB::table('store_orders')
            ->where('order_cart_id', $cart->order_cart_id)
            ->where('store_approval',0)
            ->get();
            
            foreach($carte as $carts){
                $v1 = DB::table('product_varient')
               ->where('varient_id', $carts->varient_id)
               ->first();
               
               $v_price1 =$v1->price * $carts->qty;       
               $ordr1 = DB::table('orders')
                    ->where('cart_id', $carts->order_cart_id)
                    ->first();
               $user_id1 = $ordr1->user_id;
                if($ordr->payment_method != 'COD' || $ordr->payment_method != 'Cod' || $ordr->payment_method != 'cod'){
               $userwa1 = DB::table('users')
                             ->where('user_id',$user_id1)
                             ->first();
                $newbal1 = $userwa1->wallet - $v_price1;
                 $userwalletupdate = DB::table('users')
                     ->where('user_id',$user_id1)
                     ->update(['wallet'=>$newbal1]);
                }
            }    
            $ordupdate = DB::table('orders')
                     ->where('cart_id', $cart->order_cart_id)
                     ->update(['store_id'=>0,
                     'cancel_by_store'=>$cancel]);
            
            
            $cart_update= DB::table('store_orders')
            ->where('order_cart_id', $cart->order_cart_id)
            ->update(['store_approval'=>1]); 
            return redirect()->back()->withSuccess('Order cancelled successfully');
            }
        }
        else{
            $cancel=2;
            $carte= DB::table('store_orders')
            ->where('order_cart_id', $cart->order_cart_id)
            ->where('store_approval',0)
            ->get();
            
            foreach($carte as $carts){
                $v1 = DB::table('product_varient')
               ->where('varient_id', $carts->varient_id)
               ->first();
               
               $v_price1 =$v1->price * $carts->qty;       
               $ordr1 = DB::table('orders')
                    ->where('cart_id', $carts->order_cart_id)
                    ->first();
               $user_id1 = $ordr1->user_id;
              if($ordr->payment_method != 'COD' || $ordr->payment_method != 'Cod' || $ordr->payment_method != 'cod'){
               $userwa1 = DB::table('users')
                             ->where('user_id',$user_id1)
                             ->first();
                $newbal1 = $userwa1->wallet - $v_price1;
                 $userwalletupdate = DB::table('users')
                     ->where('user_id',$user_id1)
                     ->update(['wallet'=>$newbal1]);
              }
            }
             $ordupdate = DB::table('orders')
                     ->where('cart_id', $cart->order_cart_id)
                     ->update(['store_id'=>0,
                     'cancel_by_store'=>$cancel]);
            
            
            $cart_update= DB::table('store_orders')
            ->where('order_cart_id', $cart->order_cart_id)
            ->update(['store_approval'=>1]);
        return redirect()->back()->withSuccess('Order cancelled successfully');
        }    
        return redirect()->back()->withSuccess('Order cancelled successfully');
         
        }    
            
        else{    
       $cancel_product = DB::table('store_orders')
                       ->where('store_order_id', $id)
                       ->update(['store_approval'=>0]);
     if($ordr->payment_method != 'COD' || $ordr->payment_method != 'Cod' || $ordr->payment_method != 'cod'){       
        $userwallet = DB::table('users')
                     ->where('user_id',$user_id)
                     ->update(['wallet'=>$newbal]);   
        $ordr = DB::table('orders')
            ->where('cart_id', $cart->order_cart_id)
            ->update(['total_price'=>$tot_price2,
            'rem_price'=>$rem_price2]);             
        }
        return redirect()->back()->withSuccess('product cancelled successfully');                  
                       
        }             
                   
    }
    
      public function reject_order(Request $request)
    {
       $cart_id= $request->cart_id;
      $ordr = DB::table('orders')
            ->where('cart_id', $cart_id)
            ->first();
       $user_id1 = $ordr->user_id;
       $orders = DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->where('store_approval',1)
            ->get();   
        $curr = DB::table('currency')
             ->first(); 
         $email=Session::get('bamaStore');
    	 $store= DB::table('store')
    	 		   ->where('email',$email)
    	 		   ->first();
                  
        $v_price1 = 0;
        $cartss= DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->where('store_approval',0)
            ->get();
            
    if(count($cartss)>0){
          foreach($cartss as $carts){
                $v1 = DB::table('store_orders')
               ->where('store_order_id', $carts->store_order_id)
               ->first();
               
               $v_price1 += $v1->price * $v1->qty;       
              
            }      
         $user_id1 = $ordr->user_id;
         $userwa1 = DB::table('users')
                     ->where('user_id',$user_id1)
                     ->first();
       if($ordr->payment_method == 'COD' || $ordr->payment_method == 'Cod' || $ordr->payment_method == 'cod'){
            $newbal1 = $userwa1->wallet;   
          }
          else{
            $newbal1 = $userwa1->wallet - $v_price1;
          }                 
         $userwalletupdate = DB::table('users')
             ->where('user_id',$user_id1)
             ->update(['wallet'=>$newbal1]);
       }     
             

        $var = DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->where('store_approval',1)
            ->get();        
        $price2 = 0;     
       foreach ($var as $h){
        $varient_id = $h->varient_id;
        $p = DB::table('product_varient')
            ->join('product','product_varient.product_id','=','product.product_id')
           ->where('product_varient.varient_id',$varient_id)
           ->first();
        $price = $p->price;   
        $order_qty = $h->qty;
        $price2+= $price*$order_qty;
        $unit[] = $p->unit;
        $qty[]= $p->quantity;
        $p_name[] = $p->product_name."(".$p->quantity.$p->unit.")*".$order_qty;
        $prod_name = implode(',',$p_name);
        }
               
         if($ordr->cancel_by_store==0){
            $cancel=1;
          $store_id = DB::table('store')
              ->select("store_id","store_name"
            ,DB::raw("6371 * acos(cos(radians(".$store->lat . ")) 
            * cos(radians(lat)) 
            * cos(radians(lng) - radians(" . $store->lng . ")) 
            + sin(radians(" .$store->lat. ")) 
            * sin(radians(lat))) AS distance"))
           ->where('city',$store->city) 
           ->where('store_id','!=',$store->store_id)
           ->orderBy('distance')
           ->first();
           
            if($store_id){
            $ordupdate = DB::table('orders')
                     ->where('cart_id', $cart_id)
                     ->update(['store_id'=>$store_id->store_id,
                     'cancel_by_store'=>$cancel,
                     'order_status'=>'Pending'
                     ]);
            
            
            $cart_update= DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->update(['store_approval'=>1]);
            
         
             ///////send notification to store//////
              
                $notification_title = "WooHoo ! You Got a New Order";
                $notification_text = "you got an order cart id #".$cart_id." contains of " .$prod_name." of price ".$curr->currency_sign." ".$price2. ". It will have to delivered on ".$ordr->delivery_date." between ".$ordr->time_slot.".";
                
                $date = date('d-m-Y');
                $getUser = DB::table('store')
                                ->get();
        
                $getDevice = DB::table('store')
                         ->where('store_id', $store_id->store_id)
                        ->select('device_id')
                        ->first();
                $created_at = Carbon::now();
        
                
                $getFcm = DB::table('fcm')
                            ->where('id', '1')
                            ->first();
                            
                $getFcmKey = $getFcm->store_server_key;
                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
                $token = $getDevice->device_id;
                    
        
                    $notification = [
                        'title' => $notification_title,
                        'body' => $notification_text,
                        'sound' => true,
                    ];
                    
                    $extraNotificationData = ["message" => $notification];
        
                    $fcmNotification = [
                        'to'        => $token,
                        'notification' => $notification,
                        'data' => $extraNotificationData,
                    ];
        
                    $headers = [
                        'Authorization: key='.$getFcmKey,
                        'Content-Type: application/json'
                    ];
        
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$fcmUrl);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                    $result = curl_exec($ch);
                    curl_close($ch);
                    
                     ///////send notification to store//////
             
                $dd = DB::table('store_notification')
                    ->insert(['store_id'=>$store_id->store_id,
                     'not_title'=>$notification_title,
                     'not_message'=>$notification_text]);
                    
                $results = json_decode($result);
            return redirect()->back()->withSuccess('Order Rejected successfully');
            }
            else{
            $ordupdate = DB::table('orders')
                     ->where('cart_id', $cart_id)
                     ->update(['store_id'=>0,
                     'cancel_by_store'=>$cancel,
                      'order_status'=>'Pending']);
            
            
            $cart_update= DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->update(['store_approval'=>1]); 
           
            return redirect()->back()->withSuccess('Order Rejected successfully');
            }
        }
        else{
            $cancel=2;
             $ordupdate = DB::table('orders')
                     ->where('cart_id', $cart_id)
                     ->update(['store_id'=>0,
                     'cancel_by_store'=>$cancel,
                      'order_status'=>'Pending']);
            
            
            $cart_update= DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->update(['store_approval'=>1]);
            
        return redirect()->back()->withSuccess('Order Rejected successfully');
        }    
        return redirect()->back()->withSuccess('Order Rejected successfully');
                       
                    
    }
    
 
            
    
    
    
    
}
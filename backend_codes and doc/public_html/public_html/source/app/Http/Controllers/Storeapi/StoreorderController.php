<?php

namespace App\Http\Controllers\Storeapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\SendSms;

class StoreorderController extends Controller
{
use SendSms;
 public function nextdayorders(Request $request)
     {
         $date = date('Y-m-d');
         $day = 1;
         $next_date = date('Y-m-d', strtotime($date.' + '.$day.' days'));
         $store_id = $request->store_id;
         $store= DB::table('store')
    	 		   ->where('store_id',$store_id)
    	 		   ->first();
    	 		   
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->leftJoin('address','orders.address_id','=','address.address_id')
			 ->leftJoin('delivery_boy', 'orders.dboy_id', '=','delivery_boy.dboy_id')
             ->select('orders.cart_id','users.user_name', 'users.user_phone', 'orders.delivery_date', 'orders.total_price','orders.delivery_charge','orders.rem_price','orders.payment_status','delivery_boy.boy_name','delivery_boy.boy_phone','orders.time_slot','orders.order_status','orders.payment_method','users.user_phone','address.*')
             ->where('orders.store_id',$store_id)
             ->where('payment_method', '!=', NULL)
             ->where('orders.delivery_date',$next_date)
             ->where('orders.order_status','!=','cancelled')
			->where('orders.order_status','!=','Completed')
			->orderByRaw("FIELD(order_status , 'Pending', 'Confirmed', 'Out_For_Delivery', 'Completed') ASC")
             ->get();
       
       if(count($ord)>0){
      foreach($ord as $ords){
             $cart_id = $ords->cart_id;    
         $details  =   DB::table('store_orders')
    	               ->where('order_cart_id',$cart_id)
    	               ->where('store_approval',1)
    	               ->get(); 
                  
        
        $data[]=array('user_address'=>$ords->house_no.','.$ords->society.','.$ords->city.','.$ords->landmark.','.$ords->state.','.$ords->pincode, 'cart_id'=>$cart_id,'user_name'=>$ords->user_name, 'user_phone'=>$ords->user_phone, 
        'remaining_price'=>$ords->rem_price,'order_price'=>$ords->total_price,'delivery_boy_name'=>$ords->boy_name,'delivery_boy_phone'=>$ords->boy_phone,'delivery_date'=>$ords->delivery_date,'time_slot'=>$ords->time_slot,'payment_mode'=>$ords->payment_method, 'order_status'=>$ords->order_status, 'customer_phone'    =>$ords->user_phone,'order_details'=>$details); 
        }
        }
        else{
            $data[]=array('order_details'=>'no orders found');
        }
        return $data;     
    }          
    
    
 public function todayorders(Request $request)
     {
         $date = date('Y-m-d');
         $store_id = $request->store_id;
         $store= DB::table('store')
    	 		   ->where('store_id',$store_id)
    	 		   ->first();
    	 		   
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->leftJoin('address','orders.address_id','=','address.address_id')
             ->leftJoin('delivery_boy', 'orders.dboy_id', '=','delivery_boy.dboy_id')
             ->select('orders.cart_id','users.user_name', 'users.user_phone', 'orders.delivery_date', 'orders.total_price','orders.delivery_charge','orders.rem_price','orders.payment_status','delivery_boy.boy_name','delivery_boy.boy_phone','orders.time_slot','orders.order_status','orders.payment_method','users.user_phone','address.*')
             ->where('orders.store_id',$store_id)
			->where('orders.delivery_date', $date)
             ->where('payment_method', '!=', NULL)
              ->where('orders.order_status','!=','cancelled')
			->where('orders.order_status','!=','Completed')
			->orderByRaw("FIELD(order_status , 'Pending', 'Confirmed', 'Out_For_Delivery', 'Completed') ASC")
             ->get();
       
       if(count($ord)>0){
      foreach($ord as $ords){
             $cart_id = $ords->cart_id;    
         $details  =   DB::table('store_orders')
    	               ->where('order_cart_id',$cart_id)
    	               ->where('store_approval',1)
    	               ->get(); 
                  
        
        $data[]=array('user_address'=>$ords->house_no.','.$ords->society.','.$ords->city.','.$ords->landmark.','.$ords->state.','.$ords->pincode, 'cart_id'=>$cart_id,'user_name'=>$ords->user_name, 'user_phone'=>$ords->user_phone, 
        'remaining_price'=>$ords->rem_price,'order_price'=>$ords->total_price,'delivery_boy_name'=>$ords->boy_name,'delivery_boy_phone'=>$ords->boy_phone,'delivery_date'=>$ords->delivery_date,'time_slot'=>$ords->time_slot,'payment_mode'=>$ords->payment_method, 'order_status'=>$ords->order_status, 'customer_phone'    =>$ords->user_phone,'order_details'=>$details); 
        }
        }
        else{
            $data[]=array('order_details'=>'no orders found');
        }
        return $data;     
    }      
            
  public function productcancelled(Request $request)
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
       $v = DB::table('product_varient')
       ->where('varient_id', $cart->varient_id)
       ->first();
       
       $v_price =$v->price * $cart->qty;       
      $ordr = DB::table('orders')
            ->where('cart_id', $cart->order_cart_id)
            ->first();
       $user_id = $ordr->user_id;
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
           ->having('distance', '<', 15)
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
               $userwa1 = DB::table('users')
                             ->where('user_id',$user_id1)
                             ->first();
                $newbal1 = $userwa1->wallet - $v_price1;
                 $userwalletupdate = DB::table('users')
                     ->where('user_id',$user_id1)
                     ->update(['wallet'=>$newbal1]);
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
            
           $data[]=array('result'=>'order cancelled successfully');
            }
            else{
            $ordupdate = DB::table('orders')
                     ->where('cart_id', $cart->order_cart_id)
                     ->update(['store_id'=>0,
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
               $userwa1 = DB::table('users')
                             ->where('user_id',$user_id1)
                             ->first();
                $newbal1 = $userwa1->wallet - $v_price1;
                 $userwalletupdate = DB::table('users')
                     ->where('user_id',$user_id1)
                     ->update(['wallet'=>$newbal1]);
            }    
            
            $cart_update= DB::table('store_orders')
            ->where('order_cart_id', $cart->order_cart_id)
            ->update(['store_approval'=>1]); 
            $data[]=array('result'=>'order cancelled successfully');
            }
        }
        else{
            $cancel=2;
             $ordupdate = DB::table('orders')
                     ->where('cart_id', $cart->order_cart_id)
                     ->update(['store_id'=>0,
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
               $userwa1 = DB::table('users')
                             ->where('user_id',$user_id1)
                             ->first();
                $newbal1 = $userwa1->wallet - $v_price1;
                 $userwalletupdate = DB::table('users')
                     ->where('user_id',$user_id1)
                     ->update(['wallet'=>$newbal1]);
            }    
            
            $cart_update= DB::table('store_orders')
            ->where('order_cart_id', $cart->order_cart_id)
            ->update(['store_approval'=>1]);
        $data[]=array('result'=>'order cancelled successfully');
        }    
        $data[]=array('result'=>'order cancelled successfully');
         
        }    
            
        else{    
       $cancel_product = DB::table('store_orders')
                       ->where('store_order_id', $id)
                       ->update(['store_approval'=>0]);
         $userwallet = DB::table('users')
                     ->where('user_id',$user_id)
                     ->update(['wallet'=>$newbal]);
         $data[]=array('result'=>'product cancelled successfully');                  
                       
        }             
       return $data;            
    }





      public function order_rejected(Request $request)
    {
       $cart_id= $request->cart_id;
       $store_id = $request->store_id;
       
      $ordr = DB::table('orders')
            ->where('cart_id', $cart_id)
            ->first();
        $curr = DB::table('currency')
             ->first();
       $orders = DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->where('store_approval',1)
            ->get(); 
         $var = DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->where('store_approval',1)
            ->get();        
    	 $store= DB::table('store')
    	 		   ->where('store_id',$store_id)
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
                     'cancel_by_store'=>$cancel]);
             $carte= DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->where('store_approval',0)
            ->get();
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
            $data[]=array('result'=>'Order Rejected successfully');
            }
            else{
            $ordupdate = DB::table('orders')
                     ->where('cart_id', $cart_id)
                     ->update(['store_id'=>0,
                     'cancel_by_store'=>$cancel]);
            
             $carte= DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->where('store_approval',0)
            ->get();
            $cart_update= DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->update(['store_approval'=>1]); 
            $data[]=array('result'=>'Order Rejected successfully');
            }
        }
        else{
            $cancel=2;
             $ordupdate = DB::table('orders')
                     ->where('cart_id', $cart_id)
                     ->update(['store_id'=>0,
                     'cancel_by_store'=>$cancel]);
            
             $carte= DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->where('store_approval',0)
            ->get();
            $cart_update= DB::table('store_orders')
            ->where('order_cart_id', $cart_id)
            ->update(['store_approval'=>1]);
        $data[]=array('result'=>'Order Rejected successfully');
        }    
        return $data;
                       
                    
    }
    
    

   public function storeconfirm(Request $request)
    {
       $cart_id= $request->cart_id;
       $store_id = $request->store_id;
      $currdate = Carbon::now();
       $curr = DB::table('currency')
             ->first();
       
     $store= DB::table('store')
        	->where('store_id',$store_id)
    	 	->first();
             
      $del_boy = DB::table('delivery_boy')
          ->select("boy_name","boy_phone","dboy_id"
        ,DB::raw("6371 * acos(cos(radians(".$store->lat . ")) 
        * cos(radians(lat)) 
        * cos(radians(lng) - radians(" . $store->lng . ")) 
        + sin(radians(" .$store->lat. ")) 
        * sin(radians(lat))) AS distance"))
       ->where('delivery_boy.boy_city',$store->city)    
       ->orderBy('distance')
       ->first();         
        
        $orr =   DB::table('orders')
                ->where('cart_id',$cart_id)
                ->first();
                    
           $v = DB::table('store_orders')
 		   ->where('order_cart_id',$cart_id)
 		   ->get(); 
          foreach($v as $vs){
                $qt = $vs->qty;
                $pr = DB::table('product_varient')
                    ->join('product', 'product_varient.product_id', '=', 'product.product_id')
                    ->where('varient_id',$vs->varient_id)
                    ->first(); 
                    
                 $stoc = DB::table('store_products')
                    ->where('varient_id',$vs->varient_id)
                    ->where('store_id',$store_id) 
                    ->first();
              if($stoc){     
                $newstock = $stoc->stock - $qt;     
                $st = DB::table('store_products')
                    ->where('varient_id',$vs->varient_id)
                    ->where('store_id',$store_id)
                    ->update(['stock'=>$newstock]);
              }
              else{
                  $message = array('status'=>'0', 'message'=>$pr->product_name."(".$pr->quantity." ".$pr->unit.") is not available in your product list");
	              return $message;
              }
             }        
    if($del_boy){   
       $orderconfirm = DB::table('orders')
                    ->where('cart_id',$cart_id)
                    ->update(['order_status'=>'Confirmed',
                    'dboy_id'=>$del_boy->dboy_id,
                     'confirmed_at' => $currdate]);
         
 		   
         if($orderconfirm){
                $notification_title = "You Got a New Order for Delivery on ".$orr->delivery_date;
                $notification_text = "you got an order with cart id #".$cart_id." of price ".$curr->currency_sign." " .$orr->total_price. ". It will have to delivered on ".$orr->delivery_date." between ".$orr->time_slot.".";
                
                $date = date('d-m-Y');
                $getUser = DB::table('delivery_boy')
                                ->get();
        
                $getDevice = DB::table('delivery_boy')
                         ->where('dboy_id', $del_boy->dboy_id)
                        ->select('device_id')
                        ->first();
                $created_at = Carbon::now();
        
                
                $getFcm = DB::table('fcm')
                            ->where('id', '1')
                            ->first();
                            
                $getFcmKey = $getFcm->driver_server_key;
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
                   $results = json_decode($result);
             
             
        	$message = array('status'=>'1', 'message'=>'order is confirmed');
	        return $message;
              }
    	else{
    		$message = array('status'=>'0', 'message'=>'something went wrong');
	        return $message;
    	} 
    }
    else{
        	$message = array('status'=>'0', 'message'=>'No Delivery Boy in Your City');
	        return $message;
    }
    }


}
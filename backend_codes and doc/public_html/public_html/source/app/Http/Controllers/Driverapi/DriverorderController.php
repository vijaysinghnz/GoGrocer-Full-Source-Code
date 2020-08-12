<?php

namespace App\Http\Controllers\Driverapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\SendMail;
use App\Traits\SendSms;

class DriverorderController extends Controller
{
    use SendMail;
    use SendSms;
    public function completed_orders(Request $request)
     {
         
        $dboy_id = $request->dboy_id;
    	 		   
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->join('store', 'orders.store_id', '=', 'store.store_id')
             ->join('address', 'orders.address_id','=','address.address_id')
             ->join('delivery_boy', 'orders.dboy_id', '=','delivery_boy.dboy_id')
             ->select('orders.order_status','orders.cart_id','users.user_name', 'users.user_phone', 'orders.delivery_date', 'orders.total_price','orders.delivery_charge','orders.rem_price','orders.payment_status','delivery_boy.boy_name','delivery_boy.boy_phone','orders.time_slot', 'store.address as store_address', 'store.store_name','store.phone_number','store.lat as store_lat','store.lng as store_lng','address.lat as userlat', 'address.lng as userlng', 'delivery_boy.lat as dboy_lat', 'delivery_boy.lng as dboy_lng', 'address.receiver_name', 'address.receiver_phone', 'address.city','address.society','address.house_no','address.landmark','address.state')
             ->where('orders.order_status' , 'completed')
             ->where('orders.dboy_id',$dboy_id)
             ->orderBy('orders.delivery_date', 'desc')
             ->get();
       
       if(count($ord)>0){
      foreach($ord as $ords){
             $cart_id = $ords->cart_id;    
         $details  =   DB::table('store_orders')
    	                ->join('product_varient', 'store_orders.varient_id', '=', 'product_varient.varient_id')
    	                ->join('product','product_varient.product_id', '=', 'product.product_id')
    	                ->select('product.product_name','product_varient.price','product_varient.mrp','product_varient.unit','product_varient.quantity','product_varient.varient_image','product_varient.description','store_orders.varient_id','store_orders.store_order_id','store_orders.qty', DB::raw('SUM(store_orders.qty) as total_items'))
    	               ->where('store_orders.order_cart_id',$cart_id)
    	               ->where('store_orders.store_approval',1)
    	               ->groupBy('product.product_name','product_varient.price','product_varient.mrp','product_varient.unit','product_varient.quantity','product_varient.varient_image','product_varient.description','store_orders.varient_id','store_orders.store_order_id','store_orders.qty')
    	               ->get(); 
                  
        
        $data[]=array('user_address'=>$ords->house_no.','.$ords->society.','.$ords->city.','.$ords->landmark.','.$ords->state ,'order_status'=>$ords->order_status,'store_name'=>$ords->store_name, 'store_lat'=>$ords->store_lat, 'store_lng'=>$ords->store_lng, 'store_address'=>$ords->store_address, 'user_lat'=>$ords->userlat, 'user_lng'=>$ords->userlng, 'dboy_lat'=>$ords->dboy_lat, 'dboy_lng'=>$ords->dboy_lng, 'cart_id'=>$cart_id,'user_name'=>$ords->user_name, 'user_phone'=>$ords->user_phone, 'remaining_price'=>$ords->rem_price,'delivery_boy_name'=>$ords->boy_name,'delivery_boy_phone'=>$ords->boy_phone,'delivery_date'=>$ords->delivery_date,'time_slot'=>$ords->time_slot,'order_details'=>$details); 
        }
        }
        else{
            $data[]=array('order_details'=>'no orders found');
        }
        return $data;     
    }       
    
    
    
 public function ordersfortoday(Request $request)
     {
         $date = date('Y-m-d');
        $dboy_id = $request->dboy_id;
    	 		   
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->join('store', 'orders.store_id', '=', 'store.store_id')
             ->join('address', 'orders.address_id','=','address.address_id')
             ->join('delivery_boy', 'orders.dboy_id', '=','delivery_boy.dboy_id')
             ->select('orders.order_status','orders.cart_id','users.user_name', 'users.user_phone', 'orders.delivery_date', 'orders.total_price','orders.delivery_charge','orders.rem_price','orders.payment_status','orders.payment_method','delivery_boy.boy_name','delivery_boy.boy_phone','orders.time_slot', 'store.address as store_address', 'store.store_name','store.phone_number','store.lat as store_lat','store.lng as store_lng','address.lat as userlat', 'address.lng as userlng', 'delivery_boy.lat as dboy_lat', 'delivery_boy.lng as dboy_lng', 'address.receiver_name', 'address.receiver_phone', 'address.city','address.society','address.house_no','address.landmark','address.state')
             ->where('orders.order_status','!=', 'completed')
             ->where('orders.store_id','!=',0)
             ->where('orders.dboy_id',$dboy_id)
             ->where('orders.delivery_date', $date)
             ->orderBy('orders.time_slot', 'ASC')
             ->get();
       
       if(count($ord)>0){
      foreach($ord as $ords){
             $cart_id = $ords->cart_id;    
         $details  =   DB::table('store_orders')
    	                ->join('product_varient', 'store_orders.varient_id', '=', 'product_varient.varient_id')
    	                ->join('product','product_varient.product_id', '=', 'product.product_id')
    	                ->select('product.product_name','product_varient.price','product_varient.mrp','product_varient.unit','product_varient.quantity','product_varient.varient_image','product_varient.description','store_orders.varient_id','store_orders.store_order_id','store_orders.qty',DB::raw('SUM(store_orders.qty) as total_items'))
    	                ->groupBy('product.product_name','product_varient.price','product_varient.mrp','product_varient.unit','product_varient.quantity','product_varient.varient_image','product_varient.description','store_orders.varient_id','store_orders.store_order_id','store_orders.qty')
    	               ->where('store_orders.order_cart_id',$cart_id)
    	               ->where('store_orders.store_approval',1)
    	               ->sum('store_orders.qty'); 
                  
        
        $data[]=array('payment_method'=>$ords->payment_method,'user_address'=>$ords->house_no.','.$ords->society.','.$ords->city.','.$ords->landmark.','.$ords->state ,'order_status'=>$ords->order_status,'store_name'=>$ords->store_name, 'store_lat'=>$ords->store_lat, 'store_lng'=>$ords->store_lng, 'store_address'=>$ords->store_address, 'user_lat'=>$ords->userlat, 'user_lng'=>$ords->userlng, 'dboy_lat'=>$ords->dboy_lat, 'dboy_lng'=>$ords->dboy_lng, 'cart_id'=>$cart_id,'user_name'=>$ords->user_name, 'user_phone'=>$ords->user_phone, 'remaining_price'=>$ords->rem_price,'delivery_boy_name'=>$ords->boy_name,'delivery_boy_phone'=>$ords->boy_phone,'delivery_date'=>$ords->delivery_date,'time_slot'=>$ords->time_slot,'total_items'=>$details); 
        }
        }
        else{
            $data[]=array('order_details'=>'no orders found');
        }
        return $data;     
    }      
    
    
    
     public function ordersfornextday(Request $request)
     {
         $date = date('Y-m-d');
         $day = 1;
         $next_date = date('Y-m-d', strtotime($date.' + '.$day.' days'));
         $dboy_id = $request->dboy_id;
    	 		   
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->join('store', 'orders.store_id', '=', 'store.store_id')
             ->join('address', 'orders.address_id','=','address.address_id')
             ->join('delivery_boy', 'orders.dboy_id', '=','delivery_boy.dboy_id')
             ->select('orders.order_status','orders.cart_id','users.user_name', 'users.user_phone', 'orders.delivery_date', 'orders.total_price','orders.delivery_charge','orders.rem_price','orders.payment_status','orders.payment_method','delivery_boy.boy_name','delivery_boy.boy_phone','orders.time_slot', 'store.address as store_address', 'store.store_name','store.phone_number','store.lat as store_lat','store.lng as store_lng','address.lat as userlat', 'address.lng as userlng', 'delivery_boy.lat as dboy_lat', 'delivery_boy.lng as dboy_lng', 'address.receiver_name', 'address.receiver_phone', 'address.city','address.society','address.house_no','address.landmark','address.state','store.phone_number')
             ->where('orders.order_status','!=', 'completed')
             ->where('orders.store_id','!=',0)
             ->where('orders.dboy_id',$dboy_id)
             ->whereDate('orders.delivery_date', $next_date)
             ->orderBy('orders.time_slot', 'ASC')
             ->get();
       
       if(count($ord)>0){
      foreach($ord as $ords){
             $cart_id = $ords->cart_id;    
         $details  =   DB::table('store_orders')
    	                ->join('product_varient', 'store_orders.varient_id', '=', 'product_varient.varient_id')
    	                ->join('product','product_varient.product_id', '=', 'product.product_id')
    	                ->select('product.product_name','product_varient.price','product_varient.mrp','product_varient.unit','product_varient.quantity','product_varient.varient_image','product_varient.description','store_orders.varient_id','store_orders.store_order_id','store_orders.qty',DB::raw('SUM(store_orders.qty) as total_items'))
    	                ->groupBy('product.product_name','product_varient.price','product_varient.mrp','product_varient.unit','product_varient.quantity','product_varient.varient_image','product_varient.description','store_orders.varient_id','store_orders.store_order_id','store_orders.qty')
    	               ->where('store_orders.order_cart_id',$cart_id)
    	               ->where('store_orders.store_approval',1)
    	               ->sum('store_orders.qty');
       
        $data[]=array('payment_method'=>$ords->payment_method,'user_address'=>$ords->house_no.','.$ords->society.','.$ords->city.','.$ords->landmark.','.$ords->state , 'order_status'=>$ords->order_status,'store_name'=>$ords->store_name,'store_phone'=>$ords->phone_number, 'store_lat'=>$ords->store_lat, 'store_lng'=>$ords->store_lng, 'store_address'=>$ords->store_address, 'user_lat'=>$ords->userlat, 'user_lng'=>$ords->userlng, 'dboy_lat'=>$ords->dboy_lat, 'dboy_lng'=>$ords->dboy_lng, 'cart_id'=>$cart_id,'user_name'=>$ords->user_name, 'user_phone'=>$ords->user_phone, 'remaining_price'=>$ords->rem_price,'delivery_boy_name'=>$ords->boy_name,'delivery_boy_phone'=>$ords->boy_phone,'delivery_date'=>$ords->delivery_date,'time_slot'=>$ords->time_slot,'total_items'=>$details); 
        }
        }
        else{
            $data[]=array('order_details'=>'no orders found');
        }
        return $data;     
    }      
 
 
 
 
 
 
            
  public function delivery_out(Request $request)
    {
       $cart_id= $request->cart_id;
       $ord = DB::table('orders')
            ->where('cart_id',$cart_id)
            ->first();
        $user_id=$ord->user_id;    
       $var= DB::table('store_orders')
           ->where('order_cart_id', $cart_id)
           ->get();
        $price2=0;
        $ph = DB::table('users')
                  ->select('user_phone','wallet')
                  ->where('user_id',$ord->user_id)
                  ->first();
        $user_phone = $ph->user_phone;   
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
        $currency = DB::table('currency')
                  ->first();
        $apppp = DB::table('tbl_web_setting')
                  ->first();          
       $status = 'Out_For_Delivery';
       $update= DB::table('orders')
              ->where('cart_id',$cart_id)
              ->update(['order_status'=>$status]);
              
        if($update){
            
               
            $sms = DB::table('notificationby')
                       ->select('sms','app')
                       ->where('user_id',$ord->user_id)
                       ->first();
            $sms_status = $sms->sms;
            $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
            $api_key = $sms_api_key->api_key;
            $sender_id = $sms_api_key->sender_id;
                if($sms_status == 1){
                $successmsg = $this->delout($cart_id, $prod_name, $price2,$currency,$ord,$user_phone);
                }
                
                //////send app notification////
                if($sms->app == 1){
                    if($ord->payment_method=="COD" || $ord->payment_method=="cod"){
                $notification_title = "Out For Delivery";
                $notification_text = "Out For Delivery: Your order id #".$cart_id." contains of " .$prod_name." of price ".$currency->currency_sign." ".$price2. " is Out For Delivery.Get ready with ".$currency->currency_sign." ".$ord->rem_price. " cash.";
                
                $date = date('d-m-Y');
        
        
                $getDevice = DB::table('users')
                         ->where('user_id', $user_id)
                        ->select('device_id')
                        ->first();
                $created_at = Carbon::now();
        
                if($getDevice){
                
                
                $getFcm = DB::table('fcm')
                            ->where('id', '1')
                            ->first();
                            
                $getFcmKey = $getFcm->server_key;
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
                    
             
                $dd = DB::table('user_notification')
                    ->insert(['user_id'=>$user_id,
                     'noti_title'=>$notification_title,
                     'noti_message'=>$notification_text]);
                    
                $results = json_decode($result);
                }  
                    }
                    else{
                        
                        $notification_title = "Out For Delivery";
                        $notification_text = "Out For Delivery: Your order id #".$cart_id." contains of " .$prod_name." of price " .$currency->currency_sign." ".$price2. " is Out For Delivery.Get ready.";
                        $date = date('d-m-Y');
                        $getDevice = DB::table('users')
                                 ->where('user_id', $user_id)
                                ->select('device_id')
                                ->first();
                        $created_at = Carbon::now();
                        if($getDevice){
                        $getFcm = DB::table('fcm')
                                    ->where('id', '1')
                                    ->first();
                                    
                        $getFcmKey = $getFcm->server_key;
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
                        $dd = DB::table('user_notification')
                            ->insert(['user_id'=>$user_id,
                             'noti_title'=>$notification_title,
                             'noti_message'=>$notification_text]);
                            
                        $results = json_decode($result);
                        }
                    }
                }
                      /////send mail
            $email = DB::table('notificationby')
                   ->select('email')
                   ->where('user_id',$ord->user_id)
                   ->first();
            $email_status = $email->email; 
            $rem_price = $ord->rem_price;
            if($email_status == 1){
                if($ord->payment_method=="COD" || $ord->payment_method=="cod"){
                    $q = DB::table('users')
                              ->select('user_email','user_name')
                              ->where('user_id',$ord->user_id)
                              ->first();
                    $user_email = $q->user_email;   
                    $user_name = $q->user_name;
                      $successmail = $this->coddeloutMail($cart_id, $prod_name, $price2,$user_email, $user_name,$rem_price);
                    }
                    else{
                    $q = DB::table('users')
                              ->select('user_email','user_name')
                              ->where('user_id',$ord->user_id)
                              ->first();
                    $user_email = $q->user_email;   
                    $user_name = $q->user_name;
                         $successmail = $this->deloutMail($cart_id, $prod_name, $price2,$user_email, $user_name,$rem_price);
                    }
               }
    	   $message = array('status'=>'1', 'message'=>'out for delivery');
        	return $message;
    	          }          
            else{
             $message = array('status'=>'0', 'message'=>'something went wrong');
        	return $message;
       }       
              
    }

    
    public function delivery_completed(Request $request)
    {
       $cart_id= $request->cart_id;
       $currency = DB::table('currency')
            ->first();
        $ord = DB::table('orders')
            ->where('cart_id',$cart_id)
            ->first();
          $user_id = $ord->user_id;  
           if($request->user_signature){
                    $user_signature = $request->user_signature;
                    $user_signature = str_replace('data:image/png;base64,', '', $user_signature);
                    $fileName = date('dmyHis').'user_signature'.'.'.'png';
                    $fileName = str_replace(" ", "-", $fileName);
                    $pth = str_replace("/source/public", "",public_path());
                    \File::put($pth. '/images/user/signature/' . $fileName, base64_decode($user_signature));
                    $user_signature ='/images/user/signature/'.$fileName;
                }
            else{
                $user_signature = "N/A";
            }    
       $var= DB::table('store_orders')
           ->where('order_cart_id', $cart_id)
           ->get();
        $price2=0;
        $ph = DB::table('users')
                  ->select('user_phone','wallet')
                  ->where('user_id',$ord->user_id)
                  ->first();
        $user_phone = $ph->user_phone;   
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
         $apppp = DB::table('tbl_web_setting')
                  ->first();  
       $status = 'Completed';
       $update= DB::table('orders')
              ->where('cart_id',$cart_id)
              ->update(['order_status'=>$status,'user_signature'=>$user_signature]);
              
        if($update){
                   
            $sms = DB::table('notificationby')
                       ->select('sms','app')
                       ->where('user_id',$ord->user_id)
                       ->first();
            $sms_status = $sms->sms;
            $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
            $api_key = $sms_api_key->api_key;
            $sender_id = $sms_api_key->sender_id;
                if($sms_status == 1){
                    $successmsg = $this->delcomsms($cart_id, $prod_name, $price2,$currency,$user_phone); 
                   
                }
                ////send notification to app///
                if($sms->app == 1){
                $notification_title = "Order Delivered";
                $notification_text = "Delivery Completed: Your order id #".$cart_id." contains of " .$prod_name." of price ".$currency->currency_sign." ".$price2." is Delivered Successfully.";
                
                $date = date('d-m-Y');
        
        
                $getDevice = DB::table('users')
                         ->where('user_id', $user_id)
                        ->select('device_id')
                        ->first();
                $created_at = Carbon::now();
        
                if($getDevice){
                
                
                $getFcm = DB::table('fcm')
                            ->where('id', '1')
                            ->first();
                            
                $getFcmKey = $getFcm->server_key;
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
                    
             
                $dd = DB::table('user_notification')
                    ->insert(['user_id'=>$user_id,
                     'noti_title'=>$notification_title,
                     'noti_message'=>$notification_text]);
                    
                $results = json_decode($result);
                }
                }   
            /////send mail
            $email = DB::table('notificationby')
                   ->select('email')
                   ->where('user_id',$ord->user_id)
                   ->first();
            $email_status = $email->email;       
            if($email_status == 1){
                    $q = DB::table('users')
                              ->select('user_email','user_name')
                              ->where('user_id',$ord->user_id)
                              ->first();
                    $user_email = $q->user_email;             
                    $user_name =$q->user_name;
                    $successmail = $this->delcomMail($cart_id, $prod_name, $price2,$user_email,$user_name); 
               }
    	   $message = array('status'=>'1', 'message'=>'Delivery Completed');
        	return $message;
    	          }          
            else{
             $message = array('status'=>'0', 'message'=>'something went wrong');
        	return $message;
       }       
              
    }



}
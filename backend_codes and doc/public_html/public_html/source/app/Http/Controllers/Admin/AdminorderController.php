<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Traits\SendMail;
use App\Traits\SendSms;

class AdminorderController extends Controller
{
    use SendMail;
    use SendSms;
    
     public function admin_com_orders(Request $request)
    {
         $title = "Completed Order section";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
                
        $ord =DB::table('orders')
             ->join('store','orders.store_id', '=', 'store.store_id')
             ->join('delivery_boy','orders.dboy_id', '=', 'delivery_boy.dboy_id')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->orderBy('orders.delivery_date','DESC')
             ->where('order_status', 'completed')
             ->orWhere('order_status', 'Completed')
             ->paginate(10);
             
         $details  =   DB::table('orders')
    	                ->join('store_orders', 'orders.cart_id', '=', 'store_orders.order_cart_id') 
    	               ->where('store_orders.store_approval',1)
    	               ->get();         
                
       return view('admin.all_orders.com_orders', compact('title','logo','ord','details','admin'));         
    }
    
    
    
      public function admin_can_orders(Request $request)
    {
         $title = "Cancelled Order section";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
                
        $ord =DB::table('orders')
             ->leftjoin('store','orders.store_id', '=', 'store.store_id')
             ->leftjoin('delivery_boy','orders.dboy_id', '=', 'delivery_boy.dboy_id')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->orderBy('orders.delivery_date','DESC')
             ->where('order_status', 'cancelled')
             ->orWhere('order_status', 'Cancelled')
             ->paginate(10);
             
         $details  =   DB::table('orders')
    	                ->join('store_orders', 'orders.cart_id', '=', 'store_orders.order_cart_id')
    	               ->where('store_orders.store_approval',1)
    	               ->get();         
                
       return view('admin.all_orders.cancelled', compact('title','logo','ord','details','admin'));         
    }
    
    
      public function admin_pen_orders(Request $request)
    {
         $title = "Pending Order section";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
                
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->orderBy('orders.delivery_date','DESC')
             ->where('orders.order_status', 'Pending')
             ->orWhere('orders.order_status', 'pending')
             ->paginate(10);
             
         $details  =   DB::table('orders')
    	                ->join('store_orders', 'orders.cart_id', '=', 'store_orders.order_cart_id') 
    	               ->where('store_orders.store_approval',1)
    	               ->get();         
                
       return view('admin.all_orders.pending', compact('title','logo','ord','details','admin'));         
    }
    
    
    public function admin_store_orders(Request $request)
    {
         $title = "Store Order section";
         $id = $request->id;
         $store = DB::table('store')
                ->where('store_id',$id)
                ->first();
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
                
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->where('orders.store_id',$store->store_id)
             ->orderBy('orders.delivery_date','ASC')
             ->where('order_status','!=', 'completed')
             ->paginate(10);
             
         $details  =   DB::table('orders')
    	                ->join('store_orders', 'orders.cart_id', '=', 'store_orders.order_cart_id') 
    	               ->where('orders.store_id',$id)
    	               ->where('store_orders.store_approval',1)
    	               ->get();         
                
       return view('admin.store.orders', compact('title','logo','ord','store','details','admin'));         
    }
    
    
    
     public function admin_dboy_orders(Request $request)
    {
         $title = "Delivery Boy Order section";
         $id = $request->id;
         $dboy = DB::table('delivery_boy')
                ->where('dboy_id',$id)
                ->first();
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
    
          $date = date('Y-m-d');
     $nearbydboy = DB::table('delivery_boy')
                ->leftJoin('orders', 'delivery_boy.dboy_id', '=', 'orders.dboy_id') 
                ->select("delivery_boy.boy_name","delivery_boy.dboy_id","delivery_boy.lat","delivery_boy.lng","delivery_boy.boy_city",DB::raw("Count(orders.order_id)as count"),DB::raw("6371 * acos(cos(radians(".$dboy->lat . ")) 
                * cos(radians(delivery_boy.lat)) 
                * cos(radians(delivery_boy.lng) - radians(" . $dboy->lng . ")) 
                + sin(radians(" .$dboy->lat. ")) 
                * sin(radians(delivery_boy.lat))) AS distance"))
               ->groupBy("delivery_boy.boy_name","delivery_boy.dboy_id","delivery_boy.lat","delivery_boy.lng","delivery_boy.boy_city")
               ->where('delivery_boy.boy_city', $dboy->boy_city)
               ->where('delivery_boy.dboy_id','!=',$dboy->dboy_id)
               ->orderBy('count')
               ->orderBy('distance')
               ->get();  
    
                
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->where('orders.dboy_id',$dboy->dboy_id)
             ->orderBy('orders.delivery_date','ASC')
             ->where('order_status','!=', 'completed')
             ->paginate(10);
             
         $details  =   DB::table('orders')
    	               ->join('store_orders', 'orders.cart_id', '=', 'store_orders.order_cart_id') 
    	               ->where('orders.dboy_id',$id)
    	               ->where('store_orders.store_approval',1)
    	               ->get();         
                
       return view('admin.d_boy.orders', compact('title','logo','ord','dboy','details','admin','nearbydboy'));         
    }
    
    
    
    public function store_cancelled(Request $request)
    {
         $title = "Store Cancelled Orders";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
                
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->join('address', 'orders.address_id', '=','address.address_id')
             ->orderBy('orders.delivery_date','ASC')
             ->where('order_status','!=', 'completed')
             ->where('order_status','!=', 'cancelled')
              ->where('payment_method','!=', NULL)
             ->where('store_id', 0)
             ->paginate(10);
             
            
        $nearbystores = DB::table('store')
                          ->get();
         
             
         $details  =   DB::table('orders')
    	                ->join('store_orders', 'orders.cart_id', '=', 'store_orders.order_cart_id') 
    	               ->where('store_orders.store_approval',1)
    	               ->get();         
                
       return view('admin.store.cancel_orders', compact('title','logo','ord','details','admin','nearbystores'));  
    }
    
    
    public function assignstore(Request $request)
    {
         $title = "Store Cancelled Orders";
         $cart_id=$request->id;
         $store = $request->store;
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
      
          $ord =DB::table('orders')
             ->where('cart_id', $cart_id)
             ->update(['store_id'=>$store, 'cancel_by_store'=>0]);
             
      
      return redirect()->back()->withSuccess('Assigned to store successfully');
    }
    
    
    
    
       public function assigndboy(Request $request)
    {
         $cart_id=$request->id;
         $d_boy = $request->d_boy;
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
      
          $ord =DB::table('orders')
             ->where('cart_id', $cart_id)
             ->update(['dboy_id'=>$d_boy]);
             
      
      return redirect()->back()->withSuccess('Assigned to Another Delivery Boy Successfully');
    }
    
    
        public function rejectorder(Request $request)
    {
         $cart_id=$request->id;
         $ord= DB::table('orders')
    	 		->where('cart_id',$cart_id)
    	 		->first();
    	 $total_price = $ord->rem_price;		
    	 $user = DB::table('users')
    	 		->where('user_id',$ord->user_id)
    	 		->first();	
    	 $wall = $user->wallet;		
    	 $bywallet = $ord->paid_by_wallet;	
    	 if($ord->payment_method != 'COD' || $ord->payment_method != 'cod'|| $ord->payment_method != 'Cod'){
    	$newwallet = $wall + $total_price + $bywallet;
    	$update = DB::table('users')
    	 		->where('user_id',$ord->user_id)
    	 		->update(['wallet'=>$newwallet]);
    	 }	
    	 else{
    	     	$newwallet = $wall + $bywallet;
    	$update = DB::table('users')
    	 		->where('user_id',$ord->user_id)
    	 		->update(['wallet'=>$newwallet]);
    	 }
    	 
         $cause = $request->cause;
         
         $checknotificationby = DB::table('notificationby')
                              ->where('user_id',$user->user_id)
                              ->first();
         if($checknotificationby->sms == 1){
         $sendmsg = $this->sendrejectmsg($cause,$user,$cart_id);
         }
         if($checknotificationby->email == 1){
         $sendmail = $this->sendrejectmail($cause,$user,$cart_id);
         }
         if($checknotificationby->app == 1){
         //////send notification to user//////////
             $notification_title = "Sorry! we are cancelling your order";
                        $notification_text = 'Hello '.$user->user_name.', We are cancelling your order ('.$cart_id.') due to following reason:  '.$cause;
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
         
          $ord =DB::table('orders')
             ->where('cart_id', $cart_id)
             ->update(['cancelling_reason'=>"Cancelled by Admin due to the following reason: ".$cause,
             'order_status'=>"cancelled"]);
         return redirect()->back()->withSuccess('Order Rejected Successfully');
    }
    
}
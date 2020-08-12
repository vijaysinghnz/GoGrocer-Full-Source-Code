<?php

namespace App\Http\Controllers\Ios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\SendSms;

class IosordersController extends Controller
{
   public function completed_orders(Request $request)
    {
      $user_id = $request->user_id;
      $completeds = DB::table('orders')
               ->leftJoin('delivery_boy', 'orders.dboy_id', '=', 'delivery_boy.dboy_id')
              ->where('orders.order_status', 'Completed')
              ->where('orders.user_id',$user_id)
              ->get();
      
      if(count($completeds)>0){
      foreach($completeds as $completed){
      $order = DB::table('store_orders')
               ->leftJoin('product_varient', 'store_orders.varient_id','=','product_varient.varient_id')
              ->select('store_orders.*','product_varient.description')
              ->where('store_orders.order_cart_id',$completed->cart_id)
              ->orderBy('store_orders.order_date', 'DESC')
              ->get();
                  
        
        $data[]=array('order_status'=>$completed->order_status, 'delivery_date'=>$completed->delivery_date, 'time_slot'=>$completed->time_slot,'payment_method'=>$completed->payment_method,'payment_status'=>$completed->payment_status,'paid_by_wallet'=>$completed->paid_by_wallet, 'cart_id'=>$completed->cart_id ,'price'=>$completed->total_price,'del_charge'=>$completed->delivery_charge,'remaining_amount'=>$completed->rem_price,'coupon_discount'=>$completed->coupon_discount,'dboy_name'=>$completed->boy_name,'dboy_phone'=>$completed->boy_phone, 'varient'=>$order); 
        }
          $data=array('status'=>'1','message'=>'orders found','data'=>$data); 
        }
        else{
            $data=array('status'=>'0','message'=>'no rders found',);
            
        }
           return $data;    
                  
                  
  }     
  
  public function ongoing(Request $request)
    {
      $user_id = $request->user_id;
      $ongoing = DB::table('orders')
             ->leftJoin('delivery_boy', 'orders.dboy_id', '=', 'delivery_boy.dboy_id')
              ->where('orders.user_id',$user_id)
              ->where('orders.order_status', '!=', 'Completed')
              ->where('orders.payment_method', '!=', NULL)
               ->get();
      
      if(count($ongoing)>0){
      foreach($ongoing as $ongoings){
      $order = DB::table('store_orders')
            ->leftJoin('product_varient', 'store_orders.varient_id','=','product_varient.varient_id')
            ->select('store_orders.*','product_varient.description')
            ->where('store_orders.order_cart_id',$ongoings->cart_id)
            ->orderBy('store_orders.order_date', 'DESC')
            ->get();
                  
        
        $data[]=array('order_status'=>$ongoings->order_status, 'delivery_date'=>$ongoings->delivery_date, 'time_slot'=>$ongoings->time_slot,'payment_method'=>$ongoings->payment_method,'payment_status'=>$ongoings->payment_status,'paid_by_wallet'=>$ongoings->paid_by_wallet, 'cart_id'=>$ongoings->cart_id ,'price'=>$ongoings->total_price,'del_charge'=>$ongoings->delivery_charge,'remaining_amount'=>$ongoings->rem_price,'coupon_discount'=>$ongoings->coupon_discount,'dboy_name'=>$ongoings->boy_name,'dboy_phone'=>$ongoings->boy_phone, 'varient'=>$order); 
        }
        $data=array('status'=>'1','message'=>'orders found','data'=>$data); 
        }
        else{
            $data=array('status'=>'0','message'=>'no rders found',);
            
        }
           return $data;      
                  
                  
  }     
  
  
}
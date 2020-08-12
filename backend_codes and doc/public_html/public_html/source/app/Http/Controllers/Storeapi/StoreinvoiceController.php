<?php

namespace App\Http\Controllers\Storeapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class StoreinvoiceController extends Controller

{
public function cart_invoice(Request $request)
     {
        $cart_id = $request->cart_id;
    	 		   
        $ord =DB::table('orders')
             ->join('users', 'orders.user_id', '=','users.user_id')
             ->join('address', 'orders.address_id','=','address.address_id')
             ->select('orders.order_id','address.receiver_name','address.receiver_phone','address.house_no','address.society','address.city','address.landmark', 'address.pincode','address.city','orders.cart_id','orders.total_price as cart_price','orders.paid_by_wallet','orders.coupon_discount','orders.rem_price','orders.delivery_charge','orders.price_without_delivery','address.state')
             ->where('orders.cart_id', $cart_id)
             ->first();
        $app = DB::table('tbl_web_setting')
        ->select('icon', 'name')
            ->first();
        $details  =   DB::table('store_orders')
    	               ->where('order_cart_id',$cart_id)
    	               ->where('store_orders.store_approval',1)
    	               ->get();

        if($ord){
            $message = array('status'=>'1', 'message'=>'Cart order found','invoice_no'=>$ord->order_id,'number'=>$ord->receiver_phone, 'Name'=>$ord->receiver_name,'address'=>$ord->house_no.','.$ord->society.','.$ord->landmark,'city'=>$ord->city.','.$ord->state,'pincode'=>$ord->pincode, 'paid_by_wallet'=>$ord->paid_by_wallet,'coupon_discount'=>$ord->coupon_discount,'price_to_pay'=>$ord->rem_price,'total_price'=>$ord->cart_price, 'price_without_delivery'=>$ord->price_without_delivery, 'delivery_charge'=>$ord->delivery_charge, 'order_details'=>$details );
            return $message;
        }
        
        else{
            $message = array('status'=>'0', 'message'=>'Cart order not found');
            return $message;
        }
    }  
}
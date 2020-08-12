<?php

namespace App\Http\Controllers\Storeapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class AmountController extends Controller
{
    public function earn(Request $request)
    {
        $store_id=$request->store_id;
        $total_earnings=DB::table('store')
           ->join('orders','store.store_id','=','orders.store_id')
           ->leftJoin('store_earning','store.store_id','=','store_earning.store_id')
           ->select('store_earning.paid',DB::raw('SUM(orders.total_price)-SUM(orders.total_price)*(store.admin_share)/100 as sumprice'))
           ->groupBy('store_earning.paid','store.admin_share')
           ->where('orders.order_status','Completed')
           ->where('store.store_id',$store_id)
           ->first();
       	                     
        if($total_earnings){
        	$message = array('status'=>'1', 'message'=>'Store Earnings and paid amount', 'data'=>$total_earnings);
	        return $message;
              }
    	else{
    		$message = array('status'=>'0', 'message'=>'no store found', 'data'=>[]);
	        return $message;
    	}
    }
}
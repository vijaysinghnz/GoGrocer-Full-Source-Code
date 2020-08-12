<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class StoreearningsController extends Controller
{
    public function finance(Request $request)
    {
        $title = "Product section";
         $email=Session::get('bamaStore');
    	 $store= DB::table('store')
    	 		   ->where('email',$email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        
         $total_earnings=DB::table('store')
                           ->join('orders','store.store_id','=','orders.store_id')
                           ->leftJoin('store_earning','store.store_id','=','store_earning.store_id')
                           ->select('store_earning.paid',DB::raw('SUM(orders.total_price)-SUM(orders.total_price)*(store.admin_share)/100 as sumprice'))
                           ->where('orders.order_status','Completed')
                           ->where('store.store_id',$store->store_id)
                           ->first();
                        
    	return view('admin.store.finance', compact('title',"admin", "logo","total_earnings"));
    }
    
    
       
}

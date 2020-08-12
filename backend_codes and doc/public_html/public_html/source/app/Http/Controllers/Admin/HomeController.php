<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class HomeController extends Controller
{
    public function adminHome(Request $request)
    {
        $title = "Dashboard";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        
            $total_earnings=DB::table('orders')
                           ->where('order_status','Completed')
                           ->sum('total_price');
                           
            $completed_orders =  DB::table('orders')
                           ->where('order_status','Completed')
                           ->count();
                           
            $app_users =DB::table('users')
                       ->count();
            
            $stores = DB::table('store')
                       ->count();          
        
        
            $pending =   DB::table('orders')
                           ->where('order_status','Pending')
                           ->count();
                           
                           
            $cancelled = DB::table('orders')
                           ->where('order_status','Cancelled')
                           ->count();   
                           
                           
            $delivery_boys = DB::table('delivery_boy')
                           ->count();
                           
            $city = DB::table('city')
                   ->count();
    	return view('admin.home', compact('title',"admin", "logo","total_earnings","completed_orders","app_users","stores","pending","cancelled","delivery_boys","city"));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class Minimum_Max_OrderController extends Controller
{
    public function orderlist(Request $request)
    {
         $title = "Minimum Maximum cart value settings";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        
        $city = DB::table('minimum_maximum_order_value')
                ->get();
                
        return view('admin.city.citylist', compact('title','city','admin','logo'));    
        
        
    }

    
    public function orderedit(Request $request)
    {
         $title = "Home";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $min_max_id = $request->min_max_id;
        
        $city = DB::table('minimum_maximum_order_value')
                
                ->first();
                
        return view('admin.order_amount.editorderamount', compact('title','city','logo','admin'));    
        
        
    }
    
    public function amountupdate(Request $request)
    {
        $title = "Home";
        $min_max_id = $request->min_max_id;
        $min_value = $request->min_value;
         $max_value = $request->max_value;
        
        $this->validate(
            $request,
                [
                    
                    'min_value'=>'required',
                    'max_value'=>'required',
                ],
                [
                    
                    'min_value.required'=>'Min Value Required',
                    'max_value.required'=>'Max Value Required',

                ]
        );
        
    	 $insert = DB::table('minimum_maximum_order_value')
    	            
                    ->update([
                        'min_value'=>$min_value,
                         'max_value'=>$max_value,
                        ]);
     
         return redirect()->back()->withSuccess('Updated Successfully');

    }
    

}
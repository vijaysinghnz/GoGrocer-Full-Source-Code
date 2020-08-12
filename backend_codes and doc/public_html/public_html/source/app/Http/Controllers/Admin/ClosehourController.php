<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class ClosehourController extends Controller
{

    public function closehour(Request $request)
    {
        $title = "Home";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $closing_hrs_id = $request->closing_hrs_id;
        
        $city = DB::table('closing_hours')
                
                ->first();
                
                
        return view('admin.time_slot.closehrsadd', compact('title',"city",'logo','admin'));    
        
        
    }

    
    public function closehrsupdate(Request $request)
    {
        $title = "Home";
        // $closing_hrs_id = $request->closing_hrs_id;
        $open_hrs = $request->date;
        $start_hrs = $request->open_hrs;
        $end_hrs = $request->close_hrs;
        

    	 $insert = DB::table('closing_hours')
    	           // ->where('closing_hrs_id',$closing_hrs_id)
                    ->update([
                        'date'=>$open_hrs,
                        'start_hrs'=>$start_hrs,
                        'end_hrs'=>$end_hrs
                        ]);
     
        return redirect()->back()->withSuccess('Updated Successfully');

    }

}
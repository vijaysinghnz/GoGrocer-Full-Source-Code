<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class TimeSlotController extends Controller
{

    public function timeslot(Request $request)
    {
         $title = "Home";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $time_slot_id = $request->time_slot_id;
        
        $city = DB::table('time_slot')
                
                ->first();
                
                
        return view('admin.time_slot.time_slotadd', compact('title',"city",'admin','logo'));    
        
        
    }

    
    public function timeslotupdate(Request $request)
    {
        $title = "Home";
        // $time_slot_id = $request->time_slot_id;
        $open_hrs = $request->open_hrs;
        $close_hrs = $request->close_hrs;
        $interval = $request->interval;
        

    	 $insert = DB::table('time_slot')
    	           // ->where('time_slot_id',$time_slot_id)
                    ->update([
                        'open_hour'=>$open_hrs,
                        'close_hour'=>$close_hrs,
                        'time_slot'=>$interval
                        ]);
     
         return redirect()->back()->withSuccess('Updated Successfully');

    }

}
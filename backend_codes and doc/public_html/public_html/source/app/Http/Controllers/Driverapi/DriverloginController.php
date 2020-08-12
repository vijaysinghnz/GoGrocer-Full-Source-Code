<?php

namespace App\Http\Controllers\Driverapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class DriverloginController extends Controller
{
 public function driver_login(Request $request)
    
     {
    	$phone = $request->phone;
    	$password = $request->password;
    	$device_id = $request->device_id;
    	$checkdriver1 = DB::table('delivery_boy')
    					->where('boy_phone', $phone)
    					->first();
    if($checkdriver1){					
    	$checkdriver = DB::table('delivery_boy')
    					->where('boy_phone', $phone)
    					->where('password', $password)
    					->first();

    	if($checkdriver){
    		   $updateDeviceId = DB::table('delivery_boy')
    		                       ->where('boy_phone', $phone)
    		                        ->update(['device_id'=>$device_id]);
    		                       
    		                        
    			$message = array('status'=>'1', 'message'=>'login successfully', 'data'=>[$checkdriver]);
	        	return $message;
    	   }	   
    	
    	
    	else{
    		$message = array('status'=>'0', 'message'=>'Wrong Password', 'data'=>[]);
	        return $message;
    	}
    }
    else{
        	$message = array('status'=>'0', 'message'=>'Driver Not Registered', 'data'=>[]);
	        return $message;
    }
    }
    
    
    
    
    public function driverprofile(Request $request)
    {   
        $boy_id = $request->dboy_id;
         $diver=  DB::table('delivery_boy')
                ->where('dboy_id', $boy_id )
                ->first();
                        
    if($diver){
        	$message = array('status'=>'1', 'message'=>'Delivery Boy Profile', 'data'=>$diver);
	        return $message;
              }
    	else{
    		$message = array('status'=>'0', 'message'=>'Delivery Boy not found', 'data'=>[]);
	        return $message;
    	}
        
    }
}
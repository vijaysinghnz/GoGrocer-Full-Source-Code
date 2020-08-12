<?php

namespace App\Http\Controllers\Driverapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class MapController extends Controller
{
   public function map_api_key(Request $request)
    { 
         
        $map= DB::table('map_API') 
               ->first();
               
        if($map){
            $message = array('status'=>'1', 'message'=>'Map API Key','data'=>$map);
        	return $message;
        }  
        else{
            $message = array('status'=>'0', 'message'=>'No ratings yet');
        	return $message;
        }
               
    }
}
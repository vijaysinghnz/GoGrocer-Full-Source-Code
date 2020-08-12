<?php

namespace App\Http\Controllers\Driverapi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class RatingController extends Controller
{
   public function avg_rating(Request $request)
    { 
        $dboy_id = $request->dboy_id;
         
        $review= DB::table('delivery_rating') 
               ->where('dboy_id',$dboy_id)
               ->get();
               
        $re= DB::table('delivery_rating') 
               ->where('dboy_id',$dboy_id)
               ->avg('rating');       
               
        if($review){
            $message = array('status'=>'1', 'message'=>'ratings','avg_rating'=>$re, 'data'=>$review);
        	return $message;
        }  
        else{
            $message = array('status'=>'0', 'message'=>'No ratings yet');
        	return $message;
        }
               
    }
}
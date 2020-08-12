<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class RatingController extends Controller
{
   public function review_on_delivery(Request $request)
    { 
        $user_id = $request->user_id;
        $cart_id = $request->cart_id;
        $rating = $request->rating;
        $description=$request->description;
        $check = DB::table('orders')
               ->where('cart_id',$cart_id)
               ->first();
         
        $review= DB::table('delivery_rating') 
               ->insert(['cart_id'=>$cart_id,
               'user_id'=>$user_id,
               'rating'=>$rating,
               'dboy_id'=>$check->dboy_id,
               'description'=>$description]);
               
        if($review){
            $message = array('status'=>'1', 'message'=>'reviewed successfully');
        	return $message;
        }  
        else{
            $message = array('status'=>'0', 'message'=>'Please try again later');
        	return $message;
        }
               
    }
}
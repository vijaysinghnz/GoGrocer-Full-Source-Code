<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class RewardController extends Controller
{
   public function redeem(Request $request)
    {  
        $user_id = $request->user_id;
        $rewards = DB::table('users')
                ->select('rewards','wallet')
                ->where('user_id',$user_id)
                ->first();
        $rew = $rewards->rewards;
        if($rew <= 0){
             $message = array('status'=>'0', 'message'=>'You have not get any rewards yet', 'data'=>[]);
            return $message;
        }
        else{
        $redeem_points = DB::table('reedem_values')
               ->select('value','reward_point')
               ->first();
        $new = $rew * $redeem_points->value/$redeem_points->reward_point;
        $newwallet = $new + $rewards->wallet;
        $upuser =  DB::table('users')
                ->where('user_id',$user_id)
                ->update(['rewards'=>0,
                'wallet'=>$newwallet]);
         if($upuser){
            $message = array('status'=>'1', 'message'=>'Rewards Redeemed');
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Something Went Wrong', 'data'=>[]);
            return $message;
        }
    }
    }
    
    
     public function rewardvalues(Request $request)
    {  
      
        $redeem_points = DB::table('reedem_values')
               ->first();
    
         if($redeem_points){
            $message = array('status'=>'1', 'message'=>'Rewards Point Values', 'data'=>$redeem_points);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Something Went Wrong', 'data'=>[]);
            return $message;
        }
    }
    
    
     public function rewardlines(Request $request)
    {  
      
        $cart_id = $request->cart_id;
        $check = DB::table('orders')
               ->where('cart_id',$cart_id)
               ->first();
        $p=$check->total_price;
        $currency = DB::table('currency')
                  ->first();
        $cc = DB::table('reward_points')
            ->where('min_cart_value',"<=",$p)
            ->orderBy("min_cart_value", "DESC")
            ->first();
          $text1 = "You will get ".$cc->reward_point." reward points with successfull checkout of this order.";
         
          $cc2 = DB::table('reward_points')
            ->where('min_cart_value',">",$cc->min_cart_value)
            ->orderBy("min_cart_value", "ASC")
            ->first();
            
         if($cc2){
            $nu = $cc2->min_cart_value - $p;
              
            $text2="Add items of ".$currency->currency_sign." ".$nu." more to get ".$cc2->reward_point." reward points."; 
         }  
         else{
             $text2 = "";
         }
    
         if($cc){
            $message = array('status'=>'1', 'message'=>'Checkout Rewards lines', 'line1'=>$text1, 'line2'=>$text2);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'no rewards with this order', 'data'=>[]);
            return $message;
        }
    }
    
}
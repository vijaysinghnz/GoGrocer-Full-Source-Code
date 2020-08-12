<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class CartvalueController extends Controller
{
   public function minmax(Request $request)
    {  
        $minmax = DB::table('minimum_maximum_order_value')
                ->first();
        
         if($minmax){
            $message = array('status'=>'1', 'message'=>'Min/Max Cart Value', 'data'=>$minmax);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Min/Max Cart Value not found', 'data'=>[]);
            return $message;
        }
    }
}
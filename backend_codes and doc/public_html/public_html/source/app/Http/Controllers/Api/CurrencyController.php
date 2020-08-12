<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class CurrencyController extends Controller
{
   public function currency(Request $request)
    {  
        $currency = DB::table('currency')
                ->first();
        
         if($currency){
            $message = array('status'=>'1', 'message'=>'currency', 'data'=>$currency);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'No currency Found', 'data'=>[]);
            return $message;
        }
    }
}
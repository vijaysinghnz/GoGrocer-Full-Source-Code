<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
   public function pymnt_via(Request $request)
    {  
        $paymentvia = DB::table('payment_via')
                   ->first();
                   
        if($paymentvia)   { 
            $message = array('status'=>'1', 'message'=>'Payment Via', 'data'=>$paymentvia);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }
    }
}
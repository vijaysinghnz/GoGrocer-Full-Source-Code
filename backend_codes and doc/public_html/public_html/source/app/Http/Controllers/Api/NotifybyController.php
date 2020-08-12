<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class NotifybyController extends Controller
{
   public function notifyby(Request $request)
    {  
        $user_id = $request->user_id;
        $notifyby = DB::table('notificationby')
                ->where('user_id',$user_id)
                ->first();
        
         if($notifyby){
            $message = array('status'=>'1', 'message'=>'Notifyby', 'data'=>$notifyby);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Not Found', 'data'=>[]);
            return $message;
        }
    }
    
    
    
    public function updatenotifyby(Request $request)
    {  
        $user_id = $request->user_id;
        $sms = $request->sms;
        $email = $request->email;
        $app = $request->app;
        $notifyby = DB::table('notificationby')
                ->where('user_id',$user_id)
                ->update(['sms'=>$sms,
                'email'=>$email,
                'app'=>$app]);
        
         if($notifyby){
            $message = array('status'=>'1', 'message'=>'Updated Successfully', 'data'=>$notifyby);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Already Updated', 'data'=>[]);
            return $message;
        }
    }
}
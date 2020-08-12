<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class UsernotificationController extends Controller
{
   public function notificationlist(Request $request)
    {  
        $user = $request->user_id;
        $notifyby = DB::table('user_notification')
                ->where('user_id',$user)
                ->orderBy('noti_id')
                ->get();
        
         if($notifyby){
            $message = array('status'=>'1', 'message'=>'Notification Listaa', 'data'=>$notifyby);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Not Found', 'data'=>[]);
            return $message;
        }
    }
    
    public function read_by_user(Request $request)
    {  
        $noti_id = $request->noti_id;
        $notifyby = DB::table('user_notification')
                ->where('noti_id',$noti_id)
                ->update(['read_by_user'=> 1]);
                
         if($notifyby){
            $message = array('status'=>'1', 'message'=>'Read by user');
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Not Found', 'data'=>[]);
            return $message;
        }
    }
    
     public function mark_all_as_read(Request $request)
    {  
        $user_id = $request->user_id;
        $notifyby = DB::table('user_notification')
                ->where('user_id',$user_id)
                ->update(['read_by_user'=> 1]);
                
         if($notifyby){
            $message = array('status'=>'1', 'message'=>'Marked All as Read');
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Not Found', 'data'=>[]);
            return $message;
        }
    }
    
    
     public function delete_all(Request $request)
    {  
        $user_id = $request->user_id;
        $notifyby = DB::table('user_notification')
                ->where('user_id',$user_id)
                ->delete();
                
         if($notifyby){
            $message = array('status'=>'1', 'message'=>'All Notifications are Deleted');
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Not Found', 'data'=>[]);
            return $message;
        }
    }
}

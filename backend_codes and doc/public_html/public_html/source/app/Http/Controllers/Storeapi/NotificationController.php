<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class NotificationController extends Controller
{
   public function notificationlist(Request $request)
    {  
        $store_id = $request->store_id;
        $notifyby = DB::table('store_notification')
                ->where('store_id',$store_id)
                ->orderBy('not_id')
                ->get();
        
         if($notifyby){
            $message = array('status'=>'1', 'message'=>'Notification List', 'data'=>$notifyby);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Not Found', 'data'=>[]);
            return $message;
        }
    }
    
    public function read_by_store(Request $request)
    {  
        $noti_id = $request->not_id;
        $notifyby = DB::table('store_notification')
                ->where('not_id',$noti_id)
                ->update(['read_by_store'=> 1]);
                
         if($notifyby){
            $message = array('status'=>'1', 'message'=>'Read by Store');
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'Not Found', 'data'=>[]);
            return $message;
        }
    }
    
     public function all_as_read(Request $request)
    {  
        $store_id = $request->store_id;
        $notifyby = DB::table('store_notification')
                ->where('store_id',$store_id)
                ->update(['read_by_store'=> 1]);
                
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
        $store_id = $request->store_id;
        $notifyby = DB::table('store_notification')
                ->where('store_id',$store_id)
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

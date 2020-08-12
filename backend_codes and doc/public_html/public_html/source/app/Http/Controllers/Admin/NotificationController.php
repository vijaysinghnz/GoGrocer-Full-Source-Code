<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function adminNotification(Request $request)
    {
        $title = "To App Users";
        $admin_email=Session::get('bamaAdmin');
         $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();	

        return view('admin.settings.notification',compact("title","admin","logo","admin"));
    }

    public function adminNotificationSend(Request $request)
    {
        $this->validate(
            $request,
                [
                    'notification_title' => 'required',
                    'notification_text' => 'required',
             
                ],
                [
                    'notification_title.required' => 'Enter notification title.',
                    'notification_text.required' => 'Enter notification text.',
                ]
        );

        $notification_title = $request->notification_title;
        $notification_text = $request->notification_text;
        
        $date = date('d-m-Y');

    


            $getUser = DB::table('users')
                        ->get();

            $getDevice = DB::table('users')
                        ->where('device_id', '!=', null)
                        ->select('device_id')
                        ->groupBy('device_id')
                        ->get();
                        
        $created_at = Carbon::now();

        if(count($getDevice) == 0){
            return redirect()->back()->withErrors('something wents wrong');
        }

        
        $getFcm = DB::table('fcm')
                    ->where('id', '1')
                    ->first();
                    
        $getFcmKey = $getFcm->server_key;
        
        foreach ($getDevice as $getDevices) {
            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
            $token = $getDevices->device_id;;
            

            $notification = [
                'title' => $notification_title,
                'body' => $notification_text,
                'sound' => true,
            ];
            
            $extraNotificationData = ["message" => $notification];

            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to'        => $token, //single token
                'notification' => $notification,
                'data' => $extraNotificationData,
            ];

            $headers = [
                'Authorization: key='.$getFcmKey,
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);
        }
        $results = json_decode($result);
         foreach ($getUser as $getUsers) {
            $insertNotification = DB::table('user_notification')
                                    ->insert([
                                        'user_id'=>$getUsers->user_id,
                                        'noti_title'=>$notification_title,
                                        'noti_message'=>$notification_text,
                                      
                                    ]);
        }
        return redirect()->back()->withSuccess('notification send successfully');
    }
    
    
    
     public function Notification_to_store(Request $request)
    {
        $title = "To Store";
        $admin_email=Session::get('bamaAdmin');
         $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();	

        return view('admin.settings.notification_to_store',compact("title","admin","logo","admin"));
    }

    public function Notification_to_store_Send(Request $request)
    {
        $this->validate(
            $request,
                [
                    'notification_title' => 'required',
                    'notification_text' => 'required',
             
                ],
                [
                    'notification_title.required' => 'Enter notification title.',
                    'notification_text.required' => 'Enter notification text.',
                ]
        );

        $notification_title = $request->notification_title;
        $notification_text = $request->notification_text;
        
        $date = date('d-m-Y');

    


            $getUser = DB::table('store')
                        ->get();

            $getDevice = DB::table('store')
                        ->where('device_id', '!=', null)
                        ->select('device_id')
                        ->groupBy('device_id')
                        ->get();
                        
        $created_at = Carbon::now();

        if(count($getDevice) == 0){
            return redirect()->back()->withErrors('something wents wrong');
        }

        
        $getFcm = DB::table('fcm')
                    ->select('store_server_key')
                    ->where('id', '1')
                    ->first();
                    
        $getFcmKey = $getFcm->store_server_key;
        
        foreach ($getDevice as $getDevices) {
            $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
            $token = $getDevices->device_id;;
            

            $notification = [
                'title' => $notification_title,
                'body' => $notification_text,
                'sound' => true,
            ];
            
            $extraNotificationData = ["message" => $notification];

            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to'        => $token, //single token
                'notification' => $notification,
                'data' => $extraNotificationData,
            ];

            $headers = [
                'Authorization: key='.$getFcmKey,
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);
        }
        foreach ($getUser as $getUsers) {
            $insertNotification = DB::table('store_notification')
                                    ->insert([
                                        'store_id'=>$getUsers->store_id,
                                        'not_title'=>$notification_title,
                                        'not_message'=>$notification_text,
                                      
                                    ]);
        }
        $results = json_decode($result);

        return redirect()->back()->withSuccess('notification send to store successfully');
    }
    
    
    
    
    
    
}

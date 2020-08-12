<?php

namespace App\Traits;

use App\User;
use App\Partner;
use App\WebSetting;
use DB;
use Twilio\Rest\Client;

trait SendSms {
    public function ordersuccessfull($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_phone) {
        $getInvitationMsg = "Order Successfully Placed: Your order id #".$cart_id." contains of " .$prod_name." of price rs ".$price2. " is placed Successfully.You can expect your item(s) will be delivered on ".$delivery_date." between ".$time_slot.".";
        $smsby =  DB::table('smsby')
               ->first();
    if($smsby->status==1){       
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $user_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url="https://control.msg91.com/api/sendhttp.php";
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $user_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
    }
                
    }
         public function orderconfirmedsms($cart_id,$user_phone,$orr) {
        $getInvitationMsg = "Your Order is confirmed: Your order id #".$cart_id." is confirmed by the store.You can expect your item(s) will be delivered on ".$orr->delivery_date." (".$orr->time_slot.").";
        $smsby =  DB::table('smsby')
               ->first();
    if($smsby->status==1){       
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $user_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url="https://control.msg91.com/api/sendhttp.php";
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $user_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
    }
                
    }
     public function delout($cart_id, $prod_name, $price2,$currency,$ord,$user_phone) {
         if($ord->payment_method=="COD" || $ord->payment_method=="cod"){
                        $getInvitationMsg = "Out For Delivery: Your order id #".$cart_id." contains of " .$prod_name." of price ".$currency->currency_sign." ".$price2. " is Out For Delivery.Get ready with ".$currency->currency_sign." ". $ord->rem_price. " cash.";
            }
            else{
                $getInvitationMsg = "Out For Delivery: Your order id #".$cart_id." contains of " .$prod_name." of price " .$currency->currency_sign." ".$price2. " is Out For Delivery.Get ready."; 
            }
        $smsby =  DB::table('smsby')
               ->first();
        if($smsby->status==1){         
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $user_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url="https://control.msg91.com/api/sendhttp.php";
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $user_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
        }          
    }
    
     public function delcomsms($cart_id, $prod_name, $price2,$currency,$user_phone) {
         $getInvitationMsg = "Delivery Completed: Your order id #".$cart_id." contains of " .$prod_name." of price " .$currency->currency_sign." ".$price2. " is Delivered Successfully.";
        $smsby =  DB::table('smsby')
               ->first();
               
        if($smsby->status==1){         
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $user_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url="https://control.msg91.com/api/sendhttp.php";
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $user_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
        }          
    }
    
     public function otpmsg($otpval,$user_phone) {
        $getInvitationMsg = "Your OTP is: ".$otpval.".\nNote: Please DO NOT SHARE this OTP with anyone."; 
        $smsby =  DB::table('smsby')
               ->first();
        if($smsby->status==1){         
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $user_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url="https://control.msg91.com/api/sendhttp.php";
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $user_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
        }          
    }



//////Store Payout////////
 public function sendpayoutmsg($amt,$store_phone) {
         $getInvitationMsg = 'Amount of '.$amt.' marked paid successfully against your request.';
        $smsby =  DB::table('smsby')
               ->first();
    if($smsby->status==1){       
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $store_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url="https://control.msg91.com/api/sendhttp.php";
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $store_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
    }
                
    }
    
    //////Store Payout////////
 public function sendrejectmsg($cause,$user,$cart_id) {
         $getInvitationMsg = 'Hello '.$user->user_name.', We are cancelling your order ('.$cart_id.') due to following reason:  '.$cause;
        $smsby =  DB::table('smsby')
               ->first();
    if($smsby->status==1){       
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $user->user_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url="https://control.msg91.com/api/sendhttp.php";
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $user->user_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
    }
                
    }
    
     public function rechargesms($curr,$user_name, $add_to_wallet,$user_phone) {
        $getInvitationMsg = "Hey ".$user_name." :your wallet recharge of ".$curr->currency_sign." ".$add_to_wallet. " is successful.";
        $smsby =  DB::table('smsby')
               ->first();
    if($smsby->status==1){       
        if($smsby->msg91==1){       
         $sms_api_key=  DB::table('msg91')
    	              ->select('api_key', 'sender_id')
                      ->first();
                        $api_key = $sms_api_key->api_key;
                        $sender_id = $sms_api_key->sender_id;
                        $getAuthKey = $api_key;
                        $getSenderId = $sender_id;
                        
                        $authKey = $getAuthKey;
                        $senderId = $getSenderId;
                        $message1 = $getInvitationMsg;
                        $route = "4";
                        $postData = array(
                            'authkey' => $authKey,
                            'mobiles' => $user_phone,
                            'message' => $message1,
                            'sender' => $senderId,
                            'route' => $route
                        );
        
                        $url="https://control.msg91.com/api/sendhttp.php";
        
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $postData
                        ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //get response
                $output = curl_exec($ch);

                curl_close($ch);
        }else{
      
       $twilio=DB::table('twilio')
             ->first();
                           
       $twilsid = $twilio->twilio_sid;  
       $twiltoken = $twilio->twilio_token; 
       $twilphone = $twilio->twilio_phone; 
         // send SMS
        // Your Account SID and Auth Token from twilio.com/console
        $sid = $twilsid;
        $token = $twiltoken;
        $client = new Client($sid, $token);
        $user = $user_phone;
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $user,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => $twilphone,
                // the body of the text message you'd like to send
                'body' => $getInvitationMsg
               
            )
        );
        }
    }
                
    }
    
}
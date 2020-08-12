<?php

namespace App\Http\Controllers\Ios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\SendSms;

class UserController extends Controller
{
    use SendSms;
    
    public function ios_signUp(Request $request)
    {
        
        $this->validate(
            $request, 
            [
                'user_name' => 'required',
                'user_email' => 'required|email',
                'user_phone' => 'required',
                'user_password' => 'required'
            ],
            [
                'user_name.required' => 'Enter Name...',
                'user_email.required' => 'Enter email...',
                'user_phone.required' => 'Enter Mobile...',
                'user_password.required' => 'Enter password...',
            ]
        );
    	$user_name = $request->user_name;
    	$user_email = $request->user_email;
    	$user_phone = $request->user_phone;
    	$user_image = $request->user_image;
    	$user_password = $request->user_password;
    	$device_id = $request->device_id;
        $created_at = Carbon::now();
        $updated_at = Carbon::now();
        // $date=date('d-m-Y');
    	$checkUser = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();
        $smsby = DB::table('smsby')
              ->first();
        if($smsby->status==1){      
        // check for otp verify
    	if($checkUser && $checkUser->is_verified==1){
    		$message = array('status'=>'0', 'message'=>'user already registered');
            return $message;
    	}
    	
    ///////if phone not verified/////	
    	
	elseif($checkUser && $checkUser->is_verified==0){
	                 $delnot= DB::table('notificationby')
    						->where('user_id', $checkUser->user_id)
    				     	->delete();
    						
    	    	$delUser = DB::table('users')
    					->where('user_phone', $user_phone)
    					->delete();
    					
    	    
    	   if($request->user_image){
            $user_image = $request->user_image;
            $user_image = str_replace('data:image/png;base64,', '', $user_image);
            $fileName = str_replace(" ", "-", $user_image);
            $fileName = date('dmyHis').'user_image'.'.'.'png';
            $fileName = str_replace(" ", "-", $fileName);
            \File::put(public_path(). '/images/user/' . $fileName, base64_decode($user_image));
            $user_image = 'images/user/'.$fileName;
        }
            else{
                $user_image = 'N/A';
            }
        
    		$insertUser = DB::table('users')
    						->insertGetId([
    							'user_name'=>$user_name,
    							'user_email'=>$user_email,
    							'user_phone'=>$user_phone,
    							'user_image'=>$user_image,
    							'user_password'=>$user_password,
    							'device_id'=>$device_id,
    							'reg_date'=>$created_at
    						]);
    						
            	$Userdetails = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();
    		if($insertUser){
    		     DB::table('notificationby')
    						->insert(['user_id'=> $insertUser,
    						'sms'=> '1',
    						'app'=> '1',
    						'email'=> '1']);
    						
    						
    			$chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
                
                $otpmsg = $this->otpmsg($otpval,$user_phone);
                
                $updateOtp = DB::table('users')
                                ->where('user_phone', $user_phone)
                                ->update(['otp_value'=>$otpval]);
    						
	    		$message = array('status'=>'1', 'message'=>'OTP Sent', 'data'=>$Userdetails);
	        	return $message;
	    	}
	    	else{
	    		$message = array('status'=>'0', 'message'=>'Something went wrong');
	        return $message;
	    	}  
    	}
    	 ///////new user/////	
    	else{
       if($request->user_image){
            $user_image = $request->user_image;
            $user_image = str_replace('data:image/png;base64,', '', $user_image);
            $fileName = str_replace(" ", "-", $user_image);
            $fileName = date('dmyHis').'user_image'.'.'.'png';
            $fileName = str_replace(" ", "-", $fileName);
            \File::put(public_path(). '/images/user/' . $fileName, base64_decode($user_image));
            $user_image = 'images/user/'.$fileName;
        }
            else{
                $user_image = 'N/A';
            }
        
    		$insertUser = DB::table('users')
    						->insertGetId([
    							'user_name'=>$user_name,
    							'user_email'=>$user_email,
    							'user_phone'=>$user_phone,
    							'user_image'=>$user_image,
    							'user_password'=>$user_password,
    							'device_id'=>$device_id,
    							'reg_date'=>$created_at
    						]);
    						
            	$Userdetails = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();
    		if($insertUser){
    		     DB::table('notificationby')
    						->insert(['user_id'=> $insertUser,
    						'sms'=> '1',
    						'app'=> '1',
    						'email'=> '1']);
    						
    						
    			$chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
               $otpmsg = $this->otpmsg($otpval,$user_phone);
    
                $updateOtp = DB::table('users')
                                ->where('user_phone', $user_phone)
                                ->update(['otp_value'=>$otpval]);
    						
	    		$message = array('status'=>'1', 'message'=>'OTP Sent', 'data'=>$Userdetails);
	        	return $message;
	    	}
	    	else{
	    		$message = array('status'=>'0', 'message'=>'Something went wrong');
	        return $message;
	    	}
    	}
        }
        else{
        if($checkUser){
    		$message = array('status'=>'0', 'message'=>'user already registered');
            return $message;
    	}
    	else{
    	     if($request->user_image){
            $user_image = $request->user_image;
            $user_image = str_replace('data:image/png;base64,', '', $user_image);
            $fileName = str_replace(" ", "-", $user_image);
            $fileName = date('dmyHis').'user_image'.'.'.'png';
            $fileName = str_replace(" ", "-", $fileName);
            \File::put(public_path(). '/images/user/' . $fileName, base64_decode($user_image));
            $user_image = 'images/user/'.$fileName;
             }
            else{
                $user_image = 'N/A';
                }
        
    		$insertUser = DB::table('users')
    						->insertGetId([
    							'user_name'=>$user_name,
    							'user_email'=>$user_email,
    							'user_phone'=>$user_phone,
    							'user_image'=>$user_image,
    							'user_password'=>$user_password,
    							'device_id'=>$device_id,
    							'reg_date'=>$created_at,
    							'is_verified'=>1,
                                'otp_value'=>NULL
    						]);
    						
            	$Userdetails = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();
    		if($insertUser){
    		     DB::table('notificationby')
    						->insert(['user_id'=> $insertUser,
    						'sms'=> '1',
    						'app'=> '1',
    						'email'=> '1']);
    			$message = array('status'=>'2', 'message'=>'Login Successfully', 'data'=>$Userdetails);
                return $message;			
             	}
            }
        }
    }
}
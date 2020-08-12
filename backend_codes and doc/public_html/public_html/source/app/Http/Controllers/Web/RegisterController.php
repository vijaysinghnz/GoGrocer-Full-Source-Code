<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;
use App\Traits\SendSms;

class RegisterController extends Controller
{
    use SendSms;
    
     public function register_user(Request $request)
  {
    
    $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
                
  	return view('web.auth.register', compact('logo'));
  }
    
    public function usersignup(Request $request)
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
    	$user_password = $request->user_password;
    	$device_id = 'n/a';
        $created_at = Carbon::now();
        $updated_at = Carbon::now();
  
    	$checkUser = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();
        $smsby = DB::table('smsby')
              ->first();
        if($smsby->status==1){      
        // check for otp verify
    	if($checkUser && $checkUser->is_verified==1){
    		 return redirect()->route('userregister')->withErrors('User Already Registered');
    	}
    	
    ///////if phone not verified/////	
    	
	elseif($checkUser && $checkUser->is_verified==0){
	                 $delnot= DB::table('notificationby')
    						->where('user_id', $checkUser->user_id)
    				     	->delete();
    						
    	    	$delUser = DB::table('users')
    					->where('user_phone', $user_phone)
    					->delete();
    					
    	    
    	   $user_image = 'N/A';
        
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
    						
	    		return view('web.auth.otp',compact('user_phone'));
	    	}
	    	else{
	    	return redirect()->route('userregister')->withErrors('Something went wrong');
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
    						
	    	return view('web.auth.otp',compact('user_phone'));
	    	}
	    	else{
	    	return redirect()->route('userregister')->withErrors('Something went wrong');
	    	}
    	}
        }
        else{
        if($checkUser){
    	return redirect()->route('userregister')->withErrors('User Already Registered');
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
    			    Session::put('bamaCust', $phone);
                    Session::save();
                    return redirect()->route('webhome');			
             	}
            }
        }
    }
    
    public function web_verify_otp(Request $request)
    {
        $phone = $request->user_phone;
        $otp = $request->otp;
        $smsby = DB::table('smsby')
              ->first();
        if($smsby->status==1){      
        // check for otp verify
        $getUser = DB::table('users')
                    ->where('user_phone', $phone)
                    ->first();
                    
        if($getUser){
            $getotp = $getUser->otp_value;
            
            if($otp == $getotp){
                // verify phone
                $getUser = DB::table('users')
                            ->where('user_phone', $phone)
                            ->update(['is_verified'=>1,
                            'otp_value'=>NULL]);
                            
                    Session::put('bamaCust', $phone);
                    Session::save();
                    return redirect()->route('webhome');
            }
            else{
                return redirect()->route('userregister')->withErrors('Wrong OTP');
            }
       
        }
        else{
           return redirect()->route('userregister')->withErrors('User Not Registered');
        }
        }
        else{
              $getUser = DB::table('users')
                            ->where('user_phone', $phone)
                            ->update(['is_verified'=>1,
                            'otp_value'=>NULL]);
            Session::put('bamaCust', $phone);
            Session::save();
            return redirect()->route('webhome');
        }
    }


    public function login(Request $request)
    
     {
    	$user_phone = $request->user_phone;
    	$user_password = $request->user_password;
    	$device_id = $request->device_id;
    	
    	$checkUserReg = DB::table('users')
    					->where('user_phone', $user_phone)
    					->first();
    					
    	if(!($checkUserReg) || $checkUserReg->is_verified== 0){
    	    $message = array('status'=>'0', 'message'=>'Phone not registered', 'data'=>[]);
	        return $message;
    	}
                
    	$checkUser = DB::table('users')
    					->where('user_phone', $user_phone)
    					->where('user_password', $user_password)
    					->first();

    	if($checkUser){
    	    
    	    if($checkUser->is_verified == 0){
    	        $chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
               $otpmsg = $this->otpmsg($otpval,$user_phone);
               
                $updateOtp = DB::table('users')
                                ->where('user_phone', $user_phone)
                                ->update(['otp_value'=>$otpval]);
                                
                $checkUser1 = DB::table('users')
            					->where('user_phone', $user_phone)
            					->first();                
                                
    	        $message = array('status'=>'2', 'message'=>'Verify Phone', 'data'=>[$checkUser1]);
	        	return $message;
    	    }
    	   else{
    		   $updateDeviceId = DB::table('users')
    		                        ->where('user_phone', $user_phone)
    		                        ->update(['device_id'=>$device_id]);
    		                       
    		   $checkUser1 = DB::table('users')
            					->where('user_phone', $user_phone)
            					->where('user_password', $user_password)
            					->first();
    		                        
    			$message = array('status'=>'1', 'message'=>'login successfully', 'data'=>[$checkUser1]);
	        	return $message;
    	   }	   
    	
    	}
    	else{
    		$message = array('status'=>'0', 'message'=>'Wrong Password', 'data'=>[]);
	        return $message;
    	}
    }
    
    
    
    
    public function myprofile(Request $request)
    {   
        $user_id = $request->user_id;
         $user =  DB::table('users')
                ->where('user_id', $user_id )
                ->first();
                        
    if($user){
        	$message = array('status'=>'1', 'message'=>'User Profile', 'data'=>$user);
	        return $message;
              }
    	else{
    		$message = array('status'=>'0', 'message'=>'User not found', 'data'=>[]);
	        return $message;
    	}
        
    }   
    
    public function forgotPassword(Request $request)
    {
        $user_phone = $request->user_phone;
        
        $checkUser = DB::table('users')
                        ->where('user_phone', $user_phone)
                        ->where('is_verified',1)
                        ->first();
                        
        if($checkUser){
                $chars = "0123456789";
                $otpval = "";
                for ($i = 0; $i < 4; $i++){
                    $otpval .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
               $otpmsg = $this->otpmsg($otpval,$user_phone);
    
                $updateOtp = DB::table('users')
                                ->where('user_phone', $user_phone)
                                ->update(['otp_value'=>$otpval]);
                                
            if($updateOtp){
              $checkUser1 = DB::table('users')
            					->where('user_phone', $user_phone)
            					->first();
    		                        
    			$message = array('status'=>'1', 'message'=>'Verify OTP', 'data'=>[$checkUser1]);
	        	return $message; 
            }
            else{
                $message = array('status'=>'0', 'message'=>'Something wrong', 'data'=>[]);
	        	return $message; 
            }
        }                
        else{
            $message = array('status'=>'0', 'message'=>'User not registered', 'data'=>[]);
	        return $message;
        }
        
    }
    
    public function verifyOtp(Request $request)
    {
        $phone = $request->user_phone;
        $otp = $request->otp;
        
        // check for otp verify
        $getUser = DB::table('users')
                    ->where('user_phone', $phone)
                    ->first();
                    
        if($getUser){
            $getotp = $getUser->otp_value;
            
            if($otp == $getotp){
                $message = array('status'=>1, 'message'=>"Otp Matched Successfully");
                return $message;
            }
            else{
                $message = array('status'=>0, 'message'=>"Wrong OTP");
                return $message;
            }
        }
        else{
            $message = array('status'=>0, 'message'=>"User not registered");
            return $message;
        }
    }
    
    public function changePassword(Request $request)
    {
        $user_phone = $request->user_phone;
        $password = $request->user_password;
        
        $getUser = DB::table('users')
                    ->where('user_phone', $user_phone)
                    ->first();
                    
        if($getUser){
            $updateOtp = DB::table('users')
                            ->where('user_phone', $user_phone)
                            ->update(['user_password'=>$password]);
                                
            if($updateOtp){
              $checkUser1 = DB::table('users')
            					->where('user_phone', $user_phone)
            					->first();
    		                        
    			$message = array('status'=>'1', 'message'=>'Password changed', 'data'=>[$checkUser1]);
	        	return $message; 
            }
            else{
                $message = array('status'=>'0', 'message'=>'Something wrong', 'data'=>[]);
	        	return $message; 
            }
        }
        else{
            $message = array('status'=>0, 'message'=>"User not registered");
            return $message;
        }
    }
    
    
     public function profile_edit(Request $request)
    {
        $user_id = $request->user_id;
    	$user_name = $request->user_name;
    	$user_email = $request->user_email;
    	$user_phone = $request->user_phone;
    	$user_image = $request->user_image;
    		$uu = DB::table('users')
    	    ->where('user_id', $user_id)
    	    ->first();
    	$user_password = $uu->user_password;
        // $date=date('d-m-Y');
    	    
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
        
        $checkUser = DB::table('users')
    			->where('user_phone', $user_phone)
    			->where('user_id','!=', $user_id)
    			->first();
    	if($checkUser && $checkUser->is_verified==1){
    		$message = array('status'=>'0', 'message'=>'This Phone number is attached with another account');
            return $message;
    	}
    	
        else{
        
    		$insertUser = DB::table('users')
    		            ->where('user_id', $user_id)
    						->update([
    							'user_name'=>$user_name,
    							'user_email'=>$user_email,
    							'user_phone'=>$user_phone,
    							'user_image'=>$user_image,
    							'user_password'=>$user_password,
    						]);
    						
            	$Userdetails = DB::table('users')
    					->where('user_id', $user_id)
    					->first();
    					
    					
    		if($insertUser){
    						
	    		$message = array('status'=>'1', 'message'=>'Profile Updated', 'data'=>$Userdetails);
	        	return $message;
	    	}
	    	else{
	    		$message = array('status'=>'0', 'message'=>'Something Went wrong');
	        return $message;
	    	}  
    	}
    }
    
      public function user_block_check(Request $request)
    {   
        $user_id = $request->user_id;
         $user =  DB::table('users')
                ->select('block')
                ->where('user_id', $user_id )
                ->first();
                        
    if($user){
        if($user->block==1){
        	$message = array('status'=>'1', 'message'=>'User is Blocked');
	        return $message;
        }else{
            	$message = array('status'=>'2', 'message'=>'User is Active');
	        return $message;
            }
         }
    	else{
    		$message = array('status'=>'0', 'message'=>'User not found');
	        return $message;
    	}
        
    }   
    
}

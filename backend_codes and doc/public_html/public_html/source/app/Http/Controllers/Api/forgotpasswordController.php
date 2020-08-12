<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use DB;

class forgotpasswordController extends Controller
{

public function checkotponoff(Request $request) {
    $check= DB::table('smsby')
          ->first();
          
if ($check){
   if($check->msg91 == 0 && $check->twilio == 0 && $check->status == 0){
        $message = array('status'=>'0', 'message'=>'SMS/OTP are Off');
	            return $message;
   }
   else{
        $message = array('status'=>'1', 'message'=>'SMS/OTP are On');
	            return $message;
   }
}
 else{
        $message = array('status'=>'2', 'message'=>'table or Data Not Found');
	            return $message;
   }
}
 public function forgot_password(Request $request) {

        $app = DB::table('tbl_web_setting')
             ->first();
        $app_name= $app->name;     
        $user_email = $request->user_email;
        $user_phone = $request->user_phone;
        
        $check = DB::table('users')
                ->where('user_email',$user_email)
                ->where('user_phone',$user_phone)
                ->first();
                
        if($check){        
        $data = array('to' => $user_email, 'from' => 'noreply@gogrocer.in', 'to-name'=>$user_email, 'from-name' =>$app_name);

        Mail::send('admin.forgetpassword.forgot_password', compact('user_email','check'), function ($m) use ($data){
                $m->from($data['from'], $data['from-name']);
                $m->to($data['to'], $data['to-name'])->subject("Check your mail");
            });
        
       $message = array('status'=>'1', 'message'=>'Email sent');
	            return $message;
        }else{
           $message = array('status'=>'0', 'message'=>'Email/phone is not registered');
	            return $message;
        }
    }
  
  
   public function forgot_password1(Request $request)
    {
 
       $password=$request->password;
       $password1=$request->password2;
       $id= $request->id; 
        if($password != NULL || $password1 != NULL){
       if($password==$password1){
        $insertcategories = DB::table('users')
                            ->where('user_id',$id)
                            ->update([
                                'user_password'=>$password
                            ]);
        
        if($insertcategories){
             return view('admin.forgetpassword.success', compact('password'));
        }
        else{
            return redirect()->back()->withErrors("Something wents wrong");
        }
       }
       else{
           return redirect()->back()->withErrors("Password Not Matched");
       }
        }
        else{
            return redirect()->back()->withErrors("Enter password in both fields");
        }
   
    }
 
    
     public function change_pass(Request $request) {
        $id= $request->id;
        $user = DB::table('users')
            ->where('user_id',$id)
            ->first();
        return view('admin.forgetpassword.changepass', compact('user'));
        
    }    
    
}
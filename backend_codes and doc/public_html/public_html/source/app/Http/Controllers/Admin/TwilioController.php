<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\WebSetting;
use DB;
use Auth;
use Hash;


class TwilioController extends Controller
{
    public function updatetwilio(Request $request)
    {
         $sid = $request->sid;
        $token = $request->token;
        $phone = $request->phone;
        $this->validate(
            $request,
                [
                    'sid' => 'required',
                    'token'=>'required',
                    'phone'=>'required',
                ],
                [
                    'sid.required' => 'Enter Twilio SID.',
                    'token.required' =>'Enter Twilio Token.',
                    'phone.required' => 'Enter Twilio Phone.'
                ]
        );
        
        
        $check = DB::table('twilio')
               ->first();
       
    
      if($check){
        

        $update = DB::table('twilio')
                ->update(['twilio_sid'=> $sid,'twilio_token'=> $token, 'twilio_phone'=>$phone,'active'=>1]);
    
      }
      else{
          $update = DB::table('twilio')
                ->insert(['twilio_sid'=> $sid,'twilio_token'=> $token, 'twilio_phone'=>$phone,'active'=>1]);
      }
     if($update){
         $ue = DB::table('smsby')
            ->update(['msg91'=> 0,'twilio'=> 1,'status'=>1]); 
         $deactivemsg91 = DB::table('msg91')
                ->update(['active'=>0]);    
                
        return redirect()->back()->withSuccess('Updated Successfully');
     }
     else{
         return redirect()->back()->withErrors('Nothing to Update');
     }
    }
    public function msgoff(Request $request)
    {
     
       $ue = DB::table('smsby')
            ->update(['msg91'=> 0,'twilio'=> 0, 'status'=>0]);
            
       if($ue){
        $update = DB::table('twilio')
                ->update(['active'=>0]);
                
        $deactivemsg91 = DB::table('msg91')
                ->update(['active'=>0]);         
        return redirect()->back()->withSuccess('SMS and OTP Switched Off For App');
      }
      else{
         return redirect()->back()->withErrors('Already Switched Off');
      }
  
    }
}
<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class PayController extends Controller
{
     public function payment_gateway(Request $request)
    {
        
        $title="Payment Gateway";
    	 
    	$admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->first();	
                
          $pymnt = DB::table('payment_via')
                ->first();   
              
         return view('admin.settings.pymnt',compact("admin_email","admin",'title','logo','pymnt'));
      

    }
 
    public function updatepymntvia(Request $request)
    {
       $pymnt_via = $request->pymnt_via;
        if ($pymnt_via == 'razor'){
            $razorpay = 1;
            $paypal = 0;
        }
        elseif ($pymnt_via == 'paypal'){
          $razorpay = 0;
            $paypal = 1;   
        }
        else{
            $razorpay = 1;
            $paypal = 1;   
        }
        $check = DB::table('payment_via')
               ->first();
       
    
      if($check){
        $update = DB::table('payment_via')
                ->update(['razorpay'=> $razorpay,'paypal'=> $paypal]);
    
      }
      else{
          $update = DB::table('payment_via')
                ->insert(['razorpay'=> $razorpay,'paypal'=> $paypal]);
      }
     if($update){
         $ue = DB::table('smsby')
                ->update(['msg91'=> 1,'twilio'=> 0,'status'=>1]);
         $deactivetwilio = DB::table('twilio')
                ->update(['active'=>0]);        
        return redirect()->back()->withSuccess('Updated Successfully');
     }
     else{
         return redirect()->back()->withErrors('Nothing to Update');
     }
    }
    
}
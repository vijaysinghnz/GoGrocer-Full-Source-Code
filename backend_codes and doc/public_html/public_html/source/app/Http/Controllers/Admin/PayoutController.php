<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Traits\SendMail;
use App\Traits\SendSms;

class PayoutController extends Controller
{
    use SendMail;
    use SendSms;

    public function pay_req(Request $request)
    {
         $title = "Home";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	 $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        
         $total_earnings=DB::table('payout_requests')
                            ->join('store', 'payout_requests.store_id', '=', 'store.store_id')
                            ->join('store_bank', 'payout_requests.store_id', '=', 'store_bank.store_id')
                           ->join('orders','payout_requests.store_id','=','orders.store_id')
                           ->leftJoin('store_earning','payout_requests.store_id','=','store_earning.store_id')
                           ->select('store.store_id','store.store_name', 'store.phone_number','store.address','store.email','store_earning.paid','payout_requests.payout_amt', 'payout_requests.complete','payout_requests.req_id','store_bank.ac_no', 'store_bank.ifsc','store_bank.holder_name','store_bank.bank_name', 'store_bank.upi', DB::raw('SUM(orders.total_price)-SUM(orders.total_price)*(store.admin_share)/100 as sumprice'))
                           ->groupBy('store.store_id','store.store_name', 'store.phone_number','store.address','store.email','store_earning.paid','store.admin_share','payout_requests.payout_amt', 'payout_requests.complete','payout_requests.req_id','store_bank.ac_no', 'store_bank.ifsc','store_bank.holder_name','store_bank.bank_name', 'store_bank.upi')
                           ->where('orders.order_status','Completed')
                           ->where('payout_requests.complete', 0)
                           ->paginate(10);
                        
    	return view('admin.store.payoutRequest', compact('title',"admin", "logo","total_earnings"));
    }
    
    
     public function store_pay(Request $request)
    {
        $req_id = $request->req_id;
        
        $st = DB::table('payout_requests')
            ->where('req_id',$req_id) 
            ->first();
        $store_id=$st->store_id;
        $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $amt = $request->amt;
        $check = DB::table('store_earning')
                ->where('store_id',$store_id)
                ->first();
        $check2 = DB::table('store')
                ->where('store_id',$store_id)
                ->first();        
        $store_phone =  $check2->phone_number;
        
        if($check){
        $new_amount = $check->paid + $amt;    
        $update = DB::table('store_earning')
                ->where('store_id',$store_id)
                ->update(['paid'=>$new_amount]);
        }
        else{
         $update = DB::table('store_earning')
                ->insert(['store_id'=>$store_id,'paid'=>$amt]);   
                
                 DB::table('payout_requests')
                 ->where('req_id', $req_id)
                ->update(['complete'=>1]);
        }
        if($update){
             $sendmsg = $this->sendpayoutmsg($amt,$store_phone);
                
                $store_name = $check2->store_name;
                $user_email = $check2->email;  
                $app_name = $logo->name;
            /////send mail
               
            $welcomeMail = $this->payoutMail($amt,$store_name,$user_email,$app_name); 
            
            
            
             return redirect()->back()->withSuccess('Amount of '.$amt.' marked paid successfully against your request.');
        }
        else{
             return redirect()->back()->withErrors('Something Wents Wrong');
        }
    }
       
}

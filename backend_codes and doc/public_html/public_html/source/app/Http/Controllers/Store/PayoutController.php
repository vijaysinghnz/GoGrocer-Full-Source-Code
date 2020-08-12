<?php
namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class PayoutController extends Controller
{
  public function payout_req(Request $request)
    {
        
        $title="Send Payout Request";
    	 
    	$store_email=Session::get('bamaStore');
    	 $store= DB::table('store')
    	 		   ->where('email',$store_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();	
           
         $ll = DB::table('payout_requests')
            ->where('store_id',$store->store_id)
            ->orderBy('req_id', 'desc')
            ->first();
         $dd = DB::table('payout_req_valid')  
             ->first();
             
         $days= $dd->min_days;
         $min_amt =$dd->min_amt;
	     $current=date('Y-m-d'); 
	  if($ll){
         $last_date = $ll->req_date;
	  }else
	  {
		  $days22 =10;
		  $last_date = date('Y-m-d', strtotime($current.' - '.$days22.' days'));
	  }
          
        
         $end = date('Y-m-d', strtotime($last_date.' + '.$days.' days'));
         
         $bank = DB::table('store_bank')
                ->where('store_id',$store->store_id)
                ->first();
                
         $total_earnings=DB::table('store')
                           ->join('orders','store.store_id','=','orders.store_id')
                           ->leftJoin('store_earning','store.store_id','=','store_earning.store_id')
                           ->select('store_earning.paid',DB::raw('SUM(orders.total_price)-SUM(orders.total_price)*(store.admin_share)/100 as sumprice'))
                           ->groupBy('store_earning.paid','store.admin_share')
                           ->where('orders.order_status','Completed')
                           ->where('store.store_id',$store->store_id)
                           ->first(); 
	  
	         if($total_earnings != NULL){
			   $sumprice = $total_earnings->sumprice;
			  }
			  else{
					$sumprice = 0;
			  }
			   if($total_earnings != NULL){
			   $paid = $total_earnings->paid;
			  }
			  else{
					$paid = 0;
			  }
        $currency = DB::table('currency')
                  ->first();
         return view('store.payout_req',compact("store_email", "store",'title', 'logo', 'sumprice', 'paid', 'bank', 'total_earnings', 'currency', 'current', 'end', 'last_date', 'min_amt','days','ll'));
    } 
    public function req_sent(Request $request)
    {
        $date= date('Y-m-d');
         $bank_name = $request->bank_name;
         $store_email=Session::get('bamaStore');
    	 $store= DB::table('store')
    	 		   ->where('email',$store_email)
    	 		   ->first();
        $store_id = $store->store_id;
        $ifsc = $request->ifsc;
        $ac_no = $request->ac_no;
        $holder = $request->holder_name;
        $upi = $request->upi;
        $payout_amt = $request->payout_amt;
          $this->validate(
            $request,
                [
                    
                    'bank_name' => 'required',
                    'ifsc' => 'required',
                    'holder_name' => 'required',
                    'ac_no' => 'required',
                    
                ],
                [
                    'bank_name.required' => 'Enter Bank Name.',
                    'ifsc.required' => 'Enter IFSC Code.',
                    'holder_name.required' => 'Enter Account holder Name.',
                    'ac_no.required'=>'Enter Account Number.'
                ]
        );
        
        $check = DB::table('store_bank')
              ->where('store_id',$store->store_id)
               ->first();
       
    
      if($check){
        

        $update = DB::table('store_bank')
                ->where('store_id',$store->store_id)
                ->update(['ac_no'=> $ac_no,'bank_name'=> $bank_name,'ifsc'=>$ifsc,'upi'=>$upi,'holder_name'=>$holder]);
    
      }
      else{
          $update = DB::table('store_bank')
                ->insert(['ac_no'=> $ac_no,'bank_name'=> $bank_name, 'store_id'=>$store_id,'ifsc'=>$ifsc,'upi'=>$upi,'holder_name'=>$holder]);
      }
      
      $up1 = DB::table('payout_requests')
       ->where('complete', 0)
       ->where('store_id', $store->store_id)
       ->update(['complete'=> 2]);
       
       
      $up2 = DB::table('payout_requests') 
             ->insert(['req_date'=> $date,'payout_amt'=> $payout_amt, 'store_id'=>$store_id]);
     if($up2){
        return redirect()->back()->withSuccess('Request sent Successfully');
     }
     else{
         return redirect()->back()->withErrors('something went wrong');
     }
    }
}
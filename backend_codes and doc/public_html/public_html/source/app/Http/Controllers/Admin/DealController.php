<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\Carbon;

class DealController extends Controller
{
    public function list(Request $request)
    {
        $title = "Deal Product List";
        $currentdate = Carbon::now();
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
           $deal_p = DB::table('deal_product')
                    ->join('product_varient','deal_product.varient_id','=','product_varient.varient_id')
                    ->join('product','product_varient.product_id','=','product.product_id')
                    ->paginate(10);
        
    	return view('admin.deal_product.list', compact('title',"admin", "logo","deal_p","currentdate"));
    }

    
     public function AddDeal(Request $request)
    {
    
        $title = "Add Deal";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
                
           $deal = DB::table('product_varient')
                ->join('product','product_varient.product_id','=','product.product_id')
                ->get();
        
        
        
        return view('admin.deal_product.add',compact("deal", "admin_email","logo", "admin", "title"));
     }
    
     public function AddNewDeal(Request $request)
    {
        $varient_id = $request->varient_id;
        $deal_price = $request->deal_price;
        $valid_from = $request->valid_from;
        $valid_to = $request->valid_to;
        $date=date('d-m-Y');
 
    
        
        $this->validate(
            $request,
                [
                    
                    'varient_id' => 'required',
                    'deal_price' => 'required',
                    'valid_from' => 'required',
                    'valid_to'=>'required',
                ],
                [
                    'varient_id.required' => 'Select Varient',
                    'deal_price.required' => 'Enter Deal Price',
                    'valid_from.required' => 'Choose valid from date',
                    'valid_to.required'=> 'Choose valid from date',
                ]
        );


        $insertCategory = DB::table('deal_product')
                            ->insert([
                                'varient_id'=>$varient_id,
                                'deal_price'=>$deal_price,
                                'valid_from'=>$valid_from,
                                'valid_to'=>$valid_to,
                                'status'=>1,
                               
                            ]);
        
        if($insertCategory){
            return redirect()->back()->withSuccess('Deal Product Added successfully');
        }
        else{
            return redirect()->back()->withErrors("Something Wents Wrong");
        }
      
    }
    
    public function EditDeal(Request $request)
    {
         $deal_id = $request->id;
         $title = "Edit Deal Products";
         $deal = DB::table('product_varient')
                ->join('product','product_varient.product_id','=','product.product_id')
                ->get();
        
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
          $deal_p = DB::table('deal_product')
                    ->join('product_varient','deal_product.varient_id','=','product_varient.varient_id')
                    ->join('product','product_varient.product_id','=','product.product_id')
                    ->where('deal_id',$deal_id)
                    ->first();

        return view('admin.deal_product.edit',compact("deal_p","admin_email","admin","logo","deal", "title"));
    }

    public function UpdateDeal(Request $request)
    {
        $deal_id = $request->id;
       $varient_id = $request->varient_id;
        $deal_price = $request->deal_price;
        $valid_from = $request->valid_from;
        $valid_to = $request->valid_to;
        $date=date('d-m-Y');
 
    
        
        $this->validate(
            $request,
                [
                    
                    'varient_id' => 'required',
                    'deal_price' => 'required',
                    'valid_from' => 'required',
                    'valid_to'=>'required',
                ],
                [
                    'varient_id.required' => 'Select Varient',
                    'deal_price.required' => 'Enter Deal Price',
                    'valid_from.required' => 'Choose valid from date',
                    'valid_to.required'=> 'Choose valid from date',
                ]
        );


        $updateDeal = DB::table('deal_product')
                    ->where('deal_id', $deal_id)
                            ->update([
                                'varient_id'=>$varient_id,
                                'deal_price'=>$deal_price,
                                'valid_from'=>$valid_from,
                                'valid_to'=>$valid_to,
                                'status'=>1,
                               
                            ]);
        
        if($updateDeal){
            return redirect()->back()->withSuccess('Deal Product Updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something Wents Wrong");
        }
    }

 public function DeleteDeal(Request $request)
    {
        $deal_id=$request->id;

    	$delete=DB::table('deal_product')->where('deal_id',$deal_id)->delete();
        if($delete)
        {
        return redirect()->back()->withSuccess('Deleted Successfully');
        }
        else
        {
           return redirect()->back()->withErrors('Unsuccessfull Delete'); 
        }
    }

}
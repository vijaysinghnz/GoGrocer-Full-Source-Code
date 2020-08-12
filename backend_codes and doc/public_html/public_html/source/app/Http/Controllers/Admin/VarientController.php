<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;

class VarientController extends Controller
{
    public function varient(Request $request)
    {
         $id = $request->id;
          $p= DB::table('product')
                 ->where('product_id', $id)
                ->first();
         
        $title=$p->product_name." Varient";
    	 
    	$admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $product= DB::table('product_varient')
                 ->where('product_id', $id)
                ->paginate(10);
        $currency =  DB::table('currency')
               ->select('currency_sign')
                ->get();           
        return view('admin.product.varient.show_varient',compact("admin_email","product","admin","currency","id",'title','logo'));
    }
    
     public function Addproduct(Request $request)
    {
        $id = $request->id;  
        $p= DB::table('product')
                 ->where('product_id', $id)
                ->first();
         
        $title=$p->product_name." Varient Addition";
    	 
    	$admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $product= DB::table('product_varient')
                 ->where('product_id', $id)
                ->get();
        $currency =  DB::table('currency')
               ->select('currency_sign')
                ->get(); 
        
                
            // echo $id;
         return view('admin.product.varient.addvarient',compact("admin_email","admin","id",'title','logo'));
    }
    
    
   public function AddNewproduct(Request $request)
    {
         
        $id = $request->id;
        $mrp = $request->mrp;
        $price=$request->price;
        $unit=$request->unit;
        $quantity=$request->quantity;
        $description =$request->description;
        $date = date('d-m-Y');
        $created_at=date('d-m-Y h:i a');

          
        $this->validate(
            $request,
                [
                    'mrp'=>'required',
                    'description'=>'required',
                    'quantity'=>'required',
                    'unit'=>'required',
                    'price'=>'required',
                    'varient_image'=>'required|mimes:jpeg,png,jpg|max:1000',
                ],
                [
                    'mrp.required'=>'enter mrp',
                    'description.required'=>'enter description about product',
                    'mrp.required'=>'enter product MRP',
                    'varient_image.required'=>'select an image',
                    'quantity.required'=>'enter quantity',
                    'unit.required'=>'enter unit'
                ]
        );
                
        if($request->hasFile('varient_image')){
            $image = $request->varient_image;
            $fileName = $image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $image->move('images/product/'.$date.'/', $fileName);
            $image = 'images/product/'.$date.'/'.$fileName;
        }
        else{
            $image = 'N/A';
        }

        
        
        $insert =  DB::table('product_varient')
                        ->insert(['product_id'=>$id,'mrp'=>$mrp, 'price'=>$price,'varient_image'=>$image, 'unit'=>$unit, 'quantity'=>$quantity,'description'=>$description]);
     if($insert){
         return redirect()->back()->withSuccess('Successfully Added');
     }
     else{
     return redirect()->back()->withErrors('something went wrong');
     }
	
    }
    
    public function Editproduct(Request $request)
    {
 
       $varient_id=$request->id;

    	$admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $product= DB::table('product_varient')
                 ->where('varient_id', $varient_id)
                ->first();
                
        $p= DB::table('product')
                 ->where('product_id', $product->product_id)
                ->first();
         $title=$p->product_name." Varient Update";
         
    	 return view('admin.product.varient.editvarient',compact("admin_email","admin","product","varient_id",'title','logo'));
   }
    public function Updateproduct(Request $request)
   {
     
        $product_id=$request->id;
         $id = $request->id;
        $mrp = $request->mrp;
        $price=$request->price;
        $unit=$request->unit;
        $quantity=$request->quantity;
        $description =$request->description;
        $date = date('d-m-Y');
        $created_at=date('d-m-Y h:i a');
        $varient_image = $request->varient_image;
        
        $getImage = DB::table('product_varient')
                     ->where('varient_id',$product_id)
                    ->first();

        $image = $getImage->varient_image;  

        if($request->hasFile('varient_image')){
             if(file_exists($image)){
                unlink($image);
            }
            $varient_image = $request->varient_image;
            $fileName = date('dmyhisa').'-'.$varient_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $varient_image->move('images/product/'.$date.'/', $fileName);
            $varient_image = 'images/product/'.$date.'/'.$fileName;
        }
        else{
            $varient_image = $image;
        }

       $varient_update = DB::table('product_varient')
                            ->where('varient_id', $product_id)
                            ->update(['mrp'=>$mrp, 'price'=>$price,'varient_image'=>$varient_image, 'unit'=>$unit, 'quantity'=>$quantity,'description'=>$description]);

        if($varient_update){

            return redirect()->back()->withSuccess('Updated Successfully');
        }
        else{
            return redirect()->back()->withErrors("Something Wents Wrong.");
        }
    }
  public function deleteproduct(Request $request)
    {
        $varient_id=$request->id;

        $getfile=DB::table('product_varient')
                ->where('varient_id',$varient_id)
                ->first();

        $product_image=$getfile->varient_image;

    	$delete=DB::table('product_varient')->where('varient_id',$request->id)->delete();
        if($delete)
        {
        
            if(file_exists($product_image)){
                unlink($product_image);
            }
         
        return redirect()->back()->withSuccess('Deleted Successfully');

        }
        else
        {
           return redirect()->back()->withErrors('Unsuccessfull Delete'); 
        }

    }
	
    
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class ProductController extends Controller
{
    public function list(Request $request)
    {
        $title = "Product List";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
           $product = DB::table('product')
                    ->join('categories','product.cat_id','=','categories.cat_id')
                   ->paginate(10);
        
    	return view('admin.product.list', compact('title',"admin", "logo","product"));
    }

    
     public function AddProduct(Request $request)
    {
    
        $title = "Add Product";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
           $cat = DB::table('categories')
                   ->select('parent')
                   ->get();
                   
        if(count($cat)>0){           
        foreach($cat as $cats) {
            $a = $cats->parent;
           $aa[] = array($a); 
        }
        }
        else{
            $a = 0;
           $aa[] = array($a);
        }
        
         $category = DB::table('categories')
                  ->where('level', '!=', 0)
                  ->WhereNotIn('cat_id',$aa)
                    ->get();
   
        
        return view('admin.product.add',compact("category", "admin_email","logo", "admin","title"));
     }
    
     public function AddNewProduct(Request $request)
    {
        $category_id=$request->cat_id;
        $product_name = $request->product_name;
        $quantity = $request->quantity;
        $unit = $request->unit;
        $price = $request->price;
        $description = $request->description;
        $date=date('d-m-Y');
        $mrp = $request->mrp;
    
    
        
        $this->validate(
            $request,
                [
                    'cat_id'=>'required',
                    'product_name' => 'required',
                    'product_image' => 'required|mimes:jpeg,png,jpg|max:1000',
                    'quantity'=> 'required',
                    'unit'=> 'required',
                    'price'=> 'required',
                    'mrp'=>'required',
                ],
                [
                    'cat_id.required'=>'Select category',
                    'product_name.required' => 'Enter product name.',
                    'product_image.required' => 'Choose product image.',
                    'quantity.required' => 'Enter quantity.',
                    'unit.required' => 'Choose unit.',
                    'price.required' => 'Enter price.',
                    'mrp.required'=>'Enter MRP.',
                ]
        );


        if($request->hasFile('product_image')){
            $product_image = $request->product_image;
            $fileName = $product_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $product_image->move('images/product/'.$date.'/', $fileName);
            $product_image = 'images/product/'.$date.'/'.$fileName;
        }
        else{
            $category_image = 'N/A';
        }

        $insertproduct = DB::table('product')
                            ->insertGetId([
                                'cat_id'=>$category_id,
                                'product_name'=>$product_name,
                                'product_image'=>$product_image,
                                
                               
                            ]);
        
        if($insertproduct){
             DB::table('product_varient')
            ->insert([
                'product_id'=>$insertproduct,
                'quantity'=>$quantity,
                'varient_image'=>$product_image,
                'unit'=>$unit,
                'price'=>$price,
                'mrp'=>$mrp,
                'description'=>$description,
               
            ]);
            
            return redirect()->back()->withSuccess('Product Added Successfully');
        }
        else{
            return redirect()->back()->withErrors("Something Wents Wrong");
        }
      
    }
    
    public function EditProduct(Request $request)
    {
         $product_id = $request->product_id;
         $title = "Edit Product";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
          $product = DB::table('product')
                   ->where('product_id',$product_id)
                    ->first();
                    

        return view('admin.product.edit',compact("admin_email","admin","logo","title","product"));
    }

    public function UpdateProduct(Request $request)
    {
         $product_id = $request->product_id;
        $product_name = $request->product_name;
        $date=date('d-m-Y');
        $product_image = $request->product_image;
        
    
        
        $this->validate(
            $request,
                [
                    
                    'product_name' => 'required',
                ],
                [
                    'product_name.required' => 'Enter product name.',
                ]
        );

       $getProduct = DB::table('product')
                    ->where('product_id',$product_id)
                    ->first();

        $image = $getProduct->product_image;

        if($request->hasFile('product_image')){
            $product_image = $request->product_image;
            $fileName = $product_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $product_image->move('images/product/'.$date.'/', $fileName);
            $product_image = 'images/product/'.$date.'/'.$fileName;
        }
        else{
            $product_image = $image;
        }

        $insertproduct = DB::table('product')
                       ->where('product_id', $product_id)
                            ->update([
                                'product_name'=>$product_name,
                                'product_image'=>$product_image,
                               
                            ]);
        
        if($insertproduct){
            return redirect()->back()->withSuccess('Product Updated Successfully');
        }
        else{
            return redirect()->back()->withErrors("Something Wents Wrong");
        }
       
       
       
       
    }
    
    
    
 public function DeleteProduct(Request $request)
    {
        $product_id=$request->product_id;

    	$delete=DB::table('product')->where('product_id',$request->product_id)->delete();
        if($delete)
        {
         $delete=DB::table('product_varient')->where('product_id',$request->product_id)->delete();  
         
        return redirect()->back()->withSuccess('Deleted Successfully');
        }
        else
        {
           return redirect()->back()->withErrors('Unsuccessfull Delete'); 
        }
    }

}
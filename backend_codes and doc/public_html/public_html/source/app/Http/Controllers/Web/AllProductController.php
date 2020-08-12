<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class AllProductController extends Controller
{
    public function products(Request $request)
    {
        $cust_phone=Session::get('bamaCust');
    	 $cust= DB::table('users')
    	 		   ->where('user_phone',$cust_phone)
    	 		   ->first();
        $title = "Home";
        $category = DB::table('categories')
                  ->get();
        $category_sub = DB::table('categories')
                     ->where('level',1)
                     ->get();   
        $category_child = DB::table('categories')
                     ->where('level',2)
                     ->get();
        $prod_variant =  DB::table('product_varient')
                      ->get();             
        $category_prod = DB::table('categories')
                      ->first();
          $parent= $category_prod->parent;           
         if($parent==0)
         {
          $category_s = DB::table('categories')
                        ->where('parent',$category_prod->cat_id)
                      ->first();
                      
               if($category_s)
               {
                 $category_c = DB::table('categories')
                          ->where('parent',$category_s->cat_id)
                          ->first();  
                    if($category_c)
                    {
                        $products = DB::table('product')
                                 ->where('cat_id',$category_c->cat_id)
                                 ->get();   
                    }
                    else
                    {
                       $products = DB::table('product')
                     ->where('cat_id',$category_s->cat_id)
                     ->get();    
                    }
                    
               }
               else
               {
                $products = DB::table('product')
                         ->where('cat_id',$category_prod->cat_id)
                         ->get();     
               }
           
           
            
         }
                      
    	return view('web.product.cat_product', compact("title","category","category_sub","category_child","products","prod_variant",'cust','cust_phone'));
    }
    
    public function cate(Request $request)
    {
        $cust_phone=Session::get('bamaCust');
    	 $cust= DB::table('users')
    	 		   ->where('user_phone',$cust_phone)
    	 		   ->first();
        $cat_id=$request->cat_id; 
         
         $products =  DB::table('product')
                  ->where('cat_id', $cat_id)
                  ->get();
              
         $prod_variant =  DB::table('product_varient')
                      ->get();
          $category = DB::table('categories')
                  ->get();
        $category_sub = DB::table('categories')
                     ->where('level',1)
                     ->get();   
        $category_child = DB::table('categories')
                     ->where('level',2)
                     ->get();             
         return view('web.product.cat_product', compact("category","category_sub","category_child","products","prod_variant",'cust','cust_phone'));             
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class StoreController extends Controller
{
    public function storeclist(Request $request)
    {
         $title = "Home";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        
        $city = DB::table('store')
                ->paginate(10);
                
        return view('admin.store.storeclist', compact('title','city','admin','logo'));    
        
        
    }
    public function store(Request $request)
    {
        $title = "Home";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        
        $city = DB::table('city')
                ->get();
        $map1 = DB::table('map_API')
             ->first();
         $map = $map1->map_api_key;       
        return view('admin.store.storeadd', compact('title','city','admin','logo','map'));    
        
        
    }
    public function storeadd(Request $request)
    {
        $title = "Home";
        
        $store_name = $request->store_name;
        $emp_name = $request->emp_name;
        $number = $request->number;
        $city = $request->city;
        $email = $request->email;
        $range = $request->range;
        $password = $request->password;
        $password = $request->password;
        $address = $request->address;
        $share =$request->share;
        $discount = str_replace("%",'', $share);
        $addres = str_replace(" ", "+", $address);
        $address1 = str_replace("-", "+", $addres);
        $checkmap = DB::table('map_API')
                  ->first();
                  
        $chkstorphon = DB::table('store')
                      ->where('phone_number', $number)
                      ->first(); 
         $chkstoremail = DB::table('store')
                      ->where('email', $email)
                      ->first();              
        
         if($chkstorphon && $chkstoremail){
             return redirect()->back()->withErrors('This Phone Number and Email Are Already Registered With Another Store');
        } 

        if($chkstorphon){
             return redirect()->back()->withErrors('This Phone Number is Already Registered With Another Store');
        } 
        if($chkstoremail){
             return redirect()->back()->withErrors('This Email is Already Registered With Another Store');
        } 
                  
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=".$checkmap->map_api_key));
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
        
       
        
        $this->validate(
            $request,
                [
                    
                    'store_name'=>'required',
                    'emp_name'=>'required',
                    'number'=>'required',
                    'range'=>'required',
                    'address'=>'required',
                    'email'=>'required',
                    'password'=>'required',
                ],
                [
                    
                    'store_name.required'=>'Store Name Required',
                    'emp_name.required'=>'Employee Name Required',
                    'number.required'=>'Phone Number Required',
                    'range.required'=>'Enter delivery range',
                    'address.required'=>'Enter store address',
                    'email.required'=>'E-mail Address Required',
                    'password.required'=>'Password Required',

                ]
        );
        
        
    
        
    	$insert = DB::table('store')
                    ->insertgetid([
                        'store_name'=>$store_name,
                        'employee_name'=>$emp_name,
                        'phone_number'=>$number,
                        'city'=>$city,
                        'email'=>$email,
                        'del_range'=> $range,
                        'password'=>$password,
                        'address'=>$address,
                        'lat'=>$lat,
                        'lng'=>$lng,
                        'admin_share'=>$share,
                        ]);
                        
      if($insert){
        return redirect()->back()->withSuccess('Added Successfully');
      }else{
         return redirect()->back()->withErrors('Something Wents Wrong'); 
      }

    }
    
    public function storedit(Request $request)
    {
         $title = "Edit Store";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        
        $store_id = $request->store_id;
        
        $city = DB::table('city')
                    ->get();
                    
              
       $map1 = DB::table('map_API')
             ->first();
         $map = $map1->map_api_key;   
        $store = DB::table('store')
                ->where('store_id',$store_id)
                ->first();
                
        return view('admin.store.storeedit', compact('title','city','store','admin','logo','map'));    
        
        
    }
    
    public function storeupdate(Request $request)
    {
        $title = "Update store";
        $store_id = $request->store_id;
        $share =$request->share;
        $store_name = $request->store_name;
        $emp_name = $request->emp_name;
        $number = $request->number;
        $city = $request->city;
        $range = $request->range;
        $email = $request->email;
        $password = $request->password;
        $address = $request->address;
        $addres = str_replace(" ", "+", $address);
        $address1 = str_replace("-", "+", $addres);
         $checkmap = DB::table('map_API')
                  ->first();

         $chkstorphon = DB::table('store')
                      ->where('phone_number', $number)
                      ->where('store_id', '!=', $store_id)
                      ->first(); 
         $chkstoremail = DB::table('store')
                      ->where('email', $email)
                      ->where('store_id', '!=', $store_id)
                      ->first();              
        
         
         if($chkstorphon && $chkstoremail){
             return redirect()->back()->withErrors('This Phone Number and Email Are Already Registered With Another Store');
        } 

        if($chkstorphon){
             return redirect()->back()->withErrors('This Phone Number is Already Registered With Another Store');
        } 
        if($chkstoremail){
             return redirect()->back()->withErrors('This Email is Already Registered With Another Store');
        } 
        
        
        
        
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=".$checkmap->map_api_key));
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
        
        $this->validate(
            $request,
                [
                    
                    'store_name'=>'required',
                    'emp_name'=>'required',
                    'number'=>'required',
                    'email'=>'required',
                    'password'=>'required',
                    'range'=>'required',
                    'address'=>'required'
                ],
                [
                    
                    'store_name.required'=>'Store Name Required',
                    'emp_name.required'=>'Employee Name Required',
                    'number.required'=>'Phone Number Required',
                    'range.required'=>'Enter delivery range',
                    'address.required'=>'Enter store address',
                    'email.required'=>'E-mail Address Required',
                    'password.required'=>'Password Required',

                ]
        );
        
    	 $insert = DB::table('store')
    	            ->where('store_id',$store_id)
                    ->update([
                        'store_name'=>$store_name,
                        'employee_name'=>$emp_name,
                        'phone_number'=>$number,
                        'city'=>$city,
                        'email'=>$email,
                        'del_range'=>$range,
                        'password'=>$password,
                        'address'=>$address,
                        'lat'=>$lat,
                        'lng'=>$lng,
                        ]);
     
     return redirect()->back()->withSuccess('Updated Successfully');
    }
    
    public function storedelete(Request $request)
    {
        
                    $store_id=$request->store_id;
            
                	$delete=DB::table('store')->where('store_id',$store_id)->delete();
                    if($delete)
                    {
                    DB::table('store_products')->where('store_id',$store_id)->delete();
                    return redirect()->back()->withSuccess('Deleted Successfully');
            
                    }
                    else
                    {
                       return redirect()->back()->withErrors('Something Wents Wrong'); 
                    }
    }
}
<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
class CityController extends Controller
{
    public function citylist(Request $request)
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
                ->paginate(6);
                
        return view('admin.city.citylist', compact('title','city','admin','logo'));    
        
        
    }
    public function city(Request $request)
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
                
        return view('admin.city.cityadd', compact('title','city','admin','logo'));    
        
        
    }
    public function cityadd(Request $request)
    {
        $title = "Home";
        
        $city = $request->city;
        $cities = ucfirst($city);
        
        $this->validate(
            $request,
                [
                    
                    'city'=>'required',
                ],
                [
                    
                    'city.required'=>'City Name Required',

                ]
        );
        
    	 $insert = DB::table('city')
                    ->insert([
                        'city_name'=>$cities,
                        ]);
     
    return redirect()->back()->withSuccess('City Added Successfully');

    }
    
    public function cityedit(Request $request)
    {
       $title = "Update City";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $city_id = $request->city_id;
        
        $city = DB::table('city')
                ->where('city_id',$city_id)
                ->first();
                
        return view('admin.city.cityedit', compact('title','city','admin','logo'));    
        
        
    }
    
    public function cityupdate(Request $request)
    {
        $title = "Update City";
        $city_id = $request->city_id;
        $city = $request->city;
        $cities = ucfirst($city);
        $this->validate(
            $request,
                [
                    
                    'city'=>'required',
                ],
                [
                    
                    'city.required'=>'City Name Required',

                ]
        );
        
        
        $check = DB::table('city')
    	       ->where('city_id',$city_id)
    	       ->first();
        
    	 $insert = DB::table('city')
    	            ->where('city_id',$city_id)
                    ->update([
                        'city_name'=>$cities,
                        ]);
                        
                        
        if ($insert){               
        DB::table('store')
        ->where('city',$check->city_name)
        ->update(['city'=>$cities]);
        
         DB::table('delivery_boy')
         ->where('boy_city',$check->city_name)
        ->update(['boy_city'=>$cities]);
        
        DB::table('address')
         ->where('city',$check->city_name)
        ->update(['city'=>$cities]);
        
        return redirect()->back()->withSuccess('City Updated Successfully');
        }else{
          return redirect()->back()->withErrors('Something Wents Wrong');  
        }
    }
    
    public function citydelete(Request $request)
    {
        
                    $city_id=$request->city_id;
            
                    $city= DB::table('city')
                            ->where('city_id',$city_id)
                            ->first();
            
                	$delete=DB::table('city')->where('city_id',$request->city_id)->delete();
                	
                    if($delete)
                    {
                     DB::table('store')
                    ->where('city',$city->city_name)
                    ->delete();
                    
                     DB::table('delivery_boy')
                     ->where('boy_city',$city->city_name)
                    ->delete();
                    
                      DB::table('address')
                     ->where('city',$city->city_name)
                    ->delete();
                    
                     DB::table('society')->where('city_id',$request->city_id)->delete();
                    return redirect()->back()->withSuccess('Delete successfully');
            
                    }
                    else
                    {
                       return redirect()->back()->withErrors('Something Wents Wrong'); 
                    }
    }
}
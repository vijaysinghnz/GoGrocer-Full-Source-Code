<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class DeliveryController extends Controller
{
    public function list(Request $request)
    {
        $title = "Delivery Boy List";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
           $d_boy = DB::table('delivery_boy')
                    ->paginate(10);
        
    	return view('admin.d_boy.list', compact('title',"admin", "logo","d_boy"));
    }

    
     public function AddD_boy(Request $request)
    {
    
        $title = "Add Delivery Boy";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
           $d_boy = DB::table('delivery_boy')
                    ->get();
        $city =DB::table('city')
              ->get();
              
         $map1 = DB::table('map_API')
             ->first();
         $map = $map1->map_api_key;       
        
        return view('admin.d_boy.add',compact("d_boy", "admin_email","logo", "admin","title", 'city','map'));
     }
    
     public function AddNewD_boy(Request $request)
    {
        $boy_name = $request->boy_name;
        $boy_phone =$request->boy_phone;
        $password = $request->password;
        $boy_loc = $request->boy_loc;
        $city =$request->city;
        $status = 1;
        $date=date('d-m-Y');
       
        $addres = str_replace(" ", "+", $boy_loc);
        $address1 = str_replace("-", "+", $addres);
         $mapapi = DB::table('map_API')
                 ->first();
                 
                    
        $chkboyrphon = DB::table('delivery_boy')
                      ->where('boy_phone', $boy_phone)
                      ->first(); 

        if($chkboyrphon){
             return redirect()->back()->withErrors('This Phone Number Is Already Registered With Another Delivery Boy');
        } 
                 
        $key = $mapapi->map_api_key;         
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=".$key));
        
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
    
        
        $this->validate(
            $request,
                [
                    
                    'boy_name' => 'required',
                    'boy_phone' => 'required',
                    'password' => 'required',
                    'boy_loc'=> 'required',
                    'city'=>'required',
                    
                ],
                [
                    'boy_name.required' => 'Enter Boy Name.',
                    'boy_phone.required' => 'Choose Boy Phone.',
                    'password.required' => 'choose password',
                    'boy_loc.required' => 'enter boy location',
                    'city.required' => 'enter boy city',
                ]
        );


        $insert = DB::table('delivery_boy')
                            ->insert([
                                'boy_name'=>$boy_name,
                                'boy_phone'=>$boy_phone,
                                'boy_city'=>$city,
                                'password'=>$password,
                                'boy_loc'=>$boy_loc,
                                'lat'=>$lat,
                                'lng'=>$lng,
                                'status'=>$status,
                               
                            ]);
        
        if($insert){
            return redirect()->back()->withSuccess('Delivery Boy Added Successfully');
        }
        else{
            return redirect()->back()->withErrors("Something Wents Wrong");
        }
      
    }
    
    public function EditD_boy(Request $request)
    {
        
         $dboy_id = $request->id;
         $title = "Edit Delivery Boy";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
                    
        $d_boy=  DB::table('delivery_boy')
            ->where('dboy_id', $dboy_id)
            ->first();
        $city =DB::table('city')
              ->get();
              
         $map1 = DB::table('map_API')
             ->first();
         $map = $map1->map_api_key; 
        return view('admin.d_boy.edit',compact("d_boy","admin_email","admin","logo","title","city","map"));
    }

    public function UpdateD_boy(Request $request)
    {
       $dboy_id = $request->id;
       $boy_name = $request->boy_name;
       $boy_phone =$request->boy_phone;
       $password = $request->password;
       $boy_loc = $request->boy_loc;
       $city =$request->city;
      
         $addres = str_replace(" ", "+", $boy_loc);
        $address1 = str_replace("-", "+", $addres);
        
     $chkboyrphon = DB::table('delivery_boy')
                  ->where('boy_phone', $boy_phone)
                  ->where('dboy_id','!=',$dboy_id)
                 ->first(); 

        if($chkboyrphon){
             return redirect()->back()->withErrors('This Phone Number Is Already Registered With Another Delivery Boy');
        } 
        
         $mapapi = DB::table('map_API')
                 ->first();
                 
        $key = $mapapi->map_api_key;         
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$address1."&key=".$key));
        
         $lat = $response->results[0]->geometry->location->lat;
         $lng = $response->results[0]->geometry->location->lng;
    
        
         $this->validate(
            $request,
                [
                    
                    'boy_name' => 'required',
                    'boy_phone' => 'required',
                    'password' => 'required',
                    'boy_loc'=> 'required',
                    'city'=>'required'
                    
                ],
                [
                    'boy_name.required' => 'Enter Boy Name.',
                    'boy_phone.required' => 'Choose Boy Phone.',
                    'password.required' => 'choose password',
                    'boy_loc.required' => 'enter boy location',
                    'city.required' => 'enter boy city'
                ]
        );


        $updated = DB::table('delivery_boy')
                   ->where('dboy_id', $dboy_id)
                    ->update([
                        'boy_name'=>$boy_name,
                        'boy_phone'=>$boy_phone,
                        'boy_city'=>$city,
                        'password'=>$password,
                        'boy_loc'=>$boy_loc,
                        'lat'=>$lat,
                        'lng'=>$lng
                       
                    ]);

        if($updated){
            return redirect()->back()->withSuccess('Delivery Boy Updated Successfully');
        }
        else{
            return redirect()->back()->withErrors("Something Wents Wrong");
        }
       
       
       
       
    }
    
    
    
 public function DeleteD_boy(Request $request)
    {
        $dboy_id = $request->id;

    	$delete=DB::table('delivery_boy')
             ->where('dboy_id', $dboy_id)->delete();
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
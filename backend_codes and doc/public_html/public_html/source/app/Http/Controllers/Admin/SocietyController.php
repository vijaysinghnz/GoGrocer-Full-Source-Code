<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class SocietyController extends Controller
{
    public function societylist(Request $request)
    {
         $title = "Home";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        
        $city = DB::table('society')
                ->join('city','society.city_id','=','city.city_id')
                ->get();
                
        return view('admin.society.societylist', compact('title','city','logo','admin'));    
        
        
    }
    public function society(Request $request)
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
        return view('admin.society.societyadd', compact('title','city','admin','logo','map'));    
        
        
    }
    public function societyadd(Request $request)
    {
        $title = "Home";
        
        $society = $request->society;
        $city = $request->city;
        
        $this->validate(
            $request,
                [
                    
                    'society'=>'required',
                ],
                [
                    
                    'society.required'=>'Society Name Required',

                ]
        );
        
         $urlencode= str_replace(",","",$society);
                                $urlencode=urlencode("$urlencode"). "\n";
                                //echo $urlencode= str_replace("",",",$urlencode);
                                $response=json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$urlencode."&key=AIzaSyDq6a7_3mqLmO1mcnxJMkehXRdvfk1lB1E"));
                                $lat=$response->results[0]->geometry->location->lat;
                                $lon=$response->results[0]->geometry->location->lng;
        
    	 $insert = DB::table('society')
                    ->insert([
                        'society_name'=>$society,
                        'city_id'=>$city,
                        ]);
     
        return redirect()->back()->withSuccess('Added Successfully');

    }
    
    public function societyedit(Request $request)
    {
         $title = "Home";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $society_id = $request->society_id;
        
        $cities = DB::table('city')
                ->get();
        
        $city = DB::table('society')
                ->where('society_id',$society_id)
                ->first();
          $map1 = DB::table('map_API')
             ->first();
         $map = $map1->map_api_key;        
        return view('admin.society.societyedit', compact('title','city','cities','admin','logo','map'));    
        
        
    }
    
    public function societyupdate(Request $request)
    {
        $title = "Home";
        $society_id = $request->society_id;
        $society = $request->society;
        $city = $request->city;
        
         $this->validate(
            $request,
                [
                    
                    'society'=>'required',
                ],
                [
                    
                    'society.required'=>'Society Name Required',

                ]
        );
        
        	 $check = DB::table('society')
    	            ->where('society_id',$society_id)
    	            ->first();
        
    	 $insert = DB::table('society')
    	            ->where('society_id',$society_id)
                    ->update([
                        'society_name'=>$society,
                        'city_id'=>$city,
                        ]);
     
     
        if($insert){
           DB::table('address')
            ->where('society',$check->society_name)
            ->update(['society'=>$society]);
            return redirect()->back()->withSuccess('Updated Successfully.');
        }else{
             return redirect()->back()->withErrors('Something went Wrong.');
        }
    }
    
    public function societydelete(Request $request)
    {
        
                    $society_id=$request->society_id;
            
                    $city= DB::table('society')
                            ->where('society_id',$society_id)
                            ->first();
            
                	$delete=DB::table('society')->where('society_id',$request->society_id)->delete();
                    if($delete)
                    {
                      DB::table('address')
                        ->where('society',$city->society_name)
                        ->delete();
                    return redirect()->back()->withSuccess('Deleted successfully');
            
                    }
                    else
                    {
                       return redirect()->back()->withErrors('Something Wents Wrong'); 
                    }
    }
}
<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class AddressController extends Controller
{
     public function address(Request $request)
    {
            $user_id = $request->user_id;
            $unselect= DB::table('address')
                     ->where('user_id' ,$user_id)
                     ->get();
                     
            if(count($unselect)>0){
            $unselect= DB::table('address')
                     ->where('user_id' ,$user_id)
                     ->update(['select_status' => 0]);
            }
            $receiver_name = $request->receiver_name;
            $receiver_phone = $request->receiver_phone;
            $city = $request->city_name;
            $society = $request->society_name;
            $house_no = $request->house_no;
            $landmark = $request->landmark;
            $state = $request->state;
            $pin = $request->pin;
            $lat = $request->lat;
            $lng = $request->lng;
            $status= 1;
            $added_at= Carbon::Now();
        
    	    
    	    $insertaddress = DB::table('address')
    						->insert([
    							'user_id'=>$user_id,
    							'receiver_name'=>$receiver_name,
    							'receiver_phone'=>$receiver_phone,
    							'city'=>$city,
    							'society'=>$society,
    							'house_no'=>$house_no,
    							'landmark'=> $landmark,
    							'state'=>$state,
    							'pincode'=>$pin,
    							'select_status'=>1,
    							'lat' => $lat,
    							'lng' => $lng,
    							'added_at'=>$added_at
                            ]);
                            
          if($insertaddress){
                $message = array('status'=>'1', 'message'=>'Address Saved');
                return $message;
                            }		
          else{
                 $message = array('status'=>'0', 'message'=>'something went wrong');
	            return $message;
    	}
      }
      
    public function city(Request $request)
    {
    $city= DB::table('city')
         ->get();
         
       if(count($city)>0){
                $message = array('status'=>'1', 'message'=>'city list','data'=>$city);
                return $message;
                            }		
          else{
                 $message = array('status'=>'0', 'message'=>'city not found', 'data'=>[]);
	            return $message;
    	}    
    }
    
    public function society(Request $request)
    {
    $city_name = $request->city_name;
    $city = ucfirst($city_name);
    
   
    
    $society= DB::table('society')
         ->join('city', 'society.city_id','=','city.city_id')
         ->where('city.city_name',$city)
         ->get();
         
    
         
       if(count($society)>0){
                $message = array('status'=>'1', 'message'=>'Society list','data'=>$society);
                return $message;
                            }		
          else{
                 $message = array('status'=>'0', 'message'=>'Society not found', 'data'=>[]);
	            return $message;
    	}    
     }
     
     
   public function show_address(Request $request)
    {
    $user_id = $request->user_id;
    $store_id = $request->store_id;
    
   $store = DB::table('store')
       ->where('store_id', $store_id)
       ->first();
       
       
    $address = DB::table('address')
         ->where('user_id',$user_id)
         ->where('select_status','!=',2)
         ->select('address.*',DB::raw("6371 * acos(cos(radians(".$store->lat . ")) 
                    * cos(radians(address.lat)) 
                    * cos(radians(address.lng) - radians(" . $store->lng . ")) 
                    + sin(radians(" .$store->lat. ")) 
                    * sin(radians(address.lat))) AS distance"))
                    ->having('distance','<=',$store->del_range)
                    ->where('address.city', $store->city)
                  ->get();
    
         
       if(count($address)>0){
                $message = array('status'=>'1', 'message'=>'Address list','data'=>$address);
                return $message;
                            }		
          else{
                 $message = array('status'=>'0', 'message'=>'Address not found! Add Address', 'data'=>[]);
	            return $message;
    	}    
     }
     
     
public function select_address(Request $request)
    {
    $address_id = $request->address_id;
    $user = DB::table('address')
         ->where('address_id',$address_id)
         ->first();
    $checkuser = $user->user_id;  
    $select1 = DB::table('address')
         ->where('user_id',$checkuser)
         ->update(['select_status'=> 0]);
       if($select1){
             $select = DB::table('address')
         ->where('address_id',$address_id)
         ->update(['select_status'=> 1]);
                $message = array('status'=>'1', 'message'=>'Address Selected');
                return $message;
                            }		
          else{
                 $message = array('status'=>'0', 'message'=>'cannot select please try again later');
	            return $message;
    	}    
     }     
     
public function rem_user_address(Request $request)
    {
    $address_id = $request->address_id;
    $checkcart = DB::table('orders')
               ->where('address_id', $address_id)
               ->get();
    if(count($checkcart)==0) {
        $deladdress= DB::table('address')
         ->where('address_id',$address_id)
         ->delete();
        
    }  
    else{
    $deladdress= DB::table('address')
         ->where('address_id',$address_id)
         ->update(['select_status'=>2]);
    }
  
       if($deladdress){
         
                $message = array('status'=>'1', 'message'=>'Address Removed');
                return $message;
                            }		
          else{
                 $message = array('status'=>'0', 'message'=>'Try Again Later');
	            return $message;
    	}    
     }     
          
     
      
public function edit_add(Request $request)
    {
           $address_id = $request->address_id;
           $lat= $request->lat;
           $lng = $request->lng;
           $user_id = $request->user_id;
            $unselect= DB::table('address')
                     ->where('user_id' ,$user_id)
                     ->get();
                     
            if(count($unselect)>0){
            $unselect= DB::table('address')
                     ->where('user_id' ,$user_id)
                     ->update(['select_status'=> 0]);
            }
            
            $receiver_name = $request->receiver_name;
            $receiver_phone = $request->receiver_phone;
            $city = $request->city_name;
            $society = $request->society_name;
            $house_no = $request->house_no;
            $landmark = $request->landmark;
            $state = $request->state;
            $pin = $request->pin;
            $status= 1;
         
            $added_at= Carbon::Now();
      
    	    
    	    $insertaddress = DB::table('address')
    	                  ->where('address_id', $address_id)
    						->update([
    							'receiver_name'=>$receiver_name,
    							'receiver_phone'=>$receiver_phone,
    							'city'=>$city,
    							'society'=>$society,
    							'house_no'=>$house_no,
    							'landmark'=> $landmark,
    							'state'=>$state,
    							'pincode'=>$pin,
    							'select_status'=>1,
    							'lat' => $lat,
    							'lng' => $lng,
    							'updated_at'=>$added_at
                            ]);
                            
          if($insertaddress){
                $message = array('status'=>'1', 'message'=>'Address Saved');
                return $message;
                            }		
          else{
                 $message = array('status'=>'0', 'message'=>'something went wrong');
	            return $message;
    	}  
     }  
      
}
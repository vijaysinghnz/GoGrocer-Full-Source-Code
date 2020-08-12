<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;

class LoginController extends Controller
{
  public function storeLogin(Request $request)
  {
    if(Session::has('bamaStore')){
        return redirect()->route('storeHome');    
    }
    
    $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
                
  	return view('store.auth.login', compact('logo'));
  }

  public function storeLoginCheck(Request $request)
  {	
  	$email = $request->email;
    $password = $request->password;

    $storeLoginCheck = DB::table('store')
                      ->where('email',$email)
            			    ->first();

    if($storeLoginCheck){
      if ($password==$storeLoginCheck->password) {
        Session::put('bamaStore', $email);
        Session::save();
        return redirect()->route('storeHome');
      }
      else{
        return redirect()->route('storeLogin')->withErrors('Wrong Password');
      }
    }
    else{
      return redirect()->route('storeLogin')->withErrors('Email/Password Wrong');
    }
  }
  
  
  public function logout(Request $request)
  {	
 	Session::forget('bamaStore');
 	return redirect()->route('storeLogin')->withSuccess("Store logged out.");
  }
}

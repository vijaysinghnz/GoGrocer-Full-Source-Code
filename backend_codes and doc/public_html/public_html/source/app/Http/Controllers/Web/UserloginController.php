<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;

class UserloginController extends Controller
{
  public function userlogin(Request $request)
  {
    if(Session::has('bamaCust')){
        return redirect()->route('webhome');    
    }
    
    $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
                
  	return view('web.auth.login', compact('logo'));
  }

  public function logincheck(Request $request)
  {	
  	$phone= $request->phone;
    $password = $request->password;

    $custLoginCheck = DB::table('users')
                    ->where('user_phone', $phone)
            	    ->first();

    if($custLoginCheck){
      if ($password==$custLoginCheck->user_password) {
        Session::put('bamaCust', $phone);
        Session::save();
        return redirect()->route('webhome');
      }
      else{
        return redirect()->route('userLogin')->withErrors('Wrong Password');
      }
    }
    else{
      return redirect()->route('userLogin')->withErrors('Phone/Password Wrong');
    }
  }
  
  
  public function logout(Request $request)
  {	
 	Session::forget('bamaCust');
 	return redirect()->route('userLogin')->withSuccess("User logged out.");
  }
}

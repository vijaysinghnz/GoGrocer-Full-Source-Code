<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Session;

class LoginController extends Controller
{
  public function adminLogin(Request $request)
  {
    if(Session::has('bamaAdmin')){
        return redirect()->route('adminHome');    
    }
    
    $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
                
  	return view('admin.auth.login', compact('logo'));
  }

  public function adminLoginCheck(Request $request)
  {	
  	$email = $request->email;
    $password = $request->password;

    $adminLoginCheck = DB::table('admin')
                      ->where('admin_email',$email)
            			    ->first();

    if($adminLoginCheck){
      if (Hash::check($password, $adminLoginCheck->admin_pass)) {
        Session::put('bamaAdmin', $email);
        Session::save();
        return redirect()->route('adminHome');
      }
      else{
        return redirect()->route('adminLogin')->withErrors('Wrong Password');
      }
    }
    else{
      return redirect()->route('adminLogin')->withErrors('Email/Password Wrong');
    }
  }
  
  
  public function logout(Request $request)
  {	
 	Session::forget('bamaAdmin');
 	return redirect()->route('adminLogin')->withErrors("logged out.");
  }
}

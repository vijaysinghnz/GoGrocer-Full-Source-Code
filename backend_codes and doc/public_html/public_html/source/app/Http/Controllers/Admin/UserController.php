<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $title = "App User List";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
           $users = DB::table('users')
                   ->orderBy('reg_date','desc')
                    ->paginate(20);
        
    	return view('admin.user.list', compact('title',"admin", "logo","users"));
    }
    
     public function block(Request $request)
    {
        
        $user_id = $request->id;
         $users = DB::table('users')
                ->where('user_id',$user_id)
                ->update(['block'=>1]);
    if($users){   
    return redirect()->back()->withSuccess('User Blocked Successfully');
    }
    else{
      return redirect()->back()->withErrors('Something Wents Wrong');   
    }
    }
    
     public function unblock(Request $request)
    {
        
        $user_id = $request->id;
         $users = DB::table('users')
                ->where('user_id',$user_id)
                ->update(['block'=>2]);
                
     if($users){   
    return redirect()->back()->withSuccess('User Unblocked Successfully');
    }
    else{
      return redirect()->back()->withErrors('Something Wents Wrong');   
    }
    }
}
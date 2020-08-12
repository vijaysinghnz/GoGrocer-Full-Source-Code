<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class WebHomeController extends Controller
{
    public function web(Request $request)
    {
        $title = "Home";
         $cust_phone=Session::get('bamaCust');
    	 $cust= DB::table('users')
    	 		   ->where('user_phone',$cust_phone)
    	 		   ->first();
                 	
    	return view('web.home.main', compact('title','cust','cust_phone'));
    }
    
     public function aboutus(Request $request)
    {
        $cust_phone=Session::get('bamaCust');
    	 $cust= DB::table('users')
    	 		   ->where('user_phone',$cust_phone)
    	 		   ->first();
        $title = "About Us";
        $about = DB::table('aboutuspage')
                ->first();
                 	
    	return view('web.about', compact('title','about','cust','cust_phone'));
    }
     public function terms(Request $request)
    {
        $cust_phone=Session::get('bamaCust');
    	 $cust= DB::table('users')
    	 		   ->where('user_phone',$cust_phone)
    	 		   ->first();
        
        $title = "About Us";
        $about = DB::table('termspage')
                ->first();
                 	
    	return view('web.terms', compact('title','about','cust','cust_phone'));
    }
}

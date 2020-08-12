<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PagesController extends Controller
{
 
    public function appaboutus(Request $request)
    {
          $about_us = DB::table('aboutuspage')
                      ->first();
                      
        if($about_us)   { 
            $message = array('status'=>'1', 'message'=>'About us', 'data'=>$about_us);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }

        return $message;
    }
    
    
    public function appterms(Request $request)
    {
          $terms = DB::table('termspage')
                      ->first();
                      
        if($terms)   { 
            $message = array('status'=>'1', 'message'=>'Terms & Condition', 'data'=>$terms);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }

        return $message;
    }
}

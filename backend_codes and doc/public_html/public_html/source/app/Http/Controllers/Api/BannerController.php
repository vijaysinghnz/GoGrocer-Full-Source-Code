<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class BannerController extends Controller
{
   public function bannerlist(Request $request)
    {  
        $banner = DB::table('banner')
                ->get();
        
         if(count($banner)>0){
            $message = array('status'=>'1', 'message'=>'Banner List', 'data'=>$banner);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'No banner Found', 'data'=>[]);
            return $message;
        }
    }
    
    public function secbannerlist(Request $request)
    {  
        $banner = DB::table('secondary_banner')
                ->get();
        
         if(count($banner)>0){
            $message = array('status'=>'1', 'message'=>'Secondary Banner List', 'data'=>$banner);
            return $message;
            }
        else{
            $message = array('status'=>'0', 'message'=>'No Banner Found', 'data'=>[]);
            return $message;
        }
    }
}
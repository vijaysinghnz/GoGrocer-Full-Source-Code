<?php 

namespace App\Composers;

use DB;
use Session;
use Hash;

class CustComposer
{

    public function compose($view)
    {
        if(Session::has('bamaCust')){
        	$user_phone = Session::get('bamaCust');

        	$users = DB::table('users')
        				->where('user_phone', $user_phone)
        				->first();

        	$web = DB::table('tbl_web_setting')
        			->get();

            //Add your variables
        
             $view->with('user_name', $users->user_name);
        }
    }
}
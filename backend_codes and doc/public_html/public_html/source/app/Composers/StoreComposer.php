<?php 

namespace App\Composers;

use DB;
use Session;
use Hash;

class StoreComposer
{

    public function compose($view)
    {
        if(Session::has('bamaStore')){
        	$store_email = Session::get('bamaStore');

        	$store = DB::table('store')
        				->where('email', $store_email)
        				->first();

        	$web = DB::table('tbl_web_setting')
        			->get();

            //Add your variables
        
             $view->with('store_name', $store->store_name);
        }
    }
}
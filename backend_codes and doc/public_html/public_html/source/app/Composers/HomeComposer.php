<?php 

namespace App\Composers;

use DB;
use Session;
use Hash;

class HomeComposer
{

    public function compose($view)
    {
        if(Session::has('bamaAdmin')){
        	$admin_email = Session::get('bamaAdmin');

        	$admin = DB::table('admin')
        				->where('admin_email', $admin_email)
        				->first();

        	$web = DB::table('tbl_web_setting')
        			->get();

            //Add your variables
        
             $view->with('admin_name', $admin->admin_name)
                  ->with('admin_image', $admin->admin_image);
        }
    }
}
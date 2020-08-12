<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Session;
use Hash;

class ProfileController extends Controller
{
    public function adminProfile(Request $request)
    {
    	 $title = "Edit Profile";
    	 $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();		   
    	
           return view('admin.profile.profile',compact("admin_email","admin",'logo',"title"));

    }
   

    public function adminUpdateProfile(Request $request)
    {
        $admin_id = $request->id;
        $admin_name = $request->admin_name;
        $admin_email = $request->admin_email;
        $old_admin_image = $request->old_admin_image;
        $updated_at = date("d-m-y h:i a");
        $date=date('d-m-y');
        
        $this->validate(
            $request,
                [
                    'admin_name' => 'required',
                    'admin_email' => 'required'
                ],
                [
                    'admin_name.required' => 'Enter your name.',
                    'admin_email.required' => 'Enter new email.'
                ]
        );

        $getImage = DB::table('admin')
                        ->where('id', $admin_id)
                        ->first();

        $image = $getImage->admin_image;  

        if($request->hasFile('admin_image')){
             if(file_exists($image)){
                unlink($image);
            }
            $admin_image = $request->admin_image;
            $fileName = date('dmyhisa').'-'.$admin_image->getClientOriginalName();
            $fileName = str_replace(" ", "-", $fileName);
            $admin_image->move('images/admin/profile/'.$date.'/', $fileName);
            $admin_image = 'images/admin/profile/'.$date.'/'.$fileName;
        }
        else{
            $admin_image = $image;
        }

        $adminChangeProfile = DB::table('admin')
                                ->where('id', $admin_id)
                                ->update(['admin_name'=>$admin_name, 'admin_email'=>$admin_email,'admin_image'=>$admin_image]);

        if($adminChangeProfile){

             session::put('bamaAdmin',$admin_email);

            return redirect()->back()->withSuccess('profile updated successfully');
        }
        else{
            return redirect()->back()->withErrors("Something Wents Wrong.");
        }
    }

    public function adminChangePass(Request $request)
    {
        $title = "Change Password";
         $admin_email=Session::get('bamaAdmin');
    	 $admin= DB::table('admin')
    	 		   ->where('admin_email',$admin_email)
    	 		   ->first();
    	  $logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();	
           return view('admin.profile.change_pass',compact("admin_email","admin","logo","title"));
           
       
    }


   public function adminChangePassword(Request $request)
    {
        $this->validate(
            $request,
                [
                    'current_pass' => 'required',
                    'new_pass' => 'required',
                ],
                [
                    'current_pass.required' => 'Enter current password.',
                    'new_pass.required' => 'Enter new password.',
                ]
           );

        $admin_id = $request->id;
        $current_pass = $request->current_pass;
        // $current_pass =Hash::make($current_pass1);
        $getAdmin = DB::table('admin')
                    ->where('id', $admin_id)
                    ->first();

        if(Hash::check($current_pass,$getAdmin->admin_pass))
            {
            $new_pass = Hash::make($request->new_pass);
            $updated_at = date("d-m-y h:i a");

            $adminChangePassword = DB::table('admin')
                                    ->where('id', $admin_id)
                                    ->update(['admin_pass'=>$new_pass]);

            if($adminChangePassword)
            {
                return redirect()->back()->withSuccess("password changed!");
            }
            else{
                return redirect()->back()->withErrors("something wents wrong.");
            }
        }
        else{
            return redirect()->back()->withErrors("current password does not match.");
        }
     }
     public function adminLogout(Request $request)
     {
          $request->session()->flush();
           return redirect()->route('adminlogin')->withSuccess("Logout Successfully");

     }
}

 
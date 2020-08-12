<?php

namespace App\Traits;
use DB;
use Mail;


trait SendMail {
    
    
      public function payoutMail($amt,$store_name,$user_email,$app_name) {
       
        $data = array('to' => $user_email, 'from' => 'noreply@gogrocer.in', 'to-name'=>$store_name, 'from-name' => $app_name);

        Mail::send('admin.mail.payout', compact('amt', 'store_name', 'user_email'), function ($m) use ($data){
                $m->from($data['from'], $data['from-name']);
                $m->to($data['to'], $data['to-name'])->subject("Admin paid to you");
            });
            
        return "send";
    }
    
      public function codorderplacedMail($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name) {
       $logo = DB::table('tbl_web_setting')
             ->first();
       $app_name = $logo->name;
       
        $data = array('to' => $user_email, 'from' => 'noreply@gogrocer.in', 'to-name'=>$user_name, 'from-name' => $app_name);

        Mail::send('admin.mail.codorderplaced', compact('cart_id', 'prod_name', 'price2', 'delivery_date', 'time_slot'), function ($m) use ($data){
                $m->from($data['from'], $data['from-name']);
                $m->to($data['to'], $data['to-name'])->subject("Order Successfully Placed");
            });
            
        return "send";
    }
    
     public function orderplacedMail($cart_id,$prod_name,$price2,$delivery_date,$time_slot,$user_email,$user_name) {
       $logo = DB::table('tbl_web_setting')
             ->first();
       $app_name = $logo->name;
       
        $data = array('to' => $user_email, 'from' => 'noreply@gogrocer.in', 'to-name'=>$user_name, 'from-name' => $app_name);

        Mail::send('admin.mail.orderplaced', compact('cart_id', 'prod_name', 'price2', 'delivery_date', 'time_slot'), function ($m) use ($data){
                $m->from($data['from'], $data['from-name']);
                $m->to($data['to'], $data['to-name'])->subject("Order Successfully Placed");
            });
            
        return "send";
    }
    
    
    
     public function coddeloutMail($cart_id, $prod_name, $price2, $user_email, $user_name, $rem_price) {
        $currency = DB::table('currency')
                  ->first();
       $logo = DB::table('tbl_web_setting')
             ->first();
       $app_name = $logo->name;
       
        $data = array('to' => $user_email, 'from' => 'noreply@gogrocer.in', 'to-name'=>$user_name, 'from-name' => $app_name);

        Mail::send('admin.mail.coddel_out', compact('cart_id', 'prod_name', 'price2','currency','rem_price'), function ($m) use ($data){
                $m->from($data['from'], $data['from-name']);
                $m->to($data['to'], $data['to-name'])->subject("Out For Delivery");
            });
            
        return "send";
    }
    
    public function deloutMail($cart_id, $prod_name, $price2,$user_email, $user_name,$rem_price) {
        $currency = DB::table('currency')
                  ->first();
       $logo = DB::table('tbl_web_setting')
             ->first();
       $app_name = $logo->name;
       
        $data = array('to' => $user_email, 'from' => 'noreply@gogrocer.in', 'to-name'=>$user_name, 'from-name' => $app_name);

        Mail::send('admin.mail.del_out', compact('cart_id', 'prod_name', 'price2','currency','rem_price'), function ($m) use ($data){
                $m->from($data['from'], $data['from-name']);
                $m->to($data['to'], $data['to-name'])->subject("Out For Delivery");
            });
            
        return "send";
    }
    
      public function delcomMail($cart_id, $prod_name, $price2,$user_email, $user_name) {
       $logo = DB::table('tbl_web_setting')
             ->first();
       $app_name = $logo->name;
       $curr =  DB::table('currency')
             ->first();
       $currency_sign = $curr->currency_sign;
        $data = array('to' => $user_email, 'from' => 'noreply@gogrocer.in', 'to-name'=>$user_name, 'from-name' => $app_name);

        Mail::send('admin.mail.del_com', compact('cart_id', 'prod_name', 'price2','currency_sign'), function ($m) use ($data){
                $m->from($data['from'], $data['from-name']);
                $m->to($data['to'], $data['to-name'])->subject("Delivery Completed");
            });
            
        return "send";
    }
    
    
     public function rechargeMail($user_id,$user_name, $user_email, $user_phone,$add_to_wallet) {
       $logo = DB::table('tbl_web_setting')
             ->first();
       $app_name = $logo->name;
       $currency = DB::table('currency')
               ->first();
       
        $data = array('to' => $user_email, 'from' => 'noreply@gogrocer.in', 'to-name'=>$user_name, 'from-name' => $app_name);

        Mail::send('admin.mail.recharge', compact('add_to_wallet', 'user_id','currency','add_to_wallet'), function ($m) use ($data){
                $m->from($data['from'], $data['from-name']);
                $m->to($data['to'], $data['to-name'])->subject("Recharge Successful.");
            });
            
        return "send";
    }
     public function sendrejectmail($cause,$user,$cart_id) {
        
       $logo = DB::table('tbl_web_setting')
             ->first();
       $app_name = $logo->name;
       $currency = DB::table('currency')
               ->first();
       
        $data = array('to' => $user->user_email, 'from' => 'noreply@gogrocer.in', 'to-name'=>$user->user_name, 'from-name' => $app_name);

        Mail::send('admin.mail.rejectmail', compact('cause', 'user', 'cart_id'), function ($m) use ($data){
                $m->from($data['from'], $data['from-name']);
                $m->to($data['to'], $data['to-name'])->subject("Order Cancelled.");
            });
            
        return "send";
     }
}
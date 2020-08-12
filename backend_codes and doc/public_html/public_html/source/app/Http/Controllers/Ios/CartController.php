<?php

namespace App\Http\Controllers\Ios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Traits\SendMail;
use App\Traits\SendSms;

class CartController extends Controller
{
   use SendMail; 
   use SendSms;
   public function add_to_cart(Request $request)
    {   
        $current = Carbon::now();
        $user_id= $request->user_id;
        $qty = $request->qty;
        $varient_id = $request->varient_id;
        $order_status = "incart";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $val = "";
                for ($i = 0; $i < 4; $i++){
                    $val .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
        $chars2 = "0123456789";
                $val2 = "";
                for ($i = 0; $i < 2; $i++){
                    $val2 .= $chars2[mt_rand(0, strlen($chars2)-1)];
                }        
        $cr  = substr(md5(microtime()),rand(0,26),2);
        $cart_id = $val.$val2.$cr;
        $created_at = Carbon::now();
        $ph = DB::table('users')
                  ->select('user_phone','wallet')
                  ->where('user_id',$user_id)
                  ->first();
        $user_phone = $ph->user_phone;
        $p = DB::table('product_varient')
            ->join('product','product_varient.product_id','=','product.product_id')
           ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
           ->where('product_varient.varient_id',$varient_id)
           ->first();
         if($p->deal_price != NULL &&  $p->valid_from < $current && $p->valid_to > $current){
          $price= $p->deal_price;    
        }else{
      $price = $p->price;
        } 
        
        $mrpprice = $p->mrp;
        $price2= $price*$qty;
        $price5=$mrpprice*$qty;
     
       
        $n =$p->product_name;
      
        $check = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('varient_id',$varient_id)
            ->where('order_cart_id', "incart")
            ->first();
     if(!$check){

        $insert = DB::table('store_orders')
                ->insert([
                        'varient_id'=>$varient_id,
                        'qty'=>$qty,
                        'product_name'=>$n,
                        'varient_image'=>$p->varient_image,
                        'quantity'=>$p->quantity,
                        'unit'=>$p->unit,
                        'store_approval'=>$user_id,
                        'total_mrp'=>$price5,
                        'order_cart_id'=>"incart",
                        'order_date'=>$created_at,
                        'price'=>$price2]);
      
     }
     else{
          $del = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('varient_id',$varient_id)
            ->where('order_cart_id', "incart")
            ->delete();
     
         $insert = DB::table('store_orders')
                ->insert([
                        'varient_id'=>$varient_id,
                        'qty'=>$qty,
                        'product_name'=>$n,
                        'varient_image'=>$p->varient_image,
                        'quantity'=>$p->quantity,
                        'unit'=>$p->unit,
                        'store_approval'=>$user_id,
                        'total_mrp'=>$price5,
                        'order_cart_id'=>"incart",
                        'order_date'=>$created_at,
                        'price'=>$price2]);
         
     }

   
 
  if($insert){
      $del = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('varient_id',$varient_id)
            ->where('qty', 0)
            ->delete();
      $sum = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('order_cart_id', "incart")
            ->select(DB::raw('SUM(store_orders.price) as sum'))
            ->first();
            
            
      $checkitems = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('order_cart_id', "incart")
            ->get();
            
     if(count($checkitems)==0)  {
         $checkitems = [];
     }    
     
     if(!$sum)  {
         $sump= 0;
     }   
     else{
         $sump = $sum->sum;
     }
      
      
        	$message = array('status'=>'1', 'message'=>'Added to cart', 'total_price'=>$sump, 'cart_items'=>$checkitems);
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
       
 }
 
  public function make_an_order(Request $request)
    {   
        $current = Carbon::now();
        $user_id= $request->user_id;
        $delivery_date = $request-> delivery_date;
        $time_slot= $request->time_slot;
        $store_id = $request->store_id;
        $data_array = DB::table('store_orders')
              ->where('store_approval', $user_id)
              ->where('order_cart_id',"incart")
              ->get();
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $val = "";
                for ($i = 0; $i < 4; $i++){
                    $val .= $chars[mt_rand(0, strlen($chars)-1)];
                }
                
        $chars2 = "0123456789";
                $val2 = "";
                for ($i = 0; $i < 2; $i++){
                    $val2 .= $chars2[mt_rand(0, strlen($chars2)-1)];
                }        
        $cr  = substr(md5(microtime()),rand(0,26),2);
        $cart_id = $val.$val2.$cr;
        $ar= DB::table('address')
            ->select('society','city','lat','lng','address_id')
            ->where('user_id', $user_id)
            ->where('select_status', 1)
            ->first();
       if(!$ar){
           	$message = array('status'=>'0', 'message'=>'Select any Address');
        	return $message;
       }
        $created_at = Carbon::now();
        $user_id= $request->user_id;
        $price2=0;
        $price5=0;
        $ph = DB::table('users')
                  ->select('user_phone','wallet')
                  ->where('user_id',$user_id)
                  ->first();
        $user_phone = $ph->user_phone;
      
       
    foreach ($data_array as $h){
        $varient_id = $h->varient_id;
        $p = DB::table('product_varient')
            ->join('product','product_varient.product_id','=','product.product_id')
           ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
           ->where('product_varient.varient_id',$varient_id)
           ->first();
         if($p->deal_price != NULL &&  $p->valid_from < $current && $p->valid_to > $current){
          $price= $p->deal_price;    
        }else{
      $price = $p->price;
        } 
        
        $mrpprice = $p->mrp;
        $order_qty = $h->qty;
        $price2+= $price*$order_qty;
        $price5+=$mrpprice*$order_qty;
        $unit[] = $p->unit;
        $qty[]= $p->quantity;
        $p_name[] = $p->product_name."(".$p->quantity.$p->unit.")*".$order_qty;
        $prod_name = implode(',',$p_name);
        
    }    
    
    foreach ($data_array as $h)
    { 
        $varient_id = $h->varient_id;
        $p = DB::table('product_varient')
             ->join('product','product_varient.product_id','=','product.product_id')
           ->Leftjoin('deal_product','product_varient.varient_id','=','deal_product.varient_id')
           ->where('product_varient.varient_id',$varient_id)
           ->first();
        if($p->deal_price != NULL &&  $p->valid_from < $current && $p->valid_to > $current){
          $price= $p->deal_price;    
        }else{
      $price = $p->price;
        } 
        $mrp = $p->mrp;
        $order_qty = $h->qty;
        $price1= $price*$order_qty;
        $total_mrp = $mrp*$order_qty;
        $order_qty = $h->qty;
        $p = DB::table('product_varient')
           ->join('product','product_varient.product_id','=','product.product_id')
           ->where('product_varient.varient_id',$varient_id)
           ->first(); 
       
        $n =$p->product_name;
     

        $insert = DB::table('store_orders')
                ->insertGetId([
                        'varient_id'=>$varient_id,
                        'qty'=>$order_qty,
                        'product_name'=>$n,
                        'varient_image'=>$p->varient_image,
                        'quantity'=>$p->quantity,
                        'unit'=>$p->unit,
                        'total_mrp'=>$total_mrp,
                        'order_cart_id'=>$cart_id,
                        'order_date'=>$created_at,
                        'price'=>$price1]);
      
 }
 
 $delcharge=DB::table('freedeliverycart')
           ->where('id', 1)
           ->first();
           
if ($delcharge->min_cart_value<=$price2){
    $charge=0;
}  
else{
    $charge =$delcharge->del_charge;
}
 
  if($insert){
        $oo = DB::table('orders')
            ->insertGetId(['cart_id'=>$cart_id,
            'total_price'=>$price2 + $charge,
            'price_without_delivery'=>$price2,
            'total_products_mrp'=>$price5,
            'delivery_charge'=>$charge,
            'user_id'=>$user_id,
            'store_id'=>$store_id,
            'rem_price'=>$price2 + $charge,
            'order_date'=> $created_at,
            'delivery_date'=> $delivery_date,
            'time_slot'=>$time_slot,
            'address_id'=>$ar->address_id]); 
                    
           $ordersuccessed = DB::table('orders')
                           ->where('order_id',$oo)
                           ->first();
                           
            $delete = DB::table('store_orders')
                           ->where('store_approval',$user_id)
                           ->where('order_cart_id', 'incart')
                           ->delete();
        	$message = array('status'=>'1', 'message'=>'Proceed to payment', 'data'=>$ordersuccessed );
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
       
 }       
 
   public function show_cart(Request $request)
    { 
        $user_id= $request->user_id;
        $cart_items = DB::table('store_orders')
                    ->where('store_approval',$user_id)
                    ->where('order_cart_id', 'incart')
                    ->get();
         
                        
        if(count($cart_items)>0){
             $sum = DB::table('store_orders')
            ->where('store_approval',$user_id)
            ->where('order_cart_id', "incart")
            ->select(DB::raw('SUM(store_orders.price) as sum'))
            ->first();
            $message = array('status'=>'1', 'message'=>'cart_items','total_price'=>$sum->sum, 'data'=>$cart_items );
        	return $message;
        }
        else{
        	$message = array('status'=>'0', 'message'=>'insertion failed', 'data'=>[]);
        	return $message;
        }
        }
 
}
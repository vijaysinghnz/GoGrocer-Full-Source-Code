<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Carbon\carbon;
use Dompdf\Dompdf;

class InvoiceController extends Controller
{
    public function invoice(Request $request)
    {
        $title = "invoice";
        // $cart_id = $request->id;
        $cart_id = $request->cart_id;
    	$logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $order = DB::table('orders')
               ->leftJoin('address', 'orders.address_id', '=','address.address_id')
               ->leftJoin('users','orders.user_id','=','users.user_id')
               ->where('cart_id', $cart_id)
               ->first();
               
        $details = DB::table('store_orders')
                  ->where('order_cart_id',$cart_id)
                  ->where('store_approval',1)
                  ->get();
                  
        $currentdate = Carbon::now();          
          
    	return view('admin.invoice.invoice', compact('title',"logo","details", "order","currentdate"));
    }
     public function pdfinvoice(Request $request)
    {
        $url  = \Request::url();
        $replace="admin/pdf/invoice";
        $baseurl= str_replace($replace,"", $url);
        $title = "invoice";
        // $cart_id = $request->id;
        $cart_id = 'UUUN8718';
    	$logo = DB::table('tbl_web_setting')
                ->where('set_id', '1')
                ->first();
        $order = DB::table('orders')
               ->leftJoin('address', 'orders.address_id', '=','address.address_id')
               ->leftJoin('users','orders.user_id','=','users.user_id')
               ->where('cart_id', $cart_id)
               ->first();
               
        $details = DB::table('store_orders')
                  ->where('order_cart_id',$cart_id)
                  ->get();
                  
        $currentdate = Carbon::now();    
$output = '<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Invoice</title>
        <style>
  * {
    font-size: 12px;
    font-family: "monospace";
}

td,
th,
tr,
table {
    border-top: 1px solid black;
    border-collapse: collapse;
}

td.description,
th.description {
    width: 65px;
    max-width: 65px;
}

td.quantity,
th.quantity {
    width: 20px;
    max-width: 20px;
    word-break: break-all;
}

td.price,
th.price {
    width: 30px;
    max-width: 30px;
    word-break: break-all;
}

.centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 155px;
    max-width: 155px;
}

img {
    max-width: inherit;
    width: inherit;
}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
}  </style>
    </head>
    <body>
        <div class="ticket" align="left" style="width:100% !important>
            <img src="'.$baseurl.$logo->icon.'" alt="app-logo" style="width:50px">
            <p class="centered">ADDRESS-
            <p> <b>Name</b> :'.$order->user_name.'<br>
            <b>Address</b> : '.$order->house_no.','.$order->society.','.$order->landmark.','.$order->city.','.$order->state.','.$order->pincode.'</br>
            <b>Email</b> : '.$order->user_email.'</br>
            <b>Phone</b> : '.$order->user_phone.'</br>
            <table>
                <thead>
                    <tr>
                        <th class="quantity" align="left">#</th>
                        <th class="description" align="left">Item</th>
                        <th class="price" align="left">Qty</th>
                        <th class="price" align="left">Price</th>
                    </tr>
                </thead>
                <tbody>';
                     if(count($details)>0){
                          $i=1;
                          
                          foreach ($details as $detail){
                          
							$output.='<tr class="service">
							     <td class="quantity" align="left">'.$i.'</td>
								<td class="description" align="left">'.$detail->product_name.'</td>
								<td class="price" align="left">'.$detail->qty.'</td>
								<td class="price" align="left">'.$detail->price.'</td>
							</tr>';
							  $i++;
                          }
                     }
                      else{
                        $output.='<tr>
                          <td>No data found</td>
                        </tr>';
                      } 
                      $output.='<tr class="service">
							     <td class="quantity"></td>
								<td class="description" align="center"><b>PRICE</b><br>
								<span style="font-size:8px">(inclusive all taxes)</span></td>
								<td class="price"></td>
								<td class="price">'.$order->total_price.'</td>
							</tr>
                      
                </tbody>
            </table>
            <p class="centered">Thanks for Shopping!
        </div>
    </body>
</html>';        
        

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$options = $dompdf->getOptions(); 
    $options->set(array('isRemoteEnabled' => true));
    $dompdf->setOptions($options);
$dompdf->loadHtml($output);

// /// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A7', 'potrait');

// // Render the HTML as PDF
$dompdf->render();
$frame = $dompdf->getTree()->get_frame(0);
$height = $frame->get_style()->height;
// // Output the generated PDF to Browser
$dompdf->stream('invoice.pdf');
// $dompdf->download('invoice.pdf');
  
    }
    

     
    
    
}
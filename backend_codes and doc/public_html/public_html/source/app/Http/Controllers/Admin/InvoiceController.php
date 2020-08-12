<?php

namespace App\Http\Controllers\Admin;

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
        $cart_id = "UUUN8718";
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
          
    	return view('admin.invoice.invoice', compact('title',"logo","details", "order","currentdate"));
    }
     public function pdfinvoice(Request $request)
    {
        $url  = \Request::url();
        $replace="admin/pdf/invoice";
        $baseurl= str_replace($replace,"", $url);
        $title = "invoice";
        // $cart_id = $request->id;
        $cart_id = "UUUN8718";
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
<html style="height:100% !important;page-break-inside: avoid;">

<head>
	<title>Invoice</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

</head>

<body style="height:100% !important;page-break-inside: avoid;">


  <div id="invoice-POS" style="page-break-inside: avoid;">
    <center id="top">
      <div class="logo"><img style="width:50px;" src='.$baseurl.''.$logo->icon.' alt="app-logo"/></div>
        <p style="font-size: 12px !important;font-family: monospace !important;color:black !important;">'.$logo->name.'</p>
    </center>
    <div id="mid" style="page-break-inside: avoid;page-break-after: avoid;">
      <div class="info" style="border-top: 2px dotted black;padding-top: 8px;">
        
        <p style="font-size: 12px !important;font-family: monospace !important;color:black !important;"> <b>Name</b> : '.$order->user_name.'<br>
            <b>Address</b> : '.$order->house_no.','.$order->society.','.$order->landmark.','.$order->city.','.$order->state.','.$order->pincode.'</br>
            <b>Email</b> : '.$order->user_email.'</br>
            <b>Phone</b> : '.$order->user_phone.'</br>
        </p>
      </div>
    
    <div id="bot" style="border-top: 2px dotted black;padding-top: 8px;page-break-inside: avoid;!important;page-break-inside: avoid;page-break-after: avoid;page-break-before: avoid;">

					<div id="table" style="width:100% !important">
						<table style="width:100% !important">
						    <thead style="width:100% !important">
							<tr class="tabletitle">
							    <td style="width:10% !important"><p style="font-size: 12px !important;font-family: monospace !important;color:black !important;text-align:center;"><b>#</b></p></td>
								<td style="width:50% !important" class="item"><p style="font-size: 12px !important;font-family: monospace !important;color:black !important;text-align:center;"><b>Item</b></p></td>
								<td style="width:10% !important" class="Hours"><p style="font-size: 12px !important;font-family: monospace !important;color:black !important;text-align:center;"><b>Qty</b></p></td>
								<td style="width:30% !important" class="Rate"><p style="font-size: 12px !important;font-family: monospace !important;color:black !important;text-align:center;"><b>Price</b></p></td>
							</tr>
							</thead>
                            <tbody>'; 
                      if(count($details)>0){
                        $i=1; 
                          foreach($details as $detail){ 
                          
							$output.='<tr class="service">
							     <td class="tableitem"  style="width:10% !important"><p style="font-size: 12px !important;font-family: monospace !important;color:black !important;text-align:center;" class="itemtext">'.$i.'</p></td>
								<td class="tableitem" style="width:50% !important"><p style="font-size: 12px !important;font-family: monospace !important;color:black !important;text-align:center;" class="itemtext">'.$detail->product_name.'</p></td>
								<td class="tableitem" style="width:10% !important"><p style="font-size: 12px !important;font-family: monospace !important;color:black !important;text-align:center;" class="itemtext">'.$detail->qty.'</p></td>
								<td class="tableitem" style="width:30% !important"><p style="font-size: 12px !important;font-family: monospace !important;color:black !important;text-align:center;" class="itemtext">'.$detail->price.'</p></td>
							</tr>';
					   
					     $i++;
                        }
                        }
                      else{
                        $output.='<tr>
                          <td>No data found</td>
                        </tr>';
                      }  
                      
                   $output.='  </tbody>
						

							<tr class="tabletitle">
								<td></td>
								<td></td>
								<td class="Rate"><h2 style="font-size: 12px !important;font-family: monospace !important;color:black !important;"><b>Total</b></h2></td>
								<td class="payment"><h2 style="font-size: 12px !important;font-family: monospace !important;color:black !important;">&nbsp; '.$order->total_price.'</h2></td>
							</tr>

						</table>
					</div>
                <center>
					<div id="legalcopy">
						<p class="legal" style="font-size: 13px !important;font-family: monospace !important;color:black !important;"><strong>Thank you for Shopping!</strong> 
						</p>
					</div>
                  </center>
                  
				</div>
  </div>
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
$dompdf->stream();
// $dompdf->download('invoice.pdf');
  
    }
}
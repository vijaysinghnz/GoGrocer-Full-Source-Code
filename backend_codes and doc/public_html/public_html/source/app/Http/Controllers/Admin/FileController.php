<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;
use App\Product;
use carbon\carbon;

class FileController extends Controller {

    
    
   public function importFileIntoDB(Request $request){
       
        $count=0;
            $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
            while($csv_line = fgetcsv($fp,1024))
            {
                $count++;
                if($count == 1)
                {
                    continue;
                }//keep this if condition if you want to remove the first row
                for($i = 0, $j = count($csv_line); $i < $j; $i++)
                {

                    $insert_csv0 = array();
                    $insert_csv0['subcat_id'] = $csv_line[0];
                    $insert_csv0['product_name'] = $csv_line[1];
                    $insert_csv0['product_image'] = $csv_line[2];
                    $insert_csv0['created_at'] = $csv_line[3];
                  
                    $insert_csv = array();
                    $insert_csv['product_id'] = $csv_line[0];
                    $insert_csv['mrp'] = $csv_line[1];
                    $insert_csv['price'] = $csv_line[2];
                    $insert_csv['varient_color'] = $csv_line[3];
                    $insert_csv['varient_size'] = $csv_line[4];
                    $insert_csv['subscription_price'] = $csv_line[5];
                    $insert_csv['varient_unit_value'] = $csv_line[6];
                    $insert_csv['varient_image'] =  $csv_line[7];
                    $insert_csv['increament'] = $csv_line[8];
                    $insert_csv['varient_desc'] = $csv_line[9];
                    $insert_csv['stock'] = $csv_line[10];
                    $insert_csv['varient_unit'] = $csv_line[11];
                    $insert_csv['created_at'] = $csv_line[9];
                }
                $i++;
                $data = array(
                    'product_id' => "" ,
                    'product_name' => $insert_csv['product_name'],
                    'product_description' => $insert_csv['product_description'],
                    'product_image' => $insert_csv['product_image'],
                    'category_id' => $insert_csv['category_id'],
                    'in_stock' => $insert_csv['in_stock'],
                    'price' => $insert_csv['price'],
                    'unit_value' => $insert_csv['unit_value'],
                    'unit' => $insert_csv['unit'],
                    'increament' => $insert_csv['increament'],
                    'rewards' => $insert_csv['rewards']
                    );
                $data['crane_features']=$this->db->insert('products', $data);
                $in_id=$this->db->insert_id();
                $date=date('Y-m-d h:i:s');
                
                $data1 = array(
                    'purchase_id' => "" ,
                    'product_id' => $in_id,
                    'qty' => '1',
                    'unit' => $insert_csv['unit'],
                    'date' => $date,
                    'store_id_login' => '1'
                    );
                $data['crane_features']=$this->db->insert('purchase', $data1);
            }
            fclose($fp) or die("can't close file");
            $data['success']="Product upload success";
            return $data;
   } 
    
    
    
  public function importFileIntoDB(Request $request){
    if(Session::has('vendor'))
     {
        //  return redirect()->back()->withErrors('this function is disabled for demo.');
        if($request->hasFile('sample_file')){
            $path = $request->file('sample_file')->getRealPath();
            // $data = \Excel::load($path)->get();
           $data = \Excel::load($path)->get();

    if($data->count() > 0)
     {
      foreach($data->toArray() as $key => $value)
      {
       foreach($value as $values)
       {
        $insert_data = array(
         'subcat_id'=> $values['subcat_id'],    
         'product_name'  => $values['product_name'],
         'product_image' => $values['product_image'],
         'created_at'  => Carbon::now(),
        );
        
        $insert_varient= array(
        'product_id' => 'n/a',    
         'mrp'   => $values['mrp'],
         'price'   => $values['price'],
         'varient_color' => $values['color'],
         'varient_size' => $values['size'],
         'subscription_price'    => $values['subscription_price'],
         'varient_unit_value'  => $values['varient_unit_value'],
         'varient_image'   => $values['product_image'],
         'varient_desc'    => $values['description'],
         'stock'  => $values['stock'],
         'varient_unit'   => $values['varient_unit'],
         'created_at'  => Carbon::now() ,
            );
            
       }
      }

      if(!empty($insert_data))
      {
       $getid = DB::table('product')->insertGetId($insert_data);
       $insertvar = DB::table('product_varient')->insert($insert_varient);
       if($insertvar){
           DB::table('product_varient')->update(['product_id'=>$getid]);
       }
      }
     }
     return back()->with('success', 'Excel Data Imported successfully.');
    }
	 }
	else
	 {
			return redirect()->route('vendorlogin')->withErrors('please login first');
	 }
    } 
    
    
    public function downloadExcelFile($type){
        $products = DB::table('product')->get()->toArray();
        return \Excel::create('expertphp_demo', function($excel) use ($products) {
            $excel->sheet('sheet name', function($sheet) use ($products)
            {
                $sheet->fromArray($products);
            });
        })->download($type);
    }      
}

    
    
    
    
 
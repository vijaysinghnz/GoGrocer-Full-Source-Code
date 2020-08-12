<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\YourExport;
use Maatwebsite\Excel\Excel;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Hash;


class ImportExcelController extends Controller
{
    function import(Request $request)
    {
     $this->validate($request, [
      'select_file'  => 'required|mimes:xls,xlsx'
     ]);

     $path = $request->file('select_file')->getRealPath();

     $data = Excel::load($path)->get();

     if($data->count() > 0)
     {
      foreach($data->toArray() as $key => $value)
      {
       foreach($value as $row)
       {
        $insert_data[] = array(
         'cat_id'=> $row['cat_id'],      
         'product_name'  => $row['product_name'],
         'product_image' => $row['product_image'],
    
        );
        
        $insert_varient[]= array(
        'product_id' => 'n/a', 
        'quantity' => $row['quantity'],
        'unit' => $row['unit'],
         'mrp'   => $row['mrp'],
         'price'   => $row['price'],
         'description' => $row['description'],
         'varient_image' => $row['varient_image']
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

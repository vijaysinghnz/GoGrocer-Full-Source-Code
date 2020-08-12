<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ImportContacts;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Contact;

class ImportController extends Controller

{

    public function index()
    {
        $contacts = Contact::orderBy('created_at','DESC')->get();
        return view('import_excel.index',compact('contacts'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);
    $path = $request->file('import_file')->getRealPath();
    $data = array_map('str_getcsv', file($path));

     if(count($data) > 0)
     {
      foreach($data as $key => $value)
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

      if(!empty($insert_data))
      {
       $getid = DB::table('product')->insertGetId($insert_data);
       $insertvar = DB::table('product_varient')->insert($insert_varient);
       if($insertvar){
           DB::table('product_varient')->where('product_id','0')->update(['product_id'=>$getid]);
       }
      }
     }
     return back()->with('success', 'Excel Data Imported successfully.');
    }
    

}
}
  public function varient(Request $request)
    {
        $prod_id = $request->product_id;
        $varient= DB::table('product_varient')
                ->where('product_id',$prod_id)
                ->get();
        if(count($varient)>0){        
          $message = array('status'=>'1', 'message'=>'varients', 'data'=>$varient);
            return $message;
        }
        else{
            $message = array('status'=>'0', 'message'=>'data not found', 'data'=>[]);
            return $message;
        }        
                
    }
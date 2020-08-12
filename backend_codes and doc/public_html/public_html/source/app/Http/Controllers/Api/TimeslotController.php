<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class TimeslotController extends Controller
{
 public function timeslot(Request $request)
    {
    $current_time = Carbon::Now();
    $date = date('Y-m-d');
    $time_slot = DB::table('time_slot')
                    ->first();
    $starttime  = $time_slot->open_hour;
    $endtime  = $time_slot->close_hour;
    $duration  = $time_slot->time_slot;
    $selected_date  = $request->selected_date;

    $array_of_time = array ();
    $array_of_time1 = array ();
    $currenttime = strtotime ($current_time);
    $start_time    = strtotime ($starttime); //change to strtotime
    $end_time      = strtotime ($endtime); //change to strtotime

    $add_mins  = $duration * 60;
if(strtotime($date)==strtotime($selected_date)){
    while ($start_time <= $currenttime) // loop between time
    {
       $array_of_time[] = date ("H:i", $start_time);
       $start_time += $add_mins; // to check endtie=me
    }

    $new_array_of_time = array ();
    for($i = 0; $i < count($array_of_time) - 1; $i++)
    {
        $new_array_of_time[] = '' . $array_of_time[$i] . ' - ' . $array_of_time[$i + 1];
    }
    
$items=last($new_array_of_time);
$numbers = explode('-', $items);
$last_Number = end($numbers);
 $lastNumber    = strtotime ($last_Number);
 if($last_Number!= NULL){
while ($lastNumber <= $end_time) // loop between time
    {
       $array_of_time1[] = date ("H:i", $lastNumber);
       $lastNumber += $add_mins; // to check endtie=me
    }

    $new_array_of_time1 = array ();
    for($i = 2; $i < count($array_of_time1) - 1; $i++)
    {
        $new_array_of_time1[] = '' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1];
    }
 }
 else{
     while ($start_time <= $end_time) // loop between time
    {
       $array_of_time1[] = date ("H:i", $start_time);
       $start_time += $add_mins; // to check endtie=me
    }

    $new_array_of_time1 = array ();
    for($i = 1; $i < count($array_of_time1) - 1; $i++)
    {
        $new_array_of_time1[] = '' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1];
    }
 }
    
}
elseif(strtotime($date)>strtotime($selected_date)){
   
                $message = array('status'=>'0', 'message'=>"You can't select the back date", 'data'=>$current_time);
            return $message; 
}
else{
    while ($start_time <= $end_time) // loop between time
    {
       $array_of_time1[] = date ("H:i", $start_time);
       $start_time += $add_mins; // to check endtie=me
    }

    $new_array_of_time1 = array ();
    for($i = 0; $i < count($array_of_time1) - 1; $i++)
    {
        $new_array_of_time1[] = '' . $array_of_time1[$i] . ' - ' . $array_of_time1[$i + 1];
    }
    
}
    if(count($new_array_of_time1)>0){
    		$message = array('status'=>'1', 'message'=>'Present time Slot', 'data'=>$new_array_of_time1);
            return $message;
            }
            else
            {
                $message = array('status'=>'0', 'message'=>'Oops No time slot present', 'data'=>$current_time);
            return $message;
            }
    
    }
}
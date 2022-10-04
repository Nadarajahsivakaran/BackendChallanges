<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class challange2Controller extends Controller
{
    public function challang2()
    {
        $a = [2, 3, 1, 2, 3]; //array
        
        $created_arr = [];
        $duplicate_arr = [];

      
        foreach($a as $item){

            $check = (in_array($item, $created_arr, true));

            if ($check) {
                array_push($duplicate_arr,$item);
            } else {
                array_push($created_arr, $item);
            }
        }

        return $duplicate_arr;
    }
}

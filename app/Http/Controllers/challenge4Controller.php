<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class challenge4Controller extends Controller
{
    public function groupByOwnersService()
    {
        $given_array = ["insurance.txt" => "CompanyA",  "letter.docx" => "CompanyA",  "Contract.docx" => "CompanyB"];
        $created_array = [];

        foreach ($given_array as $key => $value) {

            $have = false;
            foreach ($created_array as $key1 => $value1) {
                if ($key1 == $value) {
                    $have = true;
                }
            }

            if ($have) {
                $a = $created_array[$value];
                $created_array[$value] = [$a, $key];
            } else {
                $created_array[$value] = $key;
            }
        }
        return $created_array;
    }
}

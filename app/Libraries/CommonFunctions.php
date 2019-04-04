<?php

namespace App\Libraries;

class CommonFunctions
{
    public static function GetProjectStatus() 
    { 
        $config = array(
            "1" => "受注",
            "2" => "開発",
            "3" => "テスト",
            "4" => "納品",
        );
        return $config ; 
    } 
}
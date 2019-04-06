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

    public static function GetSearchRange() 
    { 
        $config = array(
            "1" => "有効のみ",
            "2" => "削除のみ",
            "3" => "全件",
        );
        return $config ; 
    }
}
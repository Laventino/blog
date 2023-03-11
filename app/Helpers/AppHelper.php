<?php
namespace App\Helpers;

class AppHelper
{
    static function isMenuActive($menu_key,$menu_name){
        if($menu_key == $menu_name){
            return "active";
        }
    }
}

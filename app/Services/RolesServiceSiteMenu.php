<?php
/*
    16.12.2019
    RolesService.php
*/

namespace App\Services;

use Spatie\Permission\Models\Role;

class RolesServiceSiteMenu{

    static $defaultRoles = ['guest'];

    public static function get(){
        $roles = Role::all();
        $result = array();
        foreach($roles as $role){
            array_push($result, $role);
        }
        //return array_merge(self::$defaultRoles, $result);
        return $result;
    }

}
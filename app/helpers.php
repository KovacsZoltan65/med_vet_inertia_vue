<?php

namespace App;

//if( !function_exists('get_roles') )
//{
//    function get_roles(\App\Models\User $user)
//    {
//        $ret_val = [];
//        
//        foreach( $user->roles as $role )
//        {
//            $ret_val[] = $role->title;
//        }
//        
//        return $ret_val;
//    }
//}

if( !function_exists('get_permissions') )
{
    function get_permissions($role)
    {
        $ret_val = [];
        
        foreach( $role->permissions as $permission )
        {
            //dd($permission);
            $ret_val[] = $permission->title;
        }
        
        return $ret_val;
    }
}
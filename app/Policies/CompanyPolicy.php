<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {       
        $roles = $permissions = [];
        $permission = 'company_view';
        
        $_roles = $user->roles;
        
        foreach( $_roles as $_role )
        {
            $roles[] = $_role->title;
            
            $permissions = array_merge($permissions, \App\get_permissions($_role));
            
            //$_permissions = $_role->permissions;
            
            //foreach( $_permissions as $_permission )
            //{
            //    $permissions[] = $_permission->title;
            //}
        }
        
        $ret_value = ( in_array($permission, $roles) || in_array($permission, $permissions) );
        
        return $ret_value;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Company $company): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Company $company): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Company $company): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Company $company): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Company $company): bool
    {
        //
    }
}

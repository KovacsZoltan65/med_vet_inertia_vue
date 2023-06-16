<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        $retval = false;
        $roles = [];
        $permissions = [];
        
        $_roles = $user->roles;
        //echo '<pre>';
        foreach($_roles as $role)
        {
            print_r($role->title . PHP_EOL);
            $roles[] = $role->title;
            
            $_permissions = $role->permissions;
            foreach($_permissions as $_permission)
            {
                //print_r($_permission->title . PHP_EOL);
                $permissions[] = $_permission->title;
            }
        }
        
        $retval = in_array('', $permissions);
        //dd($retval);
        return $retval;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Company $company): bool
    {
        return $user->checkRole('user');
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

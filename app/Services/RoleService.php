<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

/**
 * Class RoleService.
 */
class RoleService
{

    public static function store($permission)
    {

        $role =   Role::create(["name" => $permission]);
        return $role;
    }
}

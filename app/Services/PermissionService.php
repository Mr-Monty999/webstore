<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class PermissionService.
 */
class PermissionService
{

    public static function store($permission)
    {
        $permission =  Permission::create(["name" => $permission]);
        return $permission;
    }

    public static function permissions()
    {
        return Collection::make([
            "view-dashboard",
            "view-users",
            "create-users",
            "edit-users",
            "delete-users",
            "view-items",
            "create-items",
            "edit-items",
            "delete-items",
            "view-products",
            "create-products",
            "edit-products",
            "delete-products",
            "view-settings",
            "create-settings",
            "edit-settings",
            "delete-settings",
            "view-feedbacks",
            "delete-feedbacks",
            "view-privacy",
            "edit-privacy",
            "view-permissions",
            "create-permissions",
            "edit-permissions",
            "delete-permissions",

        ]);
    }
}

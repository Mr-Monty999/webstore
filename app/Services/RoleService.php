<?php

namespace App\Services;

use DB;
use Gate;
use Spatie\Permission\Models\Role;

/**
 * Class RoleService.
 */
class RoleService
{

    public static function getAllRoles()
    {
        $roles = Role::with("permissions")->paginate(5);

        return $roles;
    }
    public static function store($roleName, $guardName = null)
    {

        $role =   Role::create(["name" => $roleName, "guard_name" => $guardName]);
        return $role;
    }
    public static function update($data, $id)
    {
        $role = Role::with("permissions")->findOrFail($id);
        Gate::authorize("update", $role);
        $role->update($data);
        return $role;
    }
    public static function table($pageNumber)
    {
        $roles = Role::with("permissions")->paginate(5, ['*'], 'page', $pageNumber)->withPath(route("roles.index"));
        return $roles;
    }

    public static function show($id)
    {

        $role =   Role::with("permissions")->findOrFail($id);
        return $role;
    }
    public static function delete($id)
    {

        $role = Role::with("permissions")->findOrFail($id);
        Gate::authorize("delete", $role);
        $role->delete();
        return $role;
    }

    public static function destroyAll()
    {

        DB::table("roles")->whereNotIn("name", ["owner"])->delete();

        return true;
    }
}

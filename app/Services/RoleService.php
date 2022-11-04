<?php

namespace App\Services;

use DB;
use Spatie\Permission\Models\Role;

/**
 * Class RoleService.
 */
class RoleService
{

    public static function getAllRoles()
    {
        $roles = Role::latest()->paginate(5)->onEachSide(0);

        return $roles;
    }
    public static function store($permission)
    {

        $role =   Role::create(["name" => $permission]);
        return $role;
    }
    public static function update($data, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($data);
        return $role;
    }
    public static function exists($name)
    {
        $exists = Role::where("name", $name)->exists();
        return $exists;
    }
    public static function table($pageNumber)
    {
        $roles = Role::latest()->paginate(5, ['*'], 'page', $pageNumber)->withPath(route("roles.index"))->onEachSide(0);
        return $roles;
    }

    public static function show($id)
    {

        $role =   Role::with("permissions")->findOrFail($id);
        return $role;
    }
    public static function delete($id)
    {

        $role = Role::findOrFail($id);
        $role->delete();
        return $role;
    }
    public static function getRolePermissions($id)
    {

        $permissions =   Role::findOrFail($id)->permissions;
        return $permissions;
    }

    public static function destroyAll()
    {

        DB::table("roles")->whereNotIn("name", ["owner"])->delete();

        return true;
    }
}

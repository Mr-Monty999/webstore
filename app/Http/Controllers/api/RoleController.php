<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;


/**
 * @group roles
 * @authenticated
 */
class RoleController extends Controller
{
    /**
     * Display all the roles (paginated) with their permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = RoleService::getAllRoles();
        return response()->json($roles);
    }

    /**
     * Store a newly created role in database.
     *@bodyParam permissions int[] or string[] (array of ids or array of names)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $role = RoleService::store($request->name);
        if (isset($request->permissions)) {
            $permissions = $request->permissions;
            $role->syncPermissions($permissions);
        }
        return response()->json($role, 201);
    }

    /**
     * Display the specified role with it permissions.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $role = RoleService::show($id);
        return response()->json($role);
    }

    /**
     * Update the specified role in database.
     * @bodyParam permissions int[] or string[] (array of ids or array of names)
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = RoleService::update($request->all(), $id);
        if (isset($request->permissions)) {
            $permissions = $request->permissions;
            $role->syncPermissions($permissions);
        }
        return response()->json($role);
    }

    /**
     * Remove the specified role from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = RoleService::delete($id);
        return response()->json($role);
    }
    /**
     * Remove all the roles from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {
        $role = RoleService::destroyAll();
        return response()->json($role);
    }
}

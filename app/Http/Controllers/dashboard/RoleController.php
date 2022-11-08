<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Item;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

        $this->middleware("permission:view-roles")->only(["index", "show", "table"]);
        $this->middleware("permission:create-roles")->only(["create", "store"]);
        $this->middleware("permission:edit-roles")->only(["edit", "update"]);
        $this->middleware("permission:delete-roles")->only("destroy", "destroyAll");
    }
    public function index()
    {
        $roles = RoleService::getAllRoles();
        return view("dashboard.roles.index", compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = PermissionService::getAllPermissions();
        return view("dashboard.roles.create", compact("permissions"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $exists = RoleService::exists($request->name);
        if ($exists)
            return response()->json(null, 409);


        $role = RoleService::store($request->name);
        $permissions = explode(',', $request->permissions);
        $role->syncPermissions($permissions);
        return response()->json($role, 201);
    }
    public function table($pageNumber)
    {
        $roles = RoleService::table($pageNumber);
        return view("dashboard.roles.table", ["roles" => $roles]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $role = RoleService::show($id);
        $permissions = PermissionService::getAllPermissions();
        return view("dashboard.roles.edit", compact("role", "permissions"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = RoleService::update($request->all(), $id);
        $permissions = explode(',', $request->permissions);
        $role->syncPermissions($permissions);
        return response()->json($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $role = RoleService::delete($request->id);

        return response()->json($role);
    }
    public function destroyAll()
    {
        RoleService::destroyAll();
        return response()->json(null);
    }
}

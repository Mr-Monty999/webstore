<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\DeleteService;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    public function __construct()
    {

        $this->middleware("permission:view-users")->only(["index", "show", "table"]);
        $this->middleware("permission:create-users")->only(["create", "store"]);
        $this->middleware("permission:edit-users")->only(["edit", "update"]);
        $this->middleware("permission:delete-users")->only("destroy", "destroyAll");
    }
    public function index()
    {

        $users = UserService::getAllUsers();
        $roles = RoleService::getAllRoles();
        return view("dashboard.users.index", compact("users", "roles"));
    }
    public function table($pageNumber)
    {

        $users = UserService::table($pageNumber);
        return view("dashboard.users.table", ["users" => $users]);
    }



    public function store(StoreUserRequest $request)
    {

        $data = UserService::store($request);
        $data["success"] = true;
        $data["message"] = "تم اضافة المشرف بنجاح";


        return response()->json($data, 200);
    }



    public function edit($id)
    {
        $user = UserService::show($id);
        $roles = RoleService::getAllRoles();

        return view("dashboard.users.edit", compact("user", "roles"));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = UserService::update($request, $id);

        $data["success"] = true;
        $data["message"] = "تم الحفظ بنجاح";



        return response()->json($data, 200);
    }


    public function destroy(Request $request, $id)
    {
        UserService::destroy($request->id);

        $data["success"] = true;
        $data["message"] = "تم الحذف بنجاح";
        return response()->json($data, 200);
    }

    public function destroyAll()
    {
        UserService::destroyAll();

        $data["success"] = true;
        $data["message"] = "تم حذف جميع المشرفين بنجاح";
        return response()->json($data, 200);
    }
}

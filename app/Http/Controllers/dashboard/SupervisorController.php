<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\DeleteService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    public function index()
    {

        $users = UserService::getAllUsers();
        return view("dashboard.users.index", ["users" => $users]);
    }
    public function table($pageNumber)
    {

        $users = UserService::table($pageNumber);
        return view("dashboard.users.table", ["users" => $users]);
    }



    public function store(Request $request)
    {

        UserService::store($request);

        $data["success"] = true;
        $data["message"] = "تم اضافة المشرف بنجاح";

        return response()->json($data, 200);
    }



    public function edit($id)
    {
        $user = UserService::show($id);
        return view("dashboard.users.edit", ["user" => $user]);
    }

    public function update(Request $request, $id)
    {
        $data = UserService::update($request, $id);


        return response()->json($data, 200);
    }


    public function destroy(Request $request, $id)
    {
        UserService::destroy($id);

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

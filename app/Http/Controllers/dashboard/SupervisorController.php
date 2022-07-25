<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Services\DeleteService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    public function index()
    {

        $admins = Admin::paginate(5)->onEachSide(0);
        return view("dashboard.admins.index", ["admins" => $admins]);
    }
    public function table()
    {

        $admins = Admin::paginate(5)->withPath(route("admins.index"))->onEachSide(0);
        return view("dashboard.admins.table", ["admins" => $admins]);
    }

    public function store(AdminRequest $request)
    {

        $request->validated();
        $data = $request->all();

        $admin = Admin::where("admin_name", $request->admin_name);

        if ($admin->exists()) {
            $data["success"] = false;
            $data["message"] = "هذا المشرف موجود بالفعل !";
            return response()->json($data, 200);
        }

        $path = null;
        if (file_exists(public_path()))
            $path = public_path();
        else
            $path = base_path();


        $photo = null;
        $photoName = null;

        if ($request->hasFile("admin_photo")) {
            $photo = $request->file("admin_photo");
            $photoName = time() . "." . $photo->getClientOriginalExtension();
            $photo->move($path . "/images/admins", "$photoName");
            $photoName = "/images/admins/" . $photoName;
        }
        $password = Hash::make("");
        if (trim($request->password) != "")
            $password = Hash::make(trim($request->password));

        $data["admin_rank"] = "admin";
        $data["password"] = $password;
        $data["admin_status"] = "offline";
        $data["admin_photo"] = $photoName;

        Admin::create($data);

        $data["success"] = true;
        $data["message"] = "تم اضافة المشرف بنجاح";

        return response()->json($data, 200);
    }



    public function edit($id)
    {
        $admin = Admin::findOrfail($id);
        return view("dashboard.admins.edit", ["admin" => $admin]);
    }

    public function update(AdminRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $admin = Admin::find($request->id);

        $oldAdmin = Admin::where("admin_name", $request->admin_name);

        if ($oldAdmin->exists() && $oldAdmin->first()->admin_name != $admin->admin_name) {
            $data["success"] = false;
            $data["message"] = "هذا المشرف موجود بالفعل !";

            return response()->json($data, 200);
        }


        $path = null;
        if (file_exists(public_path()))
            $path = public_path();
        else
            $path = base_path();



        $photo = null;
        $photoName = $admin->admin_photo;
        if ($request->hasFile("admin_photo")) {
            $photo = $request->file("admin_photo");
            $photoName = time() . "." . $photo->getClientOriginalExtension();

            // Delete Old Photo
            DeleteService::deleteFile($admin->admin_photo);

            $photo->move($path . "/images/admins", "$photoName");
            $photoName = "/images/admins/" . $photoName;
        }
        $password = $admin->password;
        if (trim($request->password) != "")
            $password = Hash::make(trim($request->password));

        $data["admin_rank"] = "admin";
        $data["password"] = $password;
        $data["admin_photo"] = $photoName;

        $admin->update($data);

        $data["success"] = true;
        $data["message"] = "تم الحفظ بنجاح";
        $data["photo_path"] = asset($photoName);



        return response()->json($data, 200);
    }


    public function destroy(Request $request, $id)
    {
        $admin = Admin::findOrFail($request->id);
        $data["admin"] = $admin;
        $admin->delete();

        //Delete Old Photo
        DeleteService::deleteFile($admin->admin_photo);

        $data["success"] = true;
        $data["message"] = "تم الحذف بنجاح";
        return response()->json($data, 200);
    }

    public function destroyAll()
    {
        Admin::where("admin_rank", "admin")->delete();

        //Delete All Photos
        DeleteService::deleteAllFiles("/images/admins");

        $data["success"] = true;
        $data["message"] = "تم حذف جميع المشرفين بنجاح";
        return response()->json($data, 200);
    }
}

<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Services\DeleteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PrivacyController extends Controller
{
    public function index()
    {
        $admin = Admin::find(Auth::guard("admin")->id());
        return view("dashboard.privacy.index", ["admin" => $admin]);
    }

    public function update(AdminRequest $request)
    {
        $request->validated();
        $data = $request->all();

        $admin = Admin::find(Auth::guard("admin")->id());

        $oldAdmin = Admin::where("admin_name", $request->admin_name);

        if ($oldAdmin->exists() && $oldAdmin->first()->admin_name != $admin->admin_name) {
            $data["success"] = false;
            $data["message"] = "هذا المشرف موجود بالفعل";

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

        $data["password"] = $password;
        $data["admin_photo"] = $photoName;
        $data["admin_rank"] = $admin->admin_rank;
        $data["admin_status"] = "online";

        $admin->update($data);

        $data["success"] = true;
        $data["message"] = "تم الحفظ بنجاح";
        $data["photo_path"] = asset($photoName);

        return response()->json($data);
    }
}

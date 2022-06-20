<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
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
        $admin = Admin::find(Auth::guard("admin")->id());

        $oldAdmin = Admin::where("admin_name", $request->admin_name);

        if ($oldAdmin->exists() && $oldAdmin->first()->admin_name != $admin->admin_name) {
            return redirect()->back()->with("error", "هذا المشرف موجود بالفعل");
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

            if (file_exists($path . $admin->admin_photo) && is_file($path . $admin->admin_photo))
                unlink($path . $admin->admin_photo);

            $photo->move($path . "/images/admins", "$photoName");
            $photoName = "/images/admins/" . $photoName;
        }
        $password = $admin->password;
        if (trim($request->password) != "")
            $password = Hash::make(trim($request->password));

        $admin->update([
            "admin_name" => trim($request->admin_name),
            "password" => $password,
            "admin_photo" => $photoName,
            "admin_rank" => $admin->admin_rank,
            "admin_status" => "online"
        ]);

        return redirect()->back()->with("success", "تم الحفظ بنجاح ");
    }
}

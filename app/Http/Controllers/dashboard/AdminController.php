<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Vistor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::paginate(5);
        return view("dashboard.admins.index", ["admins" => $admins]);
    }


    public function dashboard()
    {

        $todayVistors = number_format(Vistor::where('created_at', 'like', '%' . date('Y-m-d') . '%')->count());
        $allVistors =  number_format(Vistor::count());
        $adminName = Auth::guard('admin')->user()->admin_name;

        return view("dashboard.index", [
            "todayVistors" => $todayVistors,
            "allVistors" => $allVistors,
            "adminName" => $adminName
        ]);
    }

    public function login()
    {

        if (Admin::count() < 1) {
            $admin = Admin::create([
                "admin_name" => "admin",
                "password" => Hash::make("admin"),
                "admin_rank" => "owner",
                "admin_status" => "online"
            ]);
        }
        return view("dashboard.login");
    }

    public function logout()
    {
        Auth::guard("admin")->logout();

        return redirect()->route("dashboard.login");
    }
    public function attemptLogin(AdminRequest $request)
    {
        $request->validated();
        $data = $request->only("admin_name", "password");
        if (Auth::guard("admin")->attempt($data, true)) {
            return redirect()->route("dashboard.index");
        }

        return redirect()->back()->with("error", "الرجاء التحقق من البيانات !");
    }
    public function store(AdminRequest $request)
    {
        $request->validated();
        $admin = Admin::where("admin_name", $request->admin_name);

        if ($admin->exists()) {
            return redirect()->back()->with("error", "هذا المشرف موجود بالفعل");
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

        Admin::create([
            "admin_name" => trim($request->admin_name),
            "admin_rank" => "admin",
            "password" => $password,
            "admin_status" => "offline",
            "admin_photo" => $photoName,
        ]);

        return redirect()->back()->with("success", "تم اضافة المشرف بنجاح ");
    }



    public function edit($id)
    {
        $admin = Admin::findOrfail($id);
        return view("dashboard.admins.edit", ["admin" => $admin]);
    }

    public function update(AdminRequest $request)
    {
        $request->validated();
        $admin = Admin::find($request->id);

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


    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        $admin->delete();
        return redirect()->back()->with("success", "تم الحذف بنجاح ");
    }
}

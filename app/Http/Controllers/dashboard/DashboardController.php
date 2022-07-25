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

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
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
            $data["success"] = true;
            $data["message"] = "تم تسجيل الدخول بنجاح";
            return response()->json($data, 200);
        }

        $data["success"] = false;
        $data["message"] = "الرجاء التحقق من البيانات !";
        return response()->json($data, 200);
    }
}

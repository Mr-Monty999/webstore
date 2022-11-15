<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Vistor;
use App\Services\DashboardService;
use App\Services\UserService;
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

    public function __construct()
    {

        $this->middleware("permission:view-dashboard")->only("index");
    }


    public function index()
    {

        $todayVistors = DashboardService::todayVistors();
        $allVistors = number_format(DashboardService::allVistors());
        $userName = Auth::user()->name;

        return view("dashboard.index", [
            "todayVistors" => $todayVistors,
            "allVistors" => $allVistors,
            "userName" => $userName
        ]);
    }

    public function login()
    {

        UserService::createLoginDataIfNotExists();
        return view("dashboard.login");
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route("dashboard.login");
    }
    public function attemptLogin(UserLoginRequest $request)
    {

        $data = $request->only("name", "password");
        if (Auth::attempt($data, true)) {
            $data["success"] = true;
            $data["message"] = "تم تسجيل الدخول بنجاح";
            return response()->json($data, 200);
        }

        $data["success"] = false;
        $data["message"] = "الرجاء التحقق من البيانات !";
        return response()->json($data, 400);
    }
}

<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\DeleteService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PrivacyController extends Controller
{
    public function __construct()
    {

        // $this->middleware("permission:view-privacy")->only(["index", "show", "table"]);
        // $this->middleware("permission:edit-privacy")->only(["edit", "update"]);
    }
    public function index($id)
    {

        $user = User::find($id);
        return view("dashboard.privacy.index", compact("user"));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = UserService::updatePrivacy($request, $id);
        $data["success"] = true;
        $data["message"] = "تم الحفظ بنجاح";
        return response()->json($data);
    }
}

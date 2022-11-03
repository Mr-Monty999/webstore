<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\DeleteService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PrivacyController extends Controller
{
    public function index()
    {

        $user = User::find(Auth::id());
        return view("dashboard.privacy.index", ["user" => $user]);
    }

    public function update(Request $request)
    {
        $data = UserService::update($request, Auth::id());
        return response()->json($data);
    }
}

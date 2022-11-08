<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        return response()->json($users);
    }
    public function login(Request $request)
    {


        $user = UserService::login($request->only("name", "password"));
        if ($user)
            return response()->json($user);
        else
            return response()->json(null, 401);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        $data = UserService::store($request);
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = UserService::show($id);
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = UserService::update($request, $id);

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = UserService::destroy($id);

        return response()->json($data, 200);
    }
    public function destroyAll()
    {
        $data = UserService::destroyAll();

        return response()->json($data, 200);
    }
}

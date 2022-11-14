<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;


/**
 * @group users
 * @authenticated
 */
class UserController extends Controller
{


    public function __construct()
    {
        $this->middleware("permission:view-users")->only(["index", "show", "table"]);
        $this->middleware("permission:create-users")->only(["create", "store"]);
        $this->middleware("permission:edit-users")->only(["edit", "update"]);
        $this->middleware("permission:delete-users")->only("destroy", "destroyAll");
    }
    /**
     * Display all users (paginated) with their roles (paginated) and permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = UserService::getAllUsers();
        return response()->json($users);
    }
    /**
     *authenticated user and get the token
     * @unauthenticated
     */
    public function login(UserLoginRequest $request)
    {
        UserService::createLoginDataIfNotExists();

        $user = UserService::login($request->only("name", "password"));
        if ($user)
            return response()->json($user);
        else
            return response()->json(null, 400);
    }
    /**
     * Store a newly created user in database.
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
     * Display the specified user with it roles (paginated) and permissions.
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
     * Update the specified user in database.
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
     * Update the specified user privacy.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePrivacy(UpdateUserRequest $request, $id)
    {
        $data = UserService::updatePrivacy($request, $id);
        return response()->json($data, 200);
    }


    /**
     * Remove the specified user from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = UserService::destroy($id);

        return response()->json($data, 200);
    }

    /**
     * Remove all the users from database except the user with (owner role).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {

        $data = UserService::destroyAll();
        return response()->json($data, 200);
    }
}

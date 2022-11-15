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
     *@response {
    "current_page": 1,
    "data": [
        {
            "id": 3,
            "name": "f",
            "photo": "users/nCOQdMlXQVHwk9eVdvy1M0FHVTTiCvlL6SpcNm7l.jpg",
            "email_verified_at": null,
            "created_at": "2022-11-15T12:01:24.000000Z",
            "updated_at": "2022-11-15T12:01:24.000000Z",
            "roles": []
        },
        {
            "id": 4,
            "name": "owner",
            "photo": null,
            "email_verified_at": null,
            "created_at": "2022-11-15T12:07:34.000000Z",
            "updated_at": "2022-11-15T12:07:34.000000Z",
            "roles": [
                {
                    "id": 1,
                    "name": "owner",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:06.000000Z",
                    "updated_at": "2022-11-14T18:51:06.000000Z",
                    "pivot": {
                        "model_id": 4,
                        "role_id": 1,
                        "model_type": "App\\Models\\User"
                    },
                    "permissions": []
                }
            ]
        }
    ],
    "first_page_url": "http://localhost:8000/api/users?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://localhost:8000/api/users?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http://localhost:8000/api/users?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http://localhost:8000/api/users",
    "per_page": 5,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = UserService::getAllUsers();
        return response()->json($users);
    }
    /**
     *authenticated user and get the token
     *@response {
    "id": 1,
    "name": "owner",
    "photo": null,
    "email_verified_at": null,
    "created_at": "2022-11-14T18:51:05.000000Z",
    "updated_at": "2022-11-14T18:51:05.000000Z",
    "token": "3|x8a2zohvUSl6HcHoqqzMjouVY9XP138LvelPofcM",
    "permissions": [],
    "roles": [
        {
            "id": 1,
            "name": "owner",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:06.000000Z",
            "updated_at": "2022-11-14T18:51:06.000000Z",
            "pivot": {
                "model_id": 1,
                "role_id": 1,
                "model_type": "App\\Models\\User"
            },
            "permissions": []
        }
    ]
}
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
     *@response 201 {
    "name": "f",
    "photo": "users/nCOQdMlXQVHwk9eVdvy1M0FHVTTiCvlL6SpcNm7l.jpg",
    "updated_at": "2022-11-15T12:01:24.000000Z",
    "created_at": "2022-11-15T12:01:24.000000Z",
    "id": 3,
    "live_photo_path": "http://localhost:8000/storage/users/nCOQdMlXQVHwk9eVdvy1M0FHVTTiCvlL6SpcNm7l.jpg",
    "permissions": [],
    "roles": []
}
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
     *@response {
    "id": 4,
    "name": "owner",
    "photo": null,
    "email_verified_at": null,
    "created_at": "2022-11-15T12:07:34.000000Z",
    "updated_at": "2022-11-15T12:07:34.000000Z",
    "live_photo_path": "http://localhost:8000/storage",
    "roles": [
        {
            "id": 1,
            "name": "owner",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:06.000000Z",
            "updated_at": "2022-11-14T18:51:06.000000Z",
            "pivot": {
                "model_id": 4,
                "role_id": 1,
                "model_type": "App\\Models\\User"
            },
            "permissions": []
        }
    ]
}
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
     *@response {
    "id": 1,
    "name": "owner",
    "photo": null,
    "email_verified_at": null,
    "created_at": "2022-11-14T18:51:05.000000Z",
    "updated_at": "2022-11-14T18:51:05.000000Z",
    "live_photo_path": "http://localhost:8000/storage",
    "roles": [
        {
            "id": 1,
            "name": "owner",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:06.000000Z",
            "updated_at": "2022-11-14T18:51:06.000000Z",
            "pivot": {
                "model_id": 1,
                "role_id": 1,
                "model_type": "App\\Models\\User"
            },
            "permissions": []
        }
    ]
}
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
     *@urlParam user integer required  The id of the user
     *@response {
    "id": 1,
    "name": "owner",
    "photo": null,
    "email_verified_at": null,
    "created_at": "2022-11-14T18:51:05.000000Z",
    "updated_at": "2022-11-14T18:51:05.000000Z",
    "live_photo_path": "http://localhost:8000/storage",
    "roles": [
        {
            "id": 1,
            "name": "owner",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:06.000000Z",
            "updated_at": "2022-11-14T18:51:06.000000Z",
            "pivot": {
                "model_id": 1,
                "role_id": 1,
                "model_type": "App\\Models\\User"
            },
            "permissions": []
        }
    ]
}
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
     *@response {
    "id": 1,
    "name": "owner",
    "photo": "users/XsT2cz0DW3fcyk1koDBNsD0rjHxLgmmks5hy2tG4.jpg",
    "email_verified_at": null,
    "created_at": "2022-11-14T18:51:05.000000Z",
    "updated_at": "2022-11-15T12:05:31.000000Z",
    "live_photo_path": "http://localhost:8000/storage/users/XsT2cz0DW3fcyk1koDBNsD0rjHxLgmmks5hy2tG4.jpg"
}
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
     *@response 200
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {

        $data = UserService::destroyAll();
        return response()->json($data, 200);
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\PermissionService;
use Illuminate\Http\Request;


/**
 * @group permissions
 * @authenticated
 */
class PermissionController extends Controller
{
    /**
     * Display all the system permissions.
     *@response 200 [
    {
        "id": 1,
        "name": "view-dashboard",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:07.000000Z",
        "updated_at": "2022-11-14T18:51:07.000000Z"
    },
    {
        "id": 2,
        "name": "view-users",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:07.000000Z",
        "updated_at": "2022-11-14T18:51:07.000000Z"
    },
    {
        "id": 3,
        "name": "create-users",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:08.000000Z",
        "updated_at": "2022-11-14T18:51:08.000000Z"
    },
    {
        "id": 4,
        "name": "edit-users",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:08.000000Z",
        "updated_at": "2022-11-14T18:51:08.000000Z"
    },
    {
        "id": 5,
        "name": "delete-users",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:08.000000Z",
        "updated_at": "2022-11-14T18:51:08.000000Z"
    },
    {
        "id": 6,
        "name": "view-items",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:09.000000Z",
        "updated_at": "2022-11-14T18:51:09.000000Z"
    },
    {
        "id": 7,
        "name": "create-items",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:09.000000Z",
        "updated_at": "2022-11-14T18:51:09.000000Z"
    },
    {
        "id": 8,
        "name": "edit-items",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:09.000000Z",
        "updated_at": "2022-11-14T18:51:09.000000Z"
    },
    {
        "id": 9,
        "name": "delete-items",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:09.000000Z",
        "updated_at": "2022-11-14T18:51:09.000000Z"
    },
    {
        "id": 10,
        "name": "view-products",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:10.000000Z",
        "updated_at": "2022-11-14T18:51:10.000000Z"
    },
    {
        "id": 11,
        "name": "create-products",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:10.000000Z",
        "updated_at": "2022-11-14T18:51:10.000000Z"
    },
    {
        "id": 12,
        "name": "edit-products",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:10.000000Z",
        "updated_at": "2022-11-14T18:51:10.000000Z"
    },
    {
        "id": 13,
        "name": "delete-products",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:10.000000Z",
        "updated_at": "2022-11-14T18:51:10.000000Z"
    },
    {
        "id": 14,
        "name": "view-settings",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:11.000000Z",
        "updated_at": "2022-11-14T18:51:11.000000Z"
    },
    {
        "id": 15,
        "name": "create-settings",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:11.000000Z",
        "updated_at": "2022-11-14T18:51:11.000000Z"
    },
    {
        "id": 16,
        "name": "edit-settings",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:11.000000Z",
        "updated_at": "2022-11-14T18:51:11.000000Z"
    },
    {
        "id": 17,
        "name": "delete-settings",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:12.000000Z",
        "updated_at": "2022-11-14T18:51:12.000000Z"
    },
    {
        "id": 18,
        "name": "view-feedbacks",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:12.000000Z",
        "updated_at": "2022-11-14T18:51:12.000000Z"
    },
    {
        "id": 19,
        "name": "delete-feedbacks",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:12.000000Z",
        "updated_at": "2022-11-14T18:51:12.000000Z"
    },
    {
        "id": 20,
        "name": "view-roles",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:13.000000Z",
        "updated_at": "2022-11-14T18:51:13.000000Z"
    },
    {
        "id": 21,
        "name": "create-roles",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:13.000000Z",
        "updated_at": "2022-11-14T18:51:13.000000Z"
    },
    {
        "id": 22,
        "name": "edit-roles",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:13.000000Z",
        "updated_at": "2022-11-14T18:51:13.000000Z"
    },
    {
        "id": 23,
        "name": "delete-roles",
        "guard_name": "web",
        "created_at": "2022-11-14T18:51:14.000000Z",
        "updated_at": "2022-11-14T18:51:14.000000Z"
    }
]
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = PermissionService::getAllPermissions();

        return response()->json($permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

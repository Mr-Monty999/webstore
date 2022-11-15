<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;


/**
 * @group roles
 * @authenticated
 */
class RoleController extends Controller
{
    /**
     * Display all the roles (paginated) with their permissions.
     *@response {
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "owner",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:06.000000Z",
            "updated_at": "2022-11-14T18:51:06.000000Z",
            "permissions": []
        },
        {
            "id": 2,
            "name": "admin",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:07.000000Z",
            "updated_at": "2022-11-14T18:51:07.000000Z",
            "permissions": [
                {
                    "id": 1,
                    "name": "view-dashboard",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:07.000000Z",
                    "updated_at": "2022-11-14T18:51:07.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 1
                    }
                },
                {
                    "id": 2,
                    "name": "view-users",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:07.000000Z",
                    "updated_at": "2022-11-14T18:51:07.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 2
                    }
                },
                {
                    "id": 3,
                    "name": "create-users",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:08.000000Z",
                    "updated_at": "2022-11-14T18:51:08.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 3
                    }
                },
                {
                    "id": 4,
                    "name": "edit-users",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:08.000000Z",
                    "updated_at": "2022-11-14T18:51:08.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 4
                    }
                },
                {
                    "id": 5,
                    "name": "delete-users",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:08.000000Z",
                    "updated_at": "2022-11-14T18:51:08.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 5
                    }
                },
                {
                    "id": 6,
                    "name": "view-items",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:09.000000Z",
                    "updated_at": "2022-11-14T18:51:09.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 6
                    }
                },
                {
                    "id": 7,
                    "name": "create-items",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:09.000000Z",
                    "updated_at": "2022-11-14T18:51:09.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 7
                    }
                },
                {
                    "id": 8,
                    "name": "edit-items",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:09.000000Z",
                    "updated_at": "2022-11-14T18:51:09.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 8
                    }
                },
                {
                    "id": 9,
                    "name": "delete-items",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:09.000000Z",
                    "updated_at": "2022-11-14T18:51:09.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 9
                    }
                },
                {
                    "id": 10,
                    "name": "view-products",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:10.000000Z",
                    "updated_at": "2022-11-14T18:51:10.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 10
                    }
                },
                {
                    "id": 11,
                    "name": "create-products",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:10.000000Z",
                    "updated_at": "2022-11-14T18:51:10.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 11
                    }
                },
                {
                    "id": 12,
                    "name": "edit-products",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:10.000000Z",
                    "updated_at": "2022-11-14T18:51:10.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 12
                    }
                },
                {
                    "id": 13,
                    "name": "delete-products",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:10.000000Z",
                    "updated_at": "2022-11-14T18:51:10.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 13
                    }
                },
                {
                    "id": 14,
                    "name": "view-settings",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:11.000000Z",
                    "updated_at": "2022-11-14T18:51:11.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 14
                    }
                },
                {
                    "id": 15,
                    "name": "create-settings",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:11.000000Z",
                    "updated_at": "2022-11-14T18:51:11.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 15
                    }
                },
                {
                    "id": 16,
                    "name": "edit-settings",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:11.000000Z",
                    "updated_at": "2022-11-14T18:51:11.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 16
                    }
                },
                {
                    "id": 17,
                    "name": "delete-settings",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:12.000000Z",
                    "updated_at": "2022-11-14T18:51:12.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 17
                    }
                },
                {
                    "id": 18,
                    "name": "view-feedbacks",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:12.000000Z",
                    "updated_at": "2022-11-14T18:51:12.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 18
                    }
                },
                {
                    "id": 19,
                    "name": "delete-feedbacks",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:12.000000Z",
                    "updated_at": "2022-11-14T18:51:12.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 19
                    }
                },
                {
                    "id": 20,
                    "name": "view-roles",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:13.000000Z",
                    "updated_at": "2022-11-14T18:51:13.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 20
                    }
                },
                {
                    "id": 21,
                    "name": "create-roles",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:13.000000Z",
                    "updated_at": "2022-11-14T18:51:13.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 21
                    }
                },
                {
                    "id": 22,
                    "name": "edit-roles",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:13.000000Z",
                    "updated_at": "2022-11-14T18:51:13.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 22
                    }
                },
                {
                    "id": 23,
                    "name": "delete-roles",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:14.000000Z",
                    "updated_at": "2022-11-14T18:51:14.000000Z",
                    "pivot": {
                        "role_id": 2,
                        "permission_id": 23
                    }
                }
            ]
        },
        {
            "id": 3,
            "name": "g",
            "guard_name": "web",
            "created_at": "2022-11-14T20:43:16.000000Z",
            "updated_at": "2022-11-14T20:43:16.000000Z",
            "permissions": [
                {
                    "id": 1,
                    "name": "view-dashboard",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:07.000000Z",
                    "updated_at": "2022-11-14T18:51:07.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 1
                    }
                },
                {
                    "id": 2,
                    "name": "view-users",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:07.000000Z",
                    "updated_at": "2022-11-14T18:51:07.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 2
                    }
                },
                {
                    "id": 3,
                    "name": "create-users",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:08.000000Z",
                    "updated_at": "2022-11-14T18:51:08.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 3
                    }
                },
                {
                    "id": 4,
                    "name": "edit-users",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:08.000000Z",
                    "updated_at": "2022-11-14T18:51:08.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 4
                    }
                },
                {
                    "id": 5,
                    "name": "delete-users",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:08.000000Z",
                    "updated_at": "2022-11-14T18:51:08.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 5
                    }
                },
                {
                    "id": 6,
                    "name": "view-items",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:09.000000Z",
                    "updated_at": "2022-11-14T18:51:09.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 6
                    }
                },
                {
                    "id": 7,
                    "name": "create-items",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:09.000000Z",
                    "updated_at": "2022-11-14T18:51:09.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 7
                    }
                },
                {
                    "id": 8,
                    "name": "edit-items",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:09.000000Z",
                    "updated_at": "2022-11-14T18:51:09.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 8
                    }
                },
                {
                    "id": 9,
                    "name": "delete-items",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:09.000000Z",
                    "updated_at": "2022-11-14T18:51:09.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 9
                    }
                },
                {
                    "id": 10,
                    "name": "view-products",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:10.000000Z",
                    "updated_at": "2022-11-14T18:51:10.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 10
                    }
                },
                {
                    "id": 11,
                    "name": "create-products",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:10.000000Z",
                    "updated_at": "2022-11-14T18:51:10.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 11
                    }
                },
                {
                    "id": 12,
                    "name": "edit-products",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:10.000000Z",
                    "updated_at": "2022-11-14T18:51:10.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 12
                    }
                },
                {
                    "id": 13,
                    "name": "delete-products",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:10.000000Z",
                    "updated_at": "2022-11-14T18:51:10.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 13
                    }
                },
                {
                    "id": 14,
                    "name": "view-settings",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:11.000000Z",
                    "updated_at": "2022-11-14T18:51:11.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 14
                    }
                },
                {
                    "id": 15,
                    "name": "create-settings",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:11.000000Z",
                    "updated_at": "2022-11-14T18:51:11.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 15
                    }
                },
                {
                    "id": 16,
                    "name": "edit-settings",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:11.000000Z",
                    "updated_at": "2022-11-14T18:51:11.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 16
                    }
                },
                {
                    "id": 17,
                    "name": "delete-settings",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:12.000000Z",
                    "updated_at": "2022-11-14T18:51:12.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 17
                    }
                },
                {
                    "id": 18,
                    "name": "view-feedbacks",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:12.000000Z",
                    "updated_at": "2022-11-14T18:51:12.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 18
                    }
                },
                {
                    "id": 19,
                    "name": "delete-feedbacks",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:12.000000Z",
                    "updated_at": "2022-11-14T18:51:12.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 19
                    }
                },
                {
                    "id": 20,
                    "name": "view-roles",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:13.000000Z",
                    "updated_at": "2022-11-14T18:51:13.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 20
                    }
                },
                {
                    "id": 21,
                    "name": "create-roles",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:13.000000Z",
                    "updated_at": "2022-11-14T18:51:13.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 21
                    }
                },
                {
                    "id": 22,
                    "name": "edit-roles",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:13.000000Z",
                    "updated_at": "2022-11-14T18:51:13.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 22
                    }
                },
                {
                    "id": 23,
                    "name": "delete-roles",
                    "guard_name": "web",
                    "created_at": "2022-11-14T18:51:14.000000Z",
                    "updated_at": "2022-11-14T18:51:14.000000Z",
                    "pivot": {
                        "role_id": 3,
                        "permission_id": 23
                    }
                }
            ]
        }
    ],
    "first_page_url": "http://localhost:8000/api/roles?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://localhost:8000/api/roles?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http://localhost:8000/api/roles?page=1",
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
    "path": "http://localhost:8000/api/roles",
    "per_page": 5,
    "prev_page_url": null,
    "to": 3,
    "total": 3
}
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = RoleService::getAllRoles();
        return response()->json($roles);
    }

    /**
     * Store a newly created role in database.
     *@bodyParam permissions int[] or string[] (array of ids or array of names)
     *@response 201 {
    "id": 2,
    "name": "admin",
    "guard_name": "web",
    "created_at": "2022-11-14T18:51:07.000000Z",
    "updated_at": "2022-11-14T18:51:07.000000Z",

}
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        $role = RoleService::store($request->name);
        if (isset($request->permissions)) {
            $permissions = $request->permissions;
            $role->syncPermissions($permissions);
        }
        return response()->json($role, 201);
    }

    /**
     * Display the specified role with it permissions.
     *@response {
    "id": 2,
    "name": "admin",
    "guard_name": "web",
    "created_at": "2022-11-14T18:51:07.000000Z",
    "updated_at": "2022-11-14T18:51:07.000000Z",
    "permissions": [
        {
            "id": 1,
            "name": "view-dashboard",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:07.000000Z",
            "updated_at": "2022-11-14T18:51:07.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 1
            }
        },
        {
            "id": 2,
            "name": "view-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:07.000000Z",
            "updated_at": "2022-11-14T18:51:07.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 2
            }
        },
        {
            "id": 3,
            "name": "create-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:08.000000Z",
            "updated_at": "2022-11-14T18:51:08.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 3
            }
        },
        {
            "id": 4,
            "name": "edit-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:08.000000Z",
            "updated_at": "2022-11-14T18:51:08.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 4
            }
        },
        {
            "id": 5,
            "name": "delete-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:08.000000Z",
            "updated_at": "2022-11-14T18:51:08.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 5
            }
        },
        {
            "id": 6,
            "name": "view-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 6
            }
        },
        {
            "id": 7,
            "name": "create-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 7
            }
        },
        {
            "id": 8,
            "name": "edit-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 8
            }
        },
        {
            "id": 9,
            "name": "delete-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 9
            }
        },
        {
            "id": 10,
            "name": "view-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 10
            }
        },
        {
            "id": 11,
            "name": "create-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 11
            }
        },
        {
            "id": 12,
            "name": "edit-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 12
            }
        },
        {
            "id": 13,
            "name": "delete-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 13
            }
        },
        {
            "id": 14,
            "name": "view-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:11.000000Z",
            "updated_at": "2022-11-14T18:51:11.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 14
            }
        },
        {
            "id": 15,
            "name": "create-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:11.000000Z",
            "updated_at": "2022-11-14T18:51:11.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 15
            }
        },
        {
            "id": 16,
            "name": "edit-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:11.000000Z",
            "updated_at": "2022-11-14T18:51:11.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 16
            }
        },
        {
            "id": 17,
            "name": "delete-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:12.000000Z",
            "updated_at": "2022-11-14T18:51:12.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 17
            }
        },
        {
            "id": 18,
            "name": "view-feedbacks",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:12.000000Z",
            "updated_at": "2022-11-14T18:51:12.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 18
            }
        },
        {
            "id": 19,
            "name": "delete-feedbacks",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:12.000000Z",
            "updated_at": "2022-11-14T18:51:12.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 19
            }
        },
        {
            "id": 20,
            "name": "view-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:13.000000Z",
            "updated_at": "2022-11-14T18:51:13.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 20
            }
        },
        {
            "id": 21,
            "name": "create-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:13.000000Z",
            "updated_at": "2022-11-14T18:51:13.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 21
            }
        },
        {
            "id": 22,
            "name": "edit-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:13.000000Z",
            "updated_at": "2022-11-14T18:51:13.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 22
            }
        },
        {
            "id": 23,
            "name": "delete-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:14.000000Z",
            "updated_at": "2022-11-14T18:51:14.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 23
            }
        }
    ]
}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $role = RoleService::show($id);
        return response()->json($role);
    }

    /**
     * Update the specified role in database.
     * @bodyParam permissions int[] or string[] (array of ids or array of names)
     * @response {
    "id": 2,
    "name": "admin",
    "guard_name": "web",
    "created_at": "2022-11-14T18:51:07.000000Z",
    "updated_at": "2022-11-14T18:51:07.000000Z",
    "permissions": [
        {
            "id": 1,
            "name": "view-dashboard",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:07.000000Z",
            "updated_at": "2022-11-14T18:51:07.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 1
            }
        },
        {
            "id": 2,
            "name": "view-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:07.000000Z",
            "updated_at": "2022-11-14T18:51:07.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 2
            }
        },
        {
            "id": 3,
            "name": "create-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:08.000000Z",
            "updated_at": "2022-11-14T18:51:08.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 3
            }
        },
        {
            "id": 4,
            "name": "edit-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:08.000000Z",
            "updated_at": "2022-11-14T18:51:08.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 4
            }
        },
        {
            "id": 5,
            "name": "delete-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:08.000000Z",
            "updated_at": "2022-11-14T18:51:08.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 5
            }
        },
        {
            "id": 6,
            "name": "view-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 6
            }
        },
        {
            "id": 7,
            "name": "create-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 7
            }
        },
        {
            "id": 8,
            "name": "edit-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 8
            }
        },
        {
            "id": 9,
            "name": "delete-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 9
            }
        },
        {
            "id": 10,
            "name": "view-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 10
            }
        },
        {
            "id": 11,
            "name": "create-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 11
            }
        },
        {
            "id": 12,
            "name": "edit-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 12
            }
        },
        {
            "id": 13,
            "name": "delete-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 13
            }
        },
        {
            "id": 14,
            "name": "view-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:11.000000Z",
            "updated_at": "2022-11-14T18:51:11.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 14
            }
        },
        {
            "id": 15,
            "name": "create-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:11.000000Z",
            "updated_at": "2022-11-14T18:51:11.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 15
            }
        },
        {
            "id": 16,
            "name": "edit-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:11.000000Z",
            "updated_at": "2022-11-14T18:51:11.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 16
            }
        },
        {
            "id": 17,
            "name": "delete-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:12.000000Z",
            "updated_at": "2022-11-14T18:51:12.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 17
            }
        },
        {
            "id": 18,
            "name": "view-feedbacks",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:12.000000Z",
            "updated_at": "2022-11-14T18:51:12.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 18
            }
        },
        {
            "id": 19,
            "name": "delete-feedbacks",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:12.000000Z",
            "updated_at": "2022-11-14T18:51:12.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 19
            }
        },
        {
            "id": 20,
            "name": "view-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:13.000000Z",
            "updated_at": "2022-11-14T18:51:13.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 20
            }
        },
        {
            "id": 21,
            "name": "create-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:13.000000Z",
            "updated_at": "2022-11-14T18:51:13.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 21
            }
        },
        {
            "id": 22,
            "name": "edit-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:13.000000Z",
            "updated_at": "2022-11-14T18:51:13.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 22
            }
        },
        {
            "id": 23,
            "name": "delete-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:14.000000Z",
            "updated_at": "2022-11-14T18:51:14.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 23
            }
        }
    ]
}
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        $role = RoleService::update($request->all(), $id);
        if (isset($request->permissions)) {
            $permissions = $request->permissions;
            $role->syncPermissions($permissions);
        }
        return response()->json($role);
    }

    /**
     * Remove the specified role from database.
     *@response {
    "id": 2,
    "name": "admin",
    "guard_name": "web",
    "created_at": "2022-11-14T18:51:07.000000Z",
    "updated_at": "2022-11-14T18:51:07.000000Z",
    "permissions": [
        {
            "id": 1,
            "name": "view-dashboard",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:07.000000Z",
            "updated_at": "2022-11-14T18:51:07.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 1
            }
        },
        {
            "id": 2,
            "name": "view-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:07.000000Z",
            "updated_at": "2022-11-14T18:51:07.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 2
            }
        },
        {
            "id": 3,
            "name": "create-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:08.000000Z",
            "updated_at": "2022-11-14T18:51:08.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 3
            }
        },
        {
            "id": 4,
            "name": "edit-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:08.000000Z",
            "updated_at": "2022-11-14T18:51:08.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 4
            }
        },
        {
            "id": 5,
            "name": "delete-users",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:08.000000Z",
            "updated_at": "2022-11-14T18:51:08.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 5
            }
        },
        {
            "id": 6,
            "name": "view-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 6
            }
        },
        {
            "id": 7,
            "name": "create-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 7
            }
        },
        {
            "id": 8,
            "name": "edit-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 8
            }
        },
        {
            "id": 9,
            "name": "delete-items",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:09.000000Z",
            "updated_at": "2022-11-14T18:51:09.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 9
            }
        },
        {
            "id": 10,
            "name": "view-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 10
            }
        },
        {
            "id": 11,
            "name": "create-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 11
            }
        },
        {
            "id": 12,
            "name": "edit-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 12
            }
        },
        {
            "id": 13,
            "name": "delete-products",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:10.000000Z",
            "updated_at": "2022-11-14T18:51:10.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 13
            }
        },
        {
            "id": 14,
            "name": "view-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:11.000000Z",
            "updated_at": "2022-11-14T18:51:11.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 14
            }
        },
        {
            "id": 15,
            "name": "create-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:11.000000Z",
            "updated_at": "2022-11-14T18:51:11.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 15
            }
        },
        {
            "id": 16,
            "name": "edit-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:11.000000Z",
            "updated_at": "2022-11-14T18:51:11.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 16
            }
        },
        {
            "id": 17,
            "name": "delete-settings",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:12.000000Z",
            "updated_at": "2022-11-14T18:51:12.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 17
            }
        },
        {
            "id": 18,
            "name": "view-feedbacks",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:12.000000Z",
            "updated_at": "2022-11-14T18:51:12.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 18
            }
        },
        {
            "id": 19,
            "name": "delete-feedbacks",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:12.000000Z",
            "updated_at": "2022-11-14T18:51:12.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 19
            }
        },
        {
            "id": 20,
            "name": "view-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:13.000000Z",
            "updated_at": "2022-11-14T18:51:13.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 20
            }
        },
        {
            "id": 21,
            "name": "create-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:13.000000Z",
            "updated_at": "2022-11-14T18:51:13.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 21
            }
        },
        {
            "id": 22,
            "name": "edit-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:13.000000Z",
            "updated_at": "2022-11-14T18:51:13.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 22
            }
        },
        {
            "id": 23,
            "name": "delete-roles",
            "guard_name": "web",
            "created_at": "2022-11-14T18:51:14.000000Z",
            "updated_at": "2022-11-14T18:51:14.000000Z",
            "pivot": {
                "role_id": 2,
                "permission_id": 23
            }
        }
    ]
}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = RoleService::delete($id);
        return response()->json($role);
    }
    /**
     * Remove all the roles from database.
     *@response 200
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {
        $role = RoleService::destroyAll();
        return response()->json($role);
    }
}

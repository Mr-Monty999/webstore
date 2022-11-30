<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;
use Illuminate\Http\Request;

/**
 * @group items
 * @authenticated
 */
class ItemController extends Controller
{


    public function __construct()
    {

        $this->middleware("permission:view-items")->only(["index", "show", "table"]);
        $this->middleware("permission:create-items")->only(["create", "store"]);
        $this->middleware("permission:edit-items")->only(["edit", "update"]);
        $this->middleware("permission:delete-items")->only("destroy", "destroyAll");
    }
    /**
     * Display all items (paginated) with their products (paginated).
     *@response {
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "d",
            "photo": null,
            "created_at": "2022-11-14T18:55:53.000000Z",
            "updated_at": "2022-11-14T18:55:53.000000Z",
            "products": [
                {
                    "id": 1,
                    "name": "دجاج",
                    "price": 300,
                    "discount": 10,
                    "photo": null,
                    "item_id": 1,
                    "created_at": "2022-11-14T18:56:02.000000Z",
                    "updated_at": "2022-11-14T18:56:02.000000Z"
                },
                {
                    "id": 2,
                    "name": "شاورما",
                    "price": 300,
                    "discount": 10,
                    "photo": null,
                    "item_id": 1,
                    "created_at": "2022-11-14T18:56:07.000000Z",
                    "updated_at": "2022-11-14T18:56:07.000000Z"
                }
            ]
        }
    ],
    "first_page_url": "http://localhost:8000/api/items?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://localhost:8000/api/items?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http://localhost:8000/api/items?page=1",
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
    "path": "http://localhost:8000/api/items",
    "per_page": 5,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $items = ItemService::getAllItems();
        return response()->json($items);
    }

    /**
     * Store a newly created item in database.
     *@response 201 {
    "id": 4,
    "name": "إلكترونيات",
    "photo": "items/98RZDAC2vIBNC3zK5844F3I9vqMiKBQKUgLWBiOE.jpg",
    "created_at": "2022-11-15T11:17:04.000000Z",
    "updated_at": "2022-11-15T11:17:27.000000Z",
    "live_photo_path": "http://localhost:8000/storage/items/98RZDAC2vIBNC3zK5844F3I9vqMiKBQKUgLWBiOE.jpg",
}
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {

        $data = ItemService::store($request);
        return response()->json($data, 201);
    }

    /**
     * Display the specified item with it products (paginated).
     *@response {
    "id": 1,
    "name": "d",
    "photo": "items/98RZDAC2vIBNC3zK5844F3I9vqMiKBQKUgLWBiOE.jpg",
    "created_at": "2022-11-14T18:55:53.000000Z",
    "updated_at": "2022-11-14T18:55:53.000000Z",
    "live_photo_path": "http://localhost:8000/storage/items/98RZDAC2vIBNC3zK5844F3I9vqMiKBQKUgLWBiOE.jpg",
    "products": [
        {
            "id": 1,
            "name": "دجاج",
            "price": 300,
            "discount": 10,
            "photo": null,
            "item_id": 1,
            "created_at": "2022-11-14T18:56:02.000000Z",
            "updated_at": "2022-11-14T18:56:02.000000Z"
        },
        {
            "id": 2,
            "name": "شاورما",
            "price": 300,
            "discount": 10,
            "photo": null,
            "item_id": 1,
            "created_at": "2022-11-14T18:56:07.000000Z",
            "updated_at": "2022-11-14T18:56:07.000000Z"
        }
    ]
}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = ItemService::show($id);
        return response()->json($item);
    }

    /**
     * Update the specified item in database.
     * @response  {
    "id": 4,
    "name": "إلكترونيات",
    "photo": "items/98RZDAC2vIBNC3zK5844F3I9vqMiKBQKUgLWBiOE.jpg",
    "created_at": "2022-11-15T11:17:04.000000Z",
    "updated_at": "2022-11-15T11:17:27.000000Z",
    "live_photo_path": "http://localhost:8000/storage/items/98RZDAC2vIBNC3zK5844F3I9vqMiKBQKUgLWBiOE.jpg",
}
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, $id)
    {
        $data = ItemService::update($request, $id);
        return response()->json($data);
    }

    /**
     * Remove the specified item from database.
     *@response  {
    "id": 4,
    "name": "إلكترونيات",
    "photo": "items/98RZDAC2vIBNC3zK5844F3I9vqMiKBQKUgLWBiOE.jpg",
    "created_at": "2022-11-15T11:17:04.000000Z",
    "updated_at": "2022-11-15T11:17:27.000000Z",
    "live_photo_path": "http://localhost:8000/storage/items/98RZDAC2vIBNC3zK5844F3I9vqMiKBQKUgLWBiOE.jpg",
}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = ItemService::destroy($id);
        return response()->json($item);
    }
    /**
     * Remove the all items from database.
     *@response 200
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {
        $data = ItemService::destroyAll();
        return response()->json($data);
    }
}

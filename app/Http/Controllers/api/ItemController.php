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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $items = ItemService::getAllItems();
        return response()->json($items);
    }

    /**
     * Store a newly created item in database.
     *
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
     *
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
     *
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
     *
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {
        $data = ItemService::destroyAll();
        return response()->json($data);
    }
}

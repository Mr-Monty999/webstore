<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use App\Services\ItemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

        $this->middleware("permission:view-items")->only(["index", "show", "table"]);
        $this->middleware("permission:create-items")->only(["create", "store"]);
        $this->middleware("permission:edit-items")->only(["edit", "update"]);
        $this->middleware("permission:delete-items")->only("delete", "deleteAll");
    }
    public function index()
    {
        $items = ItemService::getAllItems();
        return view("dashboard.items.index", ["items" => $items]);
    }

    public function table($pageNumber)
    {
        $items = ItemService::table($pageNumber);
        return view("dashboard.items.table", ["items" => $items]);
    }



    public function store(ItemRequest $request)
    {
        $data = ItemService::store($request->all());
        return response()->json($data, 200);
    }


    public function edit($id)
    {
        $item = ItemService::show($id);
        return view("dashboard.items.edit", ["item" => $item]);
    }


    public function update(ItemRequest $request, $id)
    {
        $data = ItemService::update($request->all(), $id);

        return response()->json($data, 200);
    }

    public function destroy(Request $request, $id)
    {
        ItemService::destroy($request->id);
        $data["success"] = true;
        $data["message"] = "تم الحذف بنجاح";

        return response()->json($data);
    }

    public function destroyAll()
    {
        ItemService::destroyAll();
        $data["success"] = true;
        $data["message"] = "تم حذف جميع الاصناف بنجاح";
        return response()->json($data);
    }
}

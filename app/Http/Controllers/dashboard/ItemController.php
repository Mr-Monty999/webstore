<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
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
        $this->middleware("permission:delete-items")->only("destroy", "destroyAll");
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



    public function store(StoreItemRequest $request)
    {
        $data = ItemService::store($request);
        $data["success"] = true;
        $data["message"] = "تم الاضافة بنجاح";
        return response()->json($data, 201);
    }


    public function edit($id)
    {
        $item = ItemService::show($id);
        return view("dashboard.items.edit", ["item" => $item]);
    }


    public function update(UpdateItemRequest $request, $id)
    {
        $data = ItemService::update($request, $id);
        $data["success"] = true;
        $data["message"] = "تم التعديل بنجاح";
        return response()->json($data);
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

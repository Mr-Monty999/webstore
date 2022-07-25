<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
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
    public function index()
    {
        $items = Item::paginate(5)->onEachSide(0);
        return view("dashboard.items.index", ["items" => $items]);
    }

    public function table()
    {
        $items = Item::paginate(5)->withPath(route("items.index"))->onEachSide(0);
        return view("dashboard.items.table", ["items" => $items]);
    }

    public function store(ItemRequest $request)
    {
        $request->validated();
        $data = $request->all();

        $exists = Item::where("item_name", $request->item_name)->exists();


        if (!$exists) {
            Item::create($data);
            $data["success"] = true;
            $data["message"] = "تم الاضافة بنجاح";

            return response()->json($data, 200);
        }

        $data["success"] = false;
        $data["message"] = "هذا المنتج موجود بالفعل !";

        return response()->json($data, 200);
    }


    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view("dashboard.items.edit", ["item" => $item]);
    }


    public function update(ItemRequest $request, $id)
    {
        $request->validated();
        $data = $request->all();

        $item = Item::find($id);
        $oldItem = Item::where("item_name", $request->item_name);



        if ($oldItem->exists() && $item->item_name != $oldItem->first()->item_name) {
            $data["success"] = false;
            $data["message"] = "هذا الصنف موجود فعلا !";

            return response()->json($data, 200);
        }

        $item->update($data);

        $data["success"] = true;
        $data["message"] = "تم التعديل بنجاح";

        return response()->json($data, 200);
    }

    public function destroy(Request $request, $id)
    {
        $item = Item::find($request->id);
        $data["item"] = $item;
        $item->delete();
        $data["success"] = true;
        $data["message"] = "تم الحذف بنجاح";

        return response()->json($data);
    }

    public function destroyAll()
    {
        DB::table("items")->delete();
        $data["success"] = true;
        $data["message"] = "تم حذف جميع الاصناف بنجاح";
        return response()->json($data);
    }
}

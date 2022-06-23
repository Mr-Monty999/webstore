<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::paginate(5);
        return view("dashboard.items.index", ["items" => $items]);
    }


    public function store(ItemRequest $request)
    {
        $request->validated();

        $exists = Item::where("item_name", $request->item_name)->exists();


        if (!$exists) {
            Item::create([
                "item_name" => trim($request->item_name)
            ]);

            return redirect()->back()->with("success", "تم الاضافة بنجاح");
        }

        return redirect()->back()->with("error", "هذا الصنف موجود بالفعل");
    }


    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view("dashboard.items.edit", ["item" => $item]);
    }


    public function update(ItemRequest $request, $id)
    {
        $request->validated();
        $item = Item::find($id);
        $oldItem = Item::where("item_name", $request->item_name);



        if ($oldItem->exists() && $item->item_name != $oldItem->first()->item_name) {
            return redirect()->back()->with("error", "هذا الصنف موجود فعلا !");
        }

        $item->update([
            "item_name" => trim($request->item_name)
        ]);
        return redirect()->back()->with("success", "تم التعديل بنجاح");
    }

    public function destroy($id)
    {
        $item = Item::find($id);

        $item->delete();

        return redirect()->back()->with("success", "تم الحذف بنجاح");
    }
}

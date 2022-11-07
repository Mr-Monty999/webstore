<?php

namespace App\Services;

use App\Models\Item;
use DB;
use Storage;

/**
 * Class ItemService.
 */
class ItemService
{

    public static function getAllItems()
    {

        $items = Item::paginate(5)->onEachSide(0);
        return $items;
    }

    public static function table($pageNumber)
    {
        $items = Item::paginate(5, ['*'], 'page', $pageNumber)->withPath(route("items.index"))->onEachSide(0);
        return $items;
    }



    public static function store($data)
    {

        $exists = Item::where("item_name", $data["item_name"])->exists();


        if (!$exists) {
            Item::create($data);
            $data["success"] = true;
            $data["message"] = "تم الاضافة بنجاح";

            return $data;
        }

        $data["success"] = false;
        $data["message"] = "هذا المنتج موجود بالفعل !";


        return $data;
    }


    public static function show($id)
    {
        $item = Item::findOrFail($id);
        return $item;
    }


    public static function update($data, $id)
    {

        $item = Item::find($id);
        $oldItem = Item::where("item_name", $data["item_name"]);



        if ($oldItem->exists() && $item->item_name != $oldItem->first()->item_name) {
            $data["success"] = false;
            $data["message"] = "هذا الصنف موجود فعلا !";

            return $data;
        }

        $item->update($data);

        $data["success"] = true;
        $data["message"] = "تم التعديل بنجاح";

        return $data;
    }

    public static function destroy($id)
    {
        $item = Item::findOrFail($id);
        $data["item"] = $item;
        Storage::disk("public")->delete($item->products->pluck("product_photo")->toArray());
        $item->delete();


        return $data;
    }

    public static function destroyAll()
    {

        DB::table("items")->delete();
        Storage::disk("public")->deleteDirectory("products");
        return true;
    }
}

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


        $item =  Item::create($data);


        return $item;
    }


    public static function show($id)
    {
        $item = Item::findOrFail($id);
        return $item;
    }


    public static function update($data, $id)
    {

        $item = Item::findOrFail($id);

        $item->update($data);


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

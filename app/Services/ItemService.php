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

        $items = Item::with(["products" => function ($q) {
            $q->paginate(5);
        }])->paginate(5);
        return $items;
    }

    public static function table($pageNumber)
    {
        $items = Item::paginate(5, ['*'], 'page', $pageNumber)->withPath(route("items.index"));
        return $items;
    }



    public static function store($request)
    {


        $data = $request->all();

        if ($request->hasFile("item_photo")) {
            // $photo = $request->file("item_photo")->store("items", "public");
            $photo =  FileService::uploadFile($request->file("item_photo"), "items");
            $data["item_photo"] = $photo;
        }
        $item =  Item::create($data);

        if (isset($data["item_photo"]))
            $item["live_photo_path"] = asset("storage/" . $data["item_photo"]);



        return $item;
    }


    public static function show($id)
    {
        $item = Item::with(["products" => function ($q) {
            $q->paginate(5);
        }])->findOrFail($id);

        if (isset($item->item_photo))
            $item["live_photo_path"] = asset("storage/" . $item->item_photo);
        return $item;
    }


    public static function update($request, $id)
    {
        $data = $request->all();
        $item = Item::findOrFail($id);


        $data["item_photo"] = $item->item_photo;
        if ($request->hasFile("item_photo")) {
            // Storage::disk("public")->delete($item->item_photo);
            // $photo = $request->file("item_photo")->store("items", "public");
            FileService::deleteFile($item->item_photo);
            $photo =  FileService::uploadFile($request->file("item_photo"), "items");
            $data["item_photo"] = $photo;
        }
        $item->update($data);
        $item["live_photo_path"] = asset("storage/" . $data["item_photo"]);



        return $item;
    }

    public static function destroy($id)
    {
        $item = Item::findOrFail($id);
        if (isset($item->item_photo))
            $item["live_photo_path"] = asset("storage/" . $item->item_photo);
        // Storage::disk("public")->delete($item->products->pluck("product_photo")->toArray());
        // Storage::disk("public")->delete($item->item_photo);
        FileService::deleteFiles($item->products->pluck("product_photo")->toArray());
        FileService::deleteFile($item->item_photo);
        $item->delete();


        return $item;
    }

    public static function destroyAll()
    {

        DB::table("items")->delete();
        // Storage::disk("public")->deleteDirectory("products");
        // Storage::disk("public")->deleteDirectory("items");
        FileService::cleanDirectory("products");
        FileService::cleanDirectory("items");
        return true;
    }
}

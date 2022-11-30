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

        if ($request->hasFile("photo")) {
            // $photo = $request->file("photo")->store("items", "public");
            $photo =  FileService::uploadFile($request->file("photo"), "items");
            $data["photo"] = $photo;
        }
        $item =  Item::create($data);

        if (isset($data["photo"]))
            $item["live_photo_path"] = asset("storage/" . $data["photo"]);



        return $item;
    }


    public static function show($id)
    {
        $item = Item::with(["products" => function ($q) {
            $q->paginate(5);
        }])->findOrFail($id);

        if (isset($item->photo))
            $item["live_photo_path"] = asset("storage/" . $item->photo);
        return $item;
    }


    public static function update($request, $id)
    {
        $data = $request->all();
        $item = Item::findOrFail($id);


        $data["photo"] = $item->photo;
        if ($request->hasFile("photo")) {
            // Storage::disk("public")->delete($item->photo);
            // $photo = $request->file("photo")->store("items", "public");
            FileService::deleteFile($item->photo);
            $photo =  FileService::uploadFile($request->file("photo"), "items");
            $data["photo"] = $photo;
        }
        $item->update($data);
        $item["live_photo_path"] = asset("storage/" . $data["photo"]);



        return $item;
    }

    public static function destroy($id)
    {
        $item = Item::findOrFail($id);
        if (isset($item->photo))
            $item["live_photo_path"] = asset("storage/" . $item->photo);
        // Storage::disk("public")->delete($item->products->pluck("photo")->toArray());
        // Storage::disk("public")->delete($item->photo);
        FileService::deleteFiles($item->products->pluck("photo")->toArray());
        FileService::deleteFile($item->photo);
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

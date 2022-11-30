<?php

namespace App\Services;

use App\Models\Product;
use DB;
use Storage;

/**
 * Class ProductService.
 */
class ProductService
{

    public static function getAllProducts()
    {


        $products = Product::with("item")->paginate(5);
        return $products;
    }

    public static function table($pageNumber)
    {
        $products = Product::with("item")->paginate(5, ['*'], 'page', $pageNumber)->withPath(route("products.index"));
        return $products;
    }




    public static function store($request)
    {


        $data = $request->all();


        $productDiscount = 0;
        if (trim($request->discount) != "")
            $productDiscount = trim($request->discount);

        $photo = null;
        if ($request->hasFile("photo")) {
            // $photo = $request->file("photo")->store("products", "public");
            $photo =  FileService::uploadFile($request->file("photo"), "products");
        }


        $data["photo"] = $photo;
        $data["discount"] = $productDiscount;
        $product = Product::create($data);

        if (isset($photo))
            $product["live_photo_path"] = asset("storage/$photo");



        return $product;
    }



    public static function show($id)
    {

        $product = Product::with("item")->findOrFail($id);
        if (isset($product->photo))
            $product["live_photo_path"] = asset("storage/$product->photo");
        return $product;
    }


    public static function update($request, $id)
    {


        $data = $request->all();

        $product = Product::with("item")->findOrFail($id);



        $productDiscount = 0;
        if (trim($request->discount) != "")
            $productDiscount = trim($request->discount);

        $photo = $product->photo;
        if ($request->hasFile("photo")) {
            // Storage::disk("public")->delete($product->photo);
            // $photo = $request->file("photo")->store("products", "public");
            FileService::deleteFile($product->photo);
            $photo =  FileService::uploadFile($request->file("photo"), "products");
        }


        $data["photo"] = $photo;
        $data["discount"] = $productDiscount;

        $product->update($data);
        $product["live_photo_path"] = asset("storage/$photo");



        return $product;
    }


    public static function destroy($id)
    {
        $product = Product::with("item")->findOrFail($id);
        if (isset($product->photo))
            $product["live_photo_path"] = asset("storage/$product->photo");
        $product->delete();


        //Delete Old Photo
        // Storage::disk("public")->delete($product->photo);
        FileService::deleteFile($product->photo);

        return $product;
    }
    public static function destroyAll()
    {

        DB::table("products")->delete();

        //Delete All Photos
        // Storage::disk("public")->deleteDirectory("products");
        FileService::cleanDirectory("products");

        return true;
    }
}

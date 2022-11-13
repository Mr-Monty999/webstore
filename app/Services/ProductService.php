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
        if (trim($request->product_discount) != "")
            $productDiscount = trim($request->product_discount);

        $photo = null;
        if ($request->hasFile("product_photo"))
            $photo = $request->file("product_photo")->store("products", "public");



        $data["product_photo"] = $photo;
        $data["product_discount"] = $productDiscount;
        $product = Product::create($data);


        return $product;
    }



    public static function show($id)
    {

        $product = Product::with("item")->findOrFail($id);
        return $product;
    }


    public static function update($request, $id)
    {


        $data = $request->all();

        $product = Product::with("item")->findOrFail($id);



        $productDiscount = 0;
        if (trim($request->product_discount) != "")
            $productDiscount = trim($request->product_discount);

        $photo = $product->product_photo;
        if ($request->hasFile("product_photo")) {
            Storage::disk("public")->delete($product->product_photo);
            $photo = $request->file("product_photo")->store("products", "public");
        }


        $data["product_photo"] = $photo;
        $data["product_discount"] = $productDiscount;

        $product->update($data);
        $product["photo_path"] = asset("storage/$photo");



        return $product;
    }


    public static function destroy($id)
    {
        $product = Product::with("item")->findOrFail($id);
        $data["product"] = $product;
        $product->delete();

        //Delete Old Photo
        Storage::disk("public")->delete($product->product_photo);


        return true;
    }
    public static function destroyAll()
    {

        DB::table("products")->delete();

        //Delete All Photos
        Storage::disk("public")->deleteDirectory("products");

        return true;
    }
}

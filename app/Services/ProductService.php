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


        $products = Product::with("item")->paginate(5)->onEachSide(0);
        return $products;
    }

    public static function table($pageNumber)
    {
        $products = Product::with("item")->paginate(5, ['*'], 'page', $pageNumber)->withPath(route("products.index"))->onEachSide(0);
        return $products;
    }




    public static function store($request)
    {


        $data = $request->all();

        $product = Product::where("product_name", $request->product_name);

        if ($product->exists()) {
            $data["success"] = false;
            $data["message"] = "هذا المنتج موجود بالفعل !";
            return $data;
        }

        // $path = null;
        // if (file_exists(public_path()))
        //     $path = public_path();
        // else
        //     $path = base_path();


        $productDiscount = 0;
        if (trim($request->product_discount) != "")
            $productDiscount = trim($request->product_discount);

        $photo = null;
        if ($request->hasFile("product_photo"))
            $photo = $request->file("product_photo")->store("products", "public");


        $data["product_photo"] = $photo;
        $data["product_discount"] = $productDiscount;

        Product::create($data);
        $data["success"] = true;
        $data["message"] = "تم الاضافة بنجاح";
        return $data;
    }



    public static function show($id)
    {

        $product = Product::findOrFail($id);
        return $product;
    }


    public static function update($request, $id)
    {


        $data = $request->all();

        $product = Product::find($id);
        $oldProduct = Product::where("product_name", $request->product_name);

        if ($oldProduct->exists() && $oldProduct->first()->product_name != $product->product_name) {
            $data["success"] = false;
            $data["message"] = "هذا المنتج موجود بالفعل";

            return $data;
        }


        $productDiscount = 0;
        if (trim($request->product_discount) != "")
            $productDiscount = trim($request->product_discount);

        $photo = $oldProduct->first()->product_photo;
        if ($request->hasFile("product_photo")) {
            Storage::disk("public")->delete($oldProduct->first()->product_photo);
            $photo = $request->file("product_photo")->store("products", "public");
        }


        $data["product_photo"] = $photo;
        $data["product_discount"] = $productDiscount;

        $product->update($data);

        $data["success"] = true;
        $data["message"] = "تم تعديل المنتج بنجاح";
        $data["photo_path"] = asset("storage/$photo");

        return $data;
    }


    public static function destroy($id)
    {
        $product = Product::find($id);
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

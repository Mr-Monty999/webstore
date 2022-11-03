<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Item;
use App\Models\Product;
use App\Services\DeleteService;
use App\Services\ItemService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = ProductService::getAllProducts();
        $items = ItemService::getAllItems();
        return view("dashboard.products.index", ["products" => $products, "items" => $items]);
    }

    public function table($pageNumber)
    {
        $products = ProductService::table($pageNumber);
        $items = ItemService::getAllItems();
        return view("dashboard.products.table", ["products" => $products, "items" => $items]);
    }




    public function store(ProductRequest $request)
    {




        $data = ProductService::store($request);
        return response()->json($data, 200);
    }



    public function edit($id)
    {

        $product = ProductService::show($id);
        $items = ItemService::getAllItems();

        return view("dashboard.products.edit", ["product" => $product, "items" => $items]);
    }


    public function update(ProductRequest $request, $id)
    {


        $data = ProductService::update($request, $id);

        return response()->json($data, 200);
    }


    public function destroy(Request $request, $id)
    {
        $product = Product::find($request->id);
        $data["product"] = $product;
        $product->delete();

        //Delete Old Photo
        DeleteService::deleteFile($product->product_photo);

        $data["success"] = true;
        $data["message"] = "تم الحذف بنجاح";

        return response()->json($data, 200);
    }
    public function destroyAll()
    {

        DB::table("products")->delete();

        //Delete All Photos
        DeleteService::deleteAllFiles("/images/products");

        $data["success"] = true;
        $data["message"] = "تم حذف جميع المنتجات بنجاح";
        return response()->json($data);
    }
}

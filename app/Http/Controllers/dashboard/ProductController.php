<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
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

    public function __construct()
    {

        $this->middleware("permission:view-products")->only(["index", "show", "table"]);
        $this->middleware("permission:create-products")->only(["create", "store"]);
        $this->middleware("permission:edit-products")->only(["edit", "update"]);
        $this->middleware("permission:delete-products")->only("destroy", "destroyAll");
    }
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




    public function store(StoreProductRequest $request)
    {




        $data = ProductService::store($request);
        $data["success"] = true;
        $data["message"] = "تم الاضافة بنجاح";
        return response()->json($data, 201);
    }



    public function edit($id)
    {

        $product = ProductService::show($id);
        $items = ItemService::getAllItems();

        return view("dashboard.products.edit", ["product" => $product, "items" => $items]);
    }


    public function update(UpdateProductRequest $request, $id)
    {


        $data = ProductService::update($request, $id);
        $data["success"] = true;
        $data["message"] = "تم تعديل المنتج بنجاح";
        return response()->json($data);
    }


    public function destroy(Request $request, $id)
    {
        $product = ProductService::destroy($request->id);
        $data["product"] = $product;


        $data["success"] = true;
        $data["message"] = "تم الحذف بنجاح";

        return response()->json($data);
    }
    public function destroyAll()
    {

        ProductService::destroyAll();

        $data["success"] = true;
        $data["message"] = "تم حذف جميع المنتجات بنجاح";
        return response()->json($data);
    }
}

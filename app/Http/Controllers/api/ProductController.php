<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

/**
 * @group products
 * @authenticated
 */
class ProductController extends Controller
{

    public function __construct()
    {

        $this->middleware("permission:view-products")->only(["index", "show", "table"]);
        $this->middleware("permission:create-products")->only(["create", "store"]);
        $this->middleware("permission:edit-products")->only(["edit", "update"]);
        $this->middleware("permission:delete-products")->only("destroy", "destroyAll");
    }
    /**
     * Display all the products (paginated) with their item .
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = ProductService::getAllProducts();
        return response()->json($products);
    }

    /**
     * Store a newly created product in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {

        $data = ProductService::store($request);
        return response()->json($data, 201);
    }

    /**
     * Display the specified product with it item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = ProductService::show($id);
        return response()->json($product);
    }

    /**
     * Update the specified product in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = ProductService::update($request, $id);
        return response()->json($product);
    }

    /**
     * Remove the specified product from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = ProductService::destroy($id);
        return response()->json($product);
    }

    /**
     * Remove all the products from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {
        $product = ProductService::destroyAll();
        return response()->json($product);
    }
}

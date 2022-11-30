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
     *@response 200 {
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "دجاج",
            "price": 300,
            "discount": 10,
            "photo": null,
            "item_id": 1,
            "created_at": "2022-11-14T18:56:02.000000Z",
            "updated_at": "2022-11-14T18:56:02.000000Z",
            "item": {
                "id": 1,
                "name": "d",
                "photo": null,
                "created_at": "2022-11-14T18:55:53.000000Z",
                "updated_at": "2022-11-14T18:55:53.000000Z"
            }
        },
        {
            "id": 2,
            "name": "شاورما",
            "price": 300,
            "discount": 10,
            "photo": null,
            "item_id": 1,
            "created_at": "2022-11-14T18:56:07.000000Z",
            "updated_at": "2022-11-14T18:56:07.000000Z",
            "item": {
                "id": 1,
                "name": "d",
                "photo": null,
                "created_at": "2022-11-14T18:55:53.000000Z",
                "updated_at": "2022-11-14T18:55:53.000000Z"
            }
        }
    ],
    "first_page_url": "http://localhost:8000/api/products?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://localhost:8000/api/products?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http://localhost:8000/api/products?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http://localhost:8000/api/products",
    "per_page": 5,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = ProductService::getAllProducts();
        return response()->json($products);
    }

    /**
     * Store a newly created product in database.
     *@response 201 {
    "name": "سمك",
    "price": "2399",
    "item_id": "1",
    "photo": "products/w4wDcFUGwu6ra7Z03fcgBMd4C7gIh8ixJ1RZMnE0.jpg",
    "discount": 0,
    "updated_at": "2022-11-15T10:55:09.000000Z",
    "created_at": "2022-11-15T10:55:09.000000Z",
    "id": 4,
    "live_photo_path": "http://localhost:8000/storage/products/w4wDcFUGwu6ra7Z03fcgBMd4C7gIh8ixJ1RZMnE0.jpg"
}
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
     *@response{
    "id": 4,
    "name": "سمك",
    "price": 2399,
    "discount": 0,
    "photo": "products/w4wDcFUGwu6ra7Z03fcgBMd4C7gIh8ixJ1RZMnE0.jpg",
    "item_id": 1,
    "created_at": "2022-11-15T10:55:09.000000Z",
    "updated_at": "2022-11-15T10:55:09.000000Z",
    "live_photo_path": "http://localhost:8000/storage/products/w4wDcFUGwu6ra7Z03fcgBMd4C7gIh8ixJ1RZMnE0.jpg",
    "item": {
        "id": 1,
        "name": "d",
        "photo": null,
        "created_at": "2022-11-14T18:55:53.000000Z",
        "updated_at": "2022-11-14T18:55:53.000000Z"
    }
}
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
     *@response {
    "id": 4,
    "name": "سمك",
    "price": 2399,
    "discount": 0,
    "photo": "products/w4wDcFUGwu6ra7Z03fcgBMd4C7gIh8ixJ1RZMnE0.jpg",
    "item_id": 1,
    "created_at": "2022-11-15T10:55:09.000000Z",
    "updated_at": "2022-11-15T10:55:09.000000Z",
    "live_photo_path": "http://localhost:8000/storage/products/w4wDcFUGwu6ra7Z03fcgBMd4C7gIh8ixJ1RZMnE0.jpg",
    "item": {
        "id": 1,
        "name": "d",
        "photo": null,
        "created_at": "2022-11-14T18:55:53.000000Z",
        "updated_at": "2022-11-14T18:55:53.000000Z"
    }
}
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
     *@response {
    "id": 4,
    "name": "سمك",
    "price": 2399,
    "discount": 0,
    "photo": "products/w4wDcFUGwu6ra7Z03fcgBMd4C7gIh8ixJ1RZMnE0.jpg",
    "item_id": 1,
    "created_at": "2022-11-15T10:55:09.000000Z",
    "updated_at": "2022-11-15T10:55:09.000000Z",
    "live_photo_path": "http://localhost:8000/storage/products/w4wDcFUGwu6ra7Z03fcgBMd4C7gIh8ixJ1RZMnE0.jpg",
    "item": {
        "id": 1,
        "name": "d",
        "photo": null,
        "created_at": "2022-11-14T18:55:53.000000Z",
        "updated_at": "2022-11-14T18:55:53.000000Z"
    }
}
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
     *@response 200
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAll()
    {
        $product = ProductService::destroyAll();
        return response()->json($product);
    }
}

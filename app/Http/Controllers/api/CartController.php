<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\StoreProductCartRequest;
use App\Http\Requests\UpdateProductCartRequest;
use App\Services\CartService;
use Cookie;
use Illuminate\Http\Request;

/**
 * @group carts
 * @unauthenticated
 */
class CartController extends Controller
{
    /**
     * Get Cart Products
     * @urlParam cart_id string required The ID of the cart.
     * @response 200 [
     *  {
     *"id": 1,
     *"name": "دجاج",
     *"price": 300,
     *"discount": 10,
     *"photo": null,
     *"item_id": 1,
     *"created_at": "2022-11-14T18:56:02.000000Z",
     *"updated_at": "2022-11-14T18:56:02.000000Z",
     *  "pivot": {
     *      "cart_id": "cart_63735a019396e",
     *      "product_id": 1,
     *      "product_amount": 1
     *   }
     *}
     *]
     * @return
     */

    public function index($cartId)
    {
        $products = CartService::showCartProducts($cartId);
        return response()->json($products);
    }

    /**
     * Inital New Cart
     *@response 201{
     *"id": "cart_6373591c94f01",
     *"updated_at": "2022-11-15T09:17:16.000000Z",
     *"created_at": "2022-11-15T09:17:16.000000Z"
     *}
     * @param  \Illuminate\Http\Request  $request
     */
    public function intialCart(Request $request)
    {

        $cart = CartService::intialCart();
        return response()->json($cart, 201);
    }

    /**
     * Store Products in Cart
     *@urlParam cart string required The ID of the cart.
     *@response 201 {
    "id": 1,
    "name": "دجاج",
    "price": 300,
    "discount": 10,
    "photo": null,
    "item_id": 1,
    "created_at": "2022-11-14T18:56:02.000000Z",
    "updated_at": "2022-11-14T18:56:02.000000Z",
    "pivot": {
        "cart_id": "cart_63728e5ab48c9",
        "product_id": 1,
        "product_amount": 1
    }
}
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreProductCartRequest $request, $cartId)
    {
        $cart =  CartService::storeProduct($request->product_id, $cartId);

        return response()->json($cart, 201);
    }

    /**
     * Show specified Product in Cart
     *@urlParam cart_id string required The ID of the cart.
     * @response {
    "id": 1,
    "name": "دجاج",
    "price": 300,
    "discount": 10,
    "photo": null,
    "item_id": 1,
    "created_at": "2022-11-14T18:56:02.000000Z",
    "updated_at": "2022-11-14T18:56:02.000000Z",
    "pivot": {
        "cart_id": "cart_63735a019396e",
        "product_id": 1,
        "product_amount": 1
    }
}

     * @param  int  $id
     */
    public function show($cartId, $productId)
    {
        $cart =  CartService::show($cartId, $productId);

        return response()->json($cart);
    }

    /**
     * Update specified product in the cart
     *@urlParam cart_id string required The ID of the cart.
     @response {
    "id": 1,
    "name": "دجاج",
    "price": 300,
    "discount": 10,
    "photo": null,
    "item_id": 1,
    "created_at": "2022-11-14T18:56:02.000000Z",
    "updated_at": "2022-11-14T18:56:02.000000Z",
    "pivot": {
        "cart_id": "cart_63728e5ab48c9",
        "product_id": 1,
        "product_amount": 309
    }
}
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(UpdateProductCartRequest $request, $cartId, $productId)
    {
        $cart =  CartService::update($cartId, $productId, $request->all());

        return response()->json($cart);
    }

    /**
     * Remove the specified product from cart
     *@urlParam cart_id string required The ID of the cart.
     * @response {
    "id": 1,
    "name": "دجاج",
    "price": 300,
    "discount": 10,
    "photo": null,
    "item_id": 1,
    "created_at": "2022-11-14T18:56:02.000000Z",
    "updated_at": "2022-11-14T18:56:02.000000Z",
    "pivot": {
        "cart_id": "cart_63728e5ab48c9",
        "product_id": 1,
        "product_amount": 1
    }
}
     * @param  int  $id
     */
    public function destroy($cartId, $productId)
    {
        $cart =  CartService::destroy($cartId, $productId);

        return response()->json($cart);
    }
    /**
     * Remove All Products From Cart
     *@urlParam cart string required The ID of the cart.
     *@response 200 1
     * @param  int  $id
     */
    public function destroyAll($cartId)
    {
        $cart =  CartService::destroyAll($cartId);

        return response()->json($cart);
    }
}

<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCartRequest;
use App\Http\Requests\UpdateProductCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = CartService::showCartProducts(Cookie::get("cart_id"));
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function intialCart(Request $request)
    {

        $cart = CartService::intialCart();
        return response()->json($cart, 201);
    }
    public function store(StoreProductCartRequest $request)
    {

        $cart =  CartService::storeProduct($request->product_id, Cookie::get("cart_id"));

        return response()->json($cart, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cartId, $productId)
    {
        $cart =  CartService::show($cartId, $productId);

        return response()->json($cart);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductCartRequest $request, $productId)
    {
        $cart =  CartService::update(Cookie::get("cart_id"), $productId, $request->all());

        return response()->json($cart);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $productId)
    {
        $cart =  CartService::destroy(Cookie::get("cart_id"), $request->product_id);

        return response()->json($cart);
    }
    public function destroyAll()
    {
        $cart =  CartService::destroyAll(Cookie::get("cart_id"));

        return response()->json($cart);
    }
}

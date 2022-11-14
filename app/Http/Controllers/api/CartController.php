<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\StoreProductCartRequest;
use App\Http\Requests\UpdateProductCartRequest;
use App\Services\CartService;
use Cookie;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cartUid)
    {
        $products = CartService::showCartProducts($cartUid);
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
    public function store(StoreProductCartRequest $request, $cartUid)
    {

        $cart =  CartService::storeProduct($request->product_id, $cartUid);

        return response()->json($cart, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cartUid, $productId)
    {
        $cart =  CartService::show($cartUid, $productId);

        return response()->json($cart);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductCartRequest $request, $cartUid, $productId)
    {
        $cart =  CartService::update($cartUid, $productId, $request->all());

        return response()->json($cart);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cartUid, $productId)
    {
        $cart =  CartService::destroy($cartUid, $productId);

        return response()->json($cart);
    }
    public function destroyAll($cartUid)
    {
        $cart =  CartService::destroyAll($cartUid);

        return response()->json($cart);
    }
}

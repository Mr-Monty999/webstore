<?php

namespace App\Services;

use App\Models\Cart;
use Cookie;
use Request;
use Validator;

/**
 * Class CartService.
 */
class CartService
{



    public static function storeProduct($productId, $cartUid)
    {

        $cart = Cart::where("cart_uid", $cartUid)->firstOrFail()->products()->syncWithoutDetaching($productId);


        return $cart;
    }
    public static function intialCart()
    {

        $uid = uniqid("cart_");

        $cart = Cart::firstOrCreate(["cart_uid" => $uid]);


        return $cart;
    }
    public static function intialCookieCart()
    {
        $uid = uniqid("cart_");

        if (!Cookie::has("cart_uid")) {
            Cookie::queue("cart_uid", $uid, 99999999, "/");


            Cart::create(["cart_uid" => $uid]);
        } else {
            $uid = Cookie::get("cart_uid");
            Cart::firstOrCreate(["cart_uid" => $uid]);
        }

        return $uid;
    }
    public static function showCartProducts($cartUid)
    {
        $products = Cart::where("cart_uid", $cartUid)->firstOrFail()->products()->get();
        return $products;
    }
    public static function show($cartUid, $productId)
    {
        $product = Cart::where("cart_uid", $cartUid)->firstOrFail()->products()->wherePivot("product_id", $productId)->firstOrFail();
        return $product;
    }
    public static function update($cartUid, $productId, $data)
    {

        $data =  Cart::where("cart_uid", $cartUid)->firstOrFail()->products()->syncWithoutDetaching([$productId => ["product_amount" => $data["product_amount"]]]);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function destroy($uid, $productId)
    {
        $data = Cart::where("cart_uid", $uid)->firstOrFail()->products()->detach($productId);


        return $data;
    }
    public static function destroyAll($uid)
    {
        $data = Cart::where("cart_uid", $uid)->firstOrFail()->products()->detach();

        return  $data;
    }
}

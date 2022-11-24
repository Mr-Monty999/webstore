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



    public static function storeProduct($productId, $cartId)
    {
        Cart::findOrFail($cartId)->products()->syncWithoutDetaching($productId);

        $data =   self::show($cartId, $productId);
        return $data;
    }
    public static function intialCart()
    {

        $cartId = uniqid("cart_");

        $cart = Cart::firstOrCreate(["id" => $cartId]);


        return $cart;
    }
    public static function intialCookieCart()
    {
        $cartId = uniqid("cart_");

        if (!Cookie::has("cart_id")) {
            Cookie::queue("cart_id", $cartId, 99999999, "/");


            Cart::create(["id" => $cartId]);
        } else {
            $cartId = Cookie::get("cart_id");
            Cart::firstOrCreate(["id" => $cartId]);
        }

        return $cartId;
    }
    public static function showCartProducts($cartId)
    {
        $products = Cart::findOrFail($cartId)->products()->get();
        return $products;
    }
    public static function show($cartId, $productId)
    {
        $product = Cart::findOrFail($cartId)->products()->wherePivot("product_id", $productId)->firstOrFail();
        return $product;
    }
    public static function update($cartId, $productId, $data)
    {
        if (!isset($data["product_amount"]))
            $data["product_amount"] = 1;

        Cart::findOrFail($cartId)->products()->syncWithoutDetaching([$productId => ["product_amount" => $data["product_amount"]]]);

        $data =   self::show($cartId, $productId);

        return $data;
    }


    public static function destroy($cartId, $productId)
    {
        $data =   self::show($cartId, $productId);
        Cart::findOrFail($cartId)->products()->detach($productId);
        return $data;
    }
    public static function destroyAll($cartId)
    {
        $data = Cart::findOrFail($cartId)->products()->detach();

        return  true;
    }
}

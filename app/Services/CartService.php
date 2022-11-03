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



    public static function store($data)
    {
        $uid = Cookie::get("cart_uid");

        Cart::where("cart_uid", $uid)->first()->products()->syncWithoutDetaching($data["product_id"]);


        return $uid;
    }


    public static function update($request, $id)
    {
        Validator::validate($request->all(), [
            'product_amount' => 'numeric'
        ]);


        $uid = Cookie::get("cart_uid");
        Cart::where("cart_uid", $uid)->first()->products()->syncWithoutDetaching([$request->product_id => ["product_amount" => $request->product_amount]]);

        return $uid;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function destroy($data, $id)
    {
        $uid = Cookie::get("cart_uid");
        Cart::where("cart_uid", $uid)->first()->products()->detach($data["product_id"]);


        return $uid;
    }
    public static function destroyAll(Request $request)
    {

        $uid = Cookie::get("cart_uid");
        Cart::where("cart_uid", $uid)->first()->products()->detach();


        return  true;
    }
}

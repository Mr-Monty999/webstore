<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;

trait GetService
{

    public static function getCartProducts($cartId)
    {

        return Cart::findOrFail($cartId)->products;
    }
}

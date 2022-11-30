<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $guarded = ["id"];


    public function item()
    {
        return $this->belongsTo(Item::class, "item_id");
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class, "cart_product")->withPivot("product_amount");
    }
}

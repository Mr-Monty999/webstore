<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class Cart extends Model
{
    use HasFactory;

    protected $table = "carts";
    protected $fillable = ["cart_uid"];

    public function products()
    {
        return $this->belongsToMany(Product::class, "cart_product");
    }
}

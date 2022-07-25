<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = "items";

    protected $fillable = ["item_name", "item_photo"];


    public function products()
    {
        return $this->hasMany(Product::class, "item_id");
    }
}

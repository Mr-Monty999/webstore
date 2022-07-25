<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vistor extends Model
{
    use HasFactory;

    protected $table = "vistors";

    protected $fillable = ["ip", "hits", "user_agent"];
}

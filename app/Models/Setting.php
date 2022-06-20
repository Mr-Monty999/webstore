<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = "settings";

    protected $fillable = ["store_name", "store_logo", "home_title", "contact_phone1", "contact_phone2", "contact_address", "whatsapp_phone"];
}

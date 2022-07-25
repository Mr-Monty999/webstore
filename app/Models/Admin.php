<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends User
{
    use HasFactory;
    protected $table = "admins";

    protected $fillable = ["admin_name", "password", "admin_photo", "admin_rank", "admin_status"];
}

<?php

namespace App\Http\Controllers\general;


use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Vistor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function index()
    {




        if (Setting::count() < 1)
            Setting::create([]);

        $setting = Setting::first();
        return view("general.home", ["setting" => $setting]);
    }
}

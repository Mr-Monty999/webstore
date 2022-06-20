<?php

namespace App\Http\Controllers\general;


use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {

        if (Setting::count() < 1)
            Setting::create([]);

        $setting = Setting::first();

        return view("general.contact", ["setting" => $setting]);
    }
}

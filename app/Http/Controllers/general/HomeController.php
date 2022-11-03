<?php

namespace App\Http\Controllers\general;


use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Vistor;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function index()
    {



        SettingService::createSettingsIfNotExists();

        $setting = Setting::first();
        return view("general.home", ["setting" => $setting]);
    }
}

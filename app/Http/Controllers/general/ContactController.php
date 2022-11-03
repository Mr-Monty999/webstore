<?php

namespace App\Http\Controllers\general;


use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {

        SettingService::createSettingsIfNotExists();

        $setting = Setting::first();

        return view("general.contact", ["setting" => $setting]);
    }
}

<?php

namespace App\Http\Controllers\dashboard;


use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Services\DeleteService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {

        SettingService::createSettingsIfNotExists();

        $setting = Setting::first();
        return view("dashboard.settings.index", ["setting" => $setting]);
    }






    public function update(SettingRequest $request)
    {

        $data = SettingService::update($request);

        return response()->json($data, 200);
    }
}

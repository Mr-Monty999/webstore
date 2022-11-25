<?php

namespace App\Http\Controllers\dashboard;


use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Http\Requests\StoreSettingRequest;
use App\Models\Setting;
use App\Services\DeleteService;
use App\Services\SettingService;
use DB;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware("permission:create-settings")->only(["store", "create"]);
        $this->middleware("permission:view-settings")->only(["index", "show", "table"]);
        $this->middleware("permission:edit-settings")->only(["edit", "update"]);
        $this->middleware("permission:delete-settings")->only(["destroy", "destroyAll"]);
    }

    public function index()
    {
        $setting = Setting::latest()->firstOrNew();
        return view("dashboard.settings.index", ["setting" => $setting]);
    }

    public static function destroyAll()
    {
        $settings = SettingService::destroyAll();
        return response()->json($settings);
    }



    public function store(StoreSettingRequest $request)
    {

        $data = SettingService::store($request);
        $data["success"] = true;
        $data["message"] = "تم الحفظ بنجاح";

        return response()->json($data, 200);
    }
}

<?php

namespace App\Services;

use App\Models\Setting;
use Storage;

/**
 * Class SettingService.
 */
class SettingService
{




    public static function store($request)
    {

        $data = $request->all();

        if ($request->hasFile("store_logo")) {
            $photo = $request->file("store_logo")->store("settings", "public");
            $data["store_logo"] = $photo;
        }
        $setting = Setting::create($data);

        if (isset($data["store_logo"]))
            $setting["photo_path"] = asset("storage/" . $data["store_logo"]);

        return $setting;
    }
    public static function show($id)
    {
        $setting = Setting::findOrFail($id);
        return $setting;
    }
    public static function update($request, $id)
    {
        $setting = Setting::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile("store_logo")) {
            $photo = $request->file("store_logo")->store("settings", "public");
            $data["store_logo"] = $photo;
        }
        $setting->update($data);

        if (isset($data["store_logo"]))
            $setting["photo_path"] = asset("storage/" . $data["store_logo"]);

        return $setting;
    }
    public static function getAllSettings()
    {
        $settings = Setting::paginate(5);
        return $settings;
    }
    public static function getLastSetting()
    {
        $setting = Setting::latest()->firstOrNew();
        return $setting;
    }
    public static function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        Storage::disk("public")->delete($setting->store_logo);
        $setting->delete();

        return $setting;
    }
    public static function destroyAll()
    {
        $settings = Setting::whereNotNull("id");
        Storage::disk("public")->delete($settings->pluck("store_logo")->toArray());
        $settings->delete();
        return true;
    }
}

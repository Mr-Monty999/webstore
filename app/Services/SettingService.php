<?php

namespace App\Services;

use App\Models\Setting;
use Storage;

/**
 * Class SettingService.
 */
class SettingService
{


    public static function createSettingsIfNotExists()
    {

        if (Setting::count() < 1)
            Setting::create();
    }






    public static function update($request)
    {

        $data = $request->all();

        $setting = Setting::first();




        $photo = $setting->store_logo;
        if ($request->hasFile("store_logo")) {
            Storage::disk("public")->delete($setting->store_logo);
            $photo = $request->file("store_logo")->store("settings", "public");
        }
        $data["store_logo"] = $photo;
        $setting->update($data);

        $data["success"] = true;
        $data["message"] = "تم الحفظ بنجاح";
        $data["photo_path"] = asset("storage/$photo");

        return $data;
    }
}

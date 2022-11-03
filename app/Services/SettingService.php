<?php

namespace App\Services;

use App\Models\Setting;

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

        $path = null;
        if (file_exists(public_path()))
            $path = public_path();
        else
            $path = base_path();



        $photo = null;
        $photoName = $setting->store_logo;
        if ($request->hasFile("store_logo")) {
            $photo = $request->file("store_logo");
            $photoName = time() . "." . $photo->getClientOriginalExtension();

            // Delete Old Photo
            DeleteService::deleteFile($setting->store_logo);

            $photo->move($path . "/images/settings", "$photoName");
            $photoName = "/images/settings/" . $photoName;
        }
        $data["store_logo"] = $photoName;

        $setting->update($data);

        $data["success"] = true;
        $data["message"] = "تم الحفظ بنجاح";
        $data["photo_path"] = asset($photoName);

        return $data;
    }
}

<?php

namespace App\Http\Controllers\dashboard;


use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use App\Services\DeleteService;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {

        if (Setting::count() < 1)
            Setting::create();


        $setting = Setting::first();
        return view("dashboard.settings.index", ["setting" => $setting]);
    }






    public function update(SettingRequest $request)
    {

        $request->validated();
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

        return response()->json($data, 200);
    }
}

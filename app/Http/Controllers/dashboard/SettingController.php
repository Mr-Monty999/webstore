<?php

namespace App\Http\Controllers\dashboard;


use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
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

            if (file_exists($path . $setting->store_logo) && is_file($path . $setting->store_logo))
                unlink($path . $setting->store_logo);

            $photo->move($path . "/images/settings", "$photoName");
            $photoName = "/images/settings/" . $photoName;
        }
        $data = $request->all();
        $data["store_logo"] = $photoName;

        $setting->update($data);

        return redirect()->back()->with("success", "تم الحفظ بنجاح ");
    }
}

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

        $setting->update([
            "store_name" => trim($request->store_name),
            "home_title" => trim($request->home_title),
            "whatsapp_phone" => trim($request->whatsapp_phone),
            "contact_phone1" => trim($request->contact_phone1),
            "contact_phone2" => trim($request->contact_phone2),
            "contact_address" => trim($request->contact_address),
            "store_logo" => $photoName
        ]);

        return redirect()->back()->with("success", "تم الحفظ بنجاح ");
    }
}

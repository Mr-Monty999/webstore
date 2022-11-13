<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Feedback;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {


        $this->middleware("permission:view-settings")->only(["index", "show", "table"]);
        $this->middleware("permission:create-settings")->only(["create", "store"]);
        $this->middleware("permission:edit-settings")->only(["edit", "update"]);
        $this->middleware("permission:delete-settings")->only(["destroy", "destroyAll"]);
    }
    public function index()
    {

        $settings = SettingService::getAllSettings();
        return response()->json($settings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSettingRequest $request)
    {

        $data = SettingService::store($request);

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $setting = SettingService::show($id);
        return response()->json($setting);
    }
    public function showLastSetting()
    {
        $setting = SettingService::getLastSetting();
        return response()->json($setting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingRequest $request, $id)
    {
        $setting = SettingService::update($request, $id);
        return response()->json($setting);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $setting = SettingService::destroy($id);
        return response()->json($setting);
    }
    public static function destroyAll()
    {

        $settings = SettingService::destroyAll();
        return response()->json($settings);
    }
}

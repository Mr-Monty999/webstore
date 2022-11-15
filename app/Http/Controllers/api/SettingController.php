<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Feedback;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;

/**
 * @group settings
 * @authenticated
 */
class SettingController extends Controller
{

    public function __construct()
    {


        $this->middleware("permission:view-settings")->only(["index", "show", "table"]);
        $this->middleware("permission:create-settings")->only(["create", "store"]);
        $this->middleware("permission:edit-settings")->only(["edit", "update"]);
        $this->middleware("permission:delete-settings")->only(["destroy", "destroyAll"]);
    }

    /**
     * Display all settings of the site.
     *@response {
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "store_name": "monty",
            "store_logo": null,
            "store_currency": null,
            "home_title": null,
            "whatsapp_phone": null,
            "contact_phone1": null,
            "contact_phone2": null,
            "contact_address": null,
            "created_at": "2022-11-15T11:34:29.000000Z",
            "updated_at": "2022-11-15T11:34:29.000000Z"
        },
        {
            "id": 2,
            "store_name": "ahmed",
            "store_logo": "settings/PL0BDCObJlCEHvLcGKFnAUMQmf6BzaA7AKvn74iz.jpg",
            "store_currency": null,
            "home_title": null,
            "whatsapp_phone": null,
            "contact_phone1": null,
            "contact_phone2": null,
            "contact_address": null,
            "created_at": "2022-11-15T11:35:30.000000Z",
            "updated_at": "2022-11-15T11:35:30.000000Z"
        }
    ],
    "first_page_url": "http://localhost:8000/api/settings?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://localhost:8000/api/settings?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http://localhost:8000/api/settings?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": null,
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": null,
    "path": "http://localhost:8000/api/settings",
    "per_page": 5,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $settings = SettingService::getAllSettings();
        return response()->json($settings);
    }

    /**
     * Store a newly created setting in database.
     *@response 201 {
    "id": 2,
    "store_name": "ahmed",
    "store_logo": "settings/PL0BDCObJlCEHvLcGKFnAUMQmf6BzaA7AKvn74iz.jpg",
    "store_currency": null,
    "home_title": null,
    "whatsapp_phone": null,
    "contact_phone1": null,
    "contact_phone2": null,
    "contact_address": null,
    "created_at": "2022-11-15T11:35:30.000000Z",
    "updated_at": "2022-11-15T11:35:30.000000Z"
}
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSettingRequest $request)
    {

        $data = SettingService::store($request);

        return response()->json($data, 201);
    }

    /**
     * Display the specified setting.
     *@response {
    "id": 2,
    "store_name": "ahmed",
    "store_logo": "settings/PL0BDCObJlCEHvLcGKFnAUMQmf6BzaA7AKvn74iz.jpg",
    "store_currency": null,
    "home_title": null,
    "whatsapp_phone": null,
    "contact_phone1": null,
    "contact_phone2": null,
    "contact_address": null,
    "created_at": "2022-11-15T11:35:30.000000Z",
    "updated_at": "2022-11-15T11:35:30.000000Z"
}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $setting = SettingService::show($id);
        return response()->json($setting);
    }
    /**
     * Display the last created setting.
     *@response {
    "id": 2,
    "store_name": "ahmed",
    "store_logo": "settings/PL0BDCObJlCEHvLcGKFnAUMQmf6BzaA7AKvn74iz.jpg",
    "store_currency": null,
    "home_title": null,
    "whatsapp_phone": null,
    "contact_phone1": null,
    "contact_phone2": null,
    "contact_address": null,
    "created_at": "2022-11-15T11:35:30.000000Z",
    "updated_at": "2022-11-15T11:35:30.000000Z"
}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showLastSetting()
    {
        $setting = SettingService::getLastSetting();
        return response()->json($setting);
    }

    /**
     * Update the specified setting in database.
     *@response {
    "id": 2,
    "store_name": "ahmed",
    "store_logo": "settings/PL0BDCObJlCEHvLcGKFnAUMQmf6BzaA7AKvn74iz.jpg",
    "store_currency": null,
    "home_title": null,
    "whatsapp_phone": null,
    "contact_phone1": null,
    "contact_phone2": null,
    "contact_address": null,
    "created_at": "2022-11-15T11:35:30.000000Z",
    "updated_at": "2022-11-15T11:35:30.000000Z"
}
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
     * Remove the specified setting from database.
     *@response {
    "id": 2,
    "store_name": "ahmed",
    "store_logo": "settings/PL0BDCObJlCEHvLcGKFnAUMQmf6BzaA7AKvn74iz.jpg",
    "store_currency": null,
    "home_title": null,
    "whatsapp_phone": null,
    "contact_phone1": null,
    "contact_phone2": null,
    "contact_address": null,
    "created_at": "2022-11-15T11:35:30.000000Z",
    "updated_at": "2022-11-15T11:35:30.000000Z"
}
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $setting = SettingService::destroy($id);
        return response()->json($setting);
    }
    /**
     * Remove all the settings from database.
     *@response 200
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function destroyAll()
    {

        $settings = SettingService::destroyAll();
        return response()->json($settings);
    }
}

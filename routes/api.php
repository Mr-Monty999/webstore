<?php

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(["namespace" => "api"], function () {
    Route::post("users/login", "UserController@login");


    /// Cart Routes ///
    Route::post("carts/intial", "CartController@intialCart");
    Route::delete("carts/{cart}/products", "CartController@destroyAll");
    Route::apiResource("carts.products", "CartController", ["as" => "api"]);


    /// Feedback Routes ///
    Route::delete("feedbacks/delete-all", "FeedbackController@destroyAll");
    Route::apiResource("feedbacks", "FeedbackController", ["as" => "api"]);

    Route::group(
        ["middleware" => "auth:sanctum"],
        function () {

            /// Users Routes ///
            Route::delete("users/delete-all", "UserController@destroyAll");
            Route::put("users/{user}/privacy", "UserController@updatePrivacy");
            Route::apiResource("users", "UserController", ["as" => "api"]);


            /// Items Routes ///
            Route::delete("items/delete-all", "ItemController@destroyAll");
            Route::apiResource("items", "ItemController", ["as" => "api"]);


            //// Products Routes ///
            Route::delete("products/delete-all", "ProductController@destroyAll");
            Route::apiResource("products", "ProductController", ["as" => "api"]);

            /// Roles & Permissions Routes ///
            Route::delete("roles/delete-all", "RoleController@destroyAll");
            Route::get("permissions", "PermissionController@index");
            Route::apiResource("roles", "RoleController", ["as" => "api"]);


            /// Settings Routes ///
            Route::delete("settings/delete-all", "SettingController@destroyAll");
            Route::get("settings/last", "SettingController@showLastSetting");
            Route::apiResource("settings", "SettingController", ["as" => "api"]);
        }
    );
});

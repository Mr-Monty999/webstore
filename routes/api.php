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
            Route::delete("items/delete-all", "ItemController@destroyAll")->name("api.items.destroy.all");
            Route::apiResource("items", "ItemController", ["as" => "api"]);


            //// Products Routes ///
            Route::delete("products/delete-all", "ProductController@destroyAll")->name("api.products.destroy.all");
            Route::apiResource("products", "ProductController", ["as" => "api"]);

            /// Roles & Permissions Routes ///
            Route::delete("roles/delete-all", "RoleController@destroyAll")->name("api.roles.destroy.all");
            Route::get("permissions", "PermissionController@index");
            Route::apiResource("roles", "RoleController", ["as" => "api"]);


            /// Settings Routes ///
            Route::delete("settings/delete-all", "SettingController@destroyAll")->name("api.settings.destroy.all");
            Route::get("settings/last", "SettingController@showLastSetting")->name("api.settings.show.last");
            Route::apiResource("settings", "SettingController", ["as" => "api"]);
        }
    );
});

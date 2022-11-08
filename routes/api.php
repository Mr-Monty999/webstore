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
    Route::post("/login", "UserController@login");

    Route::group(["middleware" => "auth:sanctum"], function () {
        Route::apiResource("users", "UserController", ["as" => "api"]);
        Route::apiResource("items", "ItemController", ["as" => "api"]);
        Route::apiResource("products", "ProductController", ["as" => "api"]);
        Route::apiResource("roles", "RoleController", ["as" => "api"]);
        Route::apiResource("settings", "SettingController", ["as" => "api"]);
    });
});

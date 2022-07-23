<?php

use App\Models\Feedback;
use App\Models\Product;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




/// General Pages Routes
Route::group(["namespace" => "general"], function () {

    Route::get("/", "HomeController@index")->name("home");

    Route::group(["middleware" => "cart"], function () {
        Route::get("/contact", "ContactController@index")->name("contact");
        Route::get("/feedback", "FeedbackController@index")->name("feedback");
        Route::post("/feedback/store", "FeedbackController@store")->name("feedback.store");
        Route::get("/products/{id}", "ProductController@index")->name("products.view");
        Route::get("/search", "ProductController@search")->name("search");
    });

    ///Cart Routes
    Route::resource("carts", "CartController");
    // Route::post("/carts/store", "SettingController@index")->name("carts.index");
    // Route::delete("/carts/delete/", "SettingController@update")->name("carts.update");


});

///login  Panel Routes
Route::get("/lbc", "dashboard\AdminController@login")->name("dashboard.login")->middleware("admin");
Route::post("/lbc/login", "dashboard\AdminController@attemptLogin")->name("dashboard.attempt");


/// Dashboard  Routes
Route::group(["prefix" => "wbc", "middleware" => "admin", "namespace" => "dashboard"], function () {
    Route::get("/", "AdminController@dashboard")->name("dashboard.index");
    Route::get("/logout", "AdminController@logout")->name("dashboard.logout");


    ///Feedback Routes
    Route::get("/feedbacks", "FeedbackController@index")->name("dashboard.feedbacks.index");
    Route::get("/feedbacks/show/{id}", "FeedbackController@show")->name("dashboard.feedbacks.show");
    Route::delete("/feedbacks/delete/{id}", "FeedbackController@delete")->name("dashboard.feedbacks.delete");
    Route::delete("/feedbacks/all/delete", "FeedbackController@deleteAll")->name("dashboard.feedbacks.delete.all");

    ///Items Routes
    Route::get("/items", "ItemController@index")->name("items.index");
    Route::post("/items/store", "ItemController@store")->name("items.store");
    Route::get("/items/edit/{id}", "ItemController@edit")->name("items.edit");
    Route::put("/items/update/{id}", "ItemController@update")->name("items.update");
    Route::delete("/items/delete/{id}", "ItemController@destroy")->name("items.delete");
    Route::get("/items-table", "ItemController@table")->name("items.table");
    // Route::resource("items", "ItemController");


    ///Products Routes
    Route::get("/products", "ProductController@index")->name("products.index");
    Route::post("/products/store", "ProductController@store")->name("products.store");
    Route::get("/products/edit/{id}", "ProductController@edit")->name("products.edit");
    Route::put("/products/update/{id}", "ProductController@update")->name("products.update");
    Route::delete("/products/delete/{id}", "ProductController@destroy")->name("products.delete");
    Route::get("/products-table", "ProductController@table")->name("products.table");



    ///Privacy Routes
    Route::get("/privacy", "PrivacyController@index")->name("privacy.index");
    Route::put("/privacy/update/", "PrivacyController@update")->name("privacy.update");

    ///Admins Routes
    Route::group(["middleware" => "owner"], function () {
        Route::get("/admins", "AdminController@index")->name("admins.index");
        Route::post("/admins/store", "AdminController@store")->name("admins.store");
        Route::get("/admins/edit/{id}", "AdminController@edit")->name("admins.edit");
        Route::put("/admins/update/{id}", "AdminController@update")->name("admins.update");
        Route::delete("/admins/delete/{id}", "AdminController@destroy")->name("admins.delete");
    });

    //Setting Routes
    Route::get("/settings", "SettingController@index")->name("settings.index");
    Route::put("/settings/update/", "SettingController@update")->name("settings.update");
});

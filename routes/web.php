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

    // Route::group(["middleware" => "cart"], function () {
    Route::get("/contact", "ContactController@index")->name("contact");
    Route::get("/feedback", "FeedbackController@index")->name("feedback");
    Route::post("/feedback/store", "FeedbackController@store")->name("feedback.store");
    Route::get("/products/{id}", "ProductController@index")->name("products.view");
    Route::get("/search/{pageNumber}", "ProductController@search")->name("search");
    Route::get("/products/{id}/{pageNumber}", "ProductController@loadProductsByItemId")->name("products.load");

    // });

    ///Cart Routes
    Route::resource("carts", "CartController");
    Route::post("carts/update-cart-post/{id}", "CartController@update")->name("carts.update.post");
    Route::post("/carts/delete-all-products", "CartController@destroyAll")->name("carts.destroy.all");
    // Route::delete("/carts/delete/", "SettingController@update")->name("carts.update");


});

///login  Panel Routes
Route::get("/lbc", "dashboard\DashboardController@login")->name("dashboard.login");
Route::post("/lbc/login", "dashboard\DashboardController@attemptLogin")->name("dashboard.attempt");

/// Dashboard  Routes
Route::group(["prefix" => "wbc", "middleware" => "auth", "namespace" => "dashboard"], function () {
    Route::get("/", "DashboardController@index")->name("dashboard.index");
    Route::get("/logout", "DashboardController@logout")->name("dashboard.logout");



    ///Feedback Routes
    Route::get("/feedbacks", "FeedbackController@index")->name("dashboard.feedbacks.index");
    Route::get("/feedbacks/show/{id}", "FeedbackController@show")->name("dashboard.feedbacks.show");
    Route::delete("/feedbacks/delete/{id}", "FeedbackController@delete")->name("dashboard.feedbacks.delete");
    Route::delete("/feedbacks/all/delete", "FeedbackController@deleteAll")->name("dashboard.feedbacks.delete.all");
    Route::get("/feedbacks-table/{pageNumber}", "FeedbackController@table")->name("dashboard.feedbacks.table");


    ///Items Routes
    Route::get("/items", "ItemController@index")->name("items.index");
    Route::post("/items/store", "ItemController@store")->name("items.store");
    Route::get("/items/edit/{id}", "ItemController@edit")->name("items.edit");
    Route::put("/items/update/{id}", "ItemController@update")->name("items.update");
    Route::delete("/items/delete/{id}", "ItemController@destroy")->name("items.delete");
    Route::get("/items-table/{pageNumber}", "ItemController@table")->name("items.table");
    Route::delete("/items/delete-all", "ItemController@destroyAll")->name("items.delete.all");



    ///Products Routes
    Route::get("/products", "ProductController@index")->name("products.index");
    Route::post("/products/store", "ProductController@store")->name("products.store");
    Route::get("/products/edit/{id}", "ProductController@edit")->name("products.edit");
    Route::put("/products/update/{id}", "ProductController@update")->name("products.update");
    Route::delete("/products/delete/{id}", "ProductController@destroy")->name("products.delete");
    Route::get("/products-table/{pageNumber}", "ProductController@table")->name("products.table");
    Route::delete("/products/delete-all", "ProductController@destroyAll")->name("products.delete.all");




    ///Privacy Routes
    Route::get("/privacy", "PrivacyController@index")->name("privacy.index");
    Route::put("/privacy/update/", "PrivacyController@update")->name("privacy.update");

    ///Supervisors Routes
    Route::get("/users", "SupervisorController@index")->name("users.index");
    Route::post("/users/store", "SupervisorController@store")->name("users.store");
    Route::get("/users/edit/{id}", "SupervisorController@edit")->name("users.edit");
    Route::put("/users/update/{id}", "SupervisorController@update")->name("users.update");
    Route::delete("/users/delete/{id}", "SupervisorController@destroy")->name("users.delete");
    Route::delete("/users/delete-all", "SupervisorController@destroyAll")->name("users.delete.all");
    Route::get("/users-table/{pageNumber}", "SupervisorController@table")->name("users.table");


    ///Roles & Permssions Routes
    Route::resource("roles", "RoleController");
    Route::delete("/roles/delete-all", "RoleController@destroyAll")->name("roles.destroy.all");
    Route::get("/roles-table/{pageNumber}", "RoleController@table")->name("roles.table");


    //Setting Routes
    Route::get("/settings", "SettingController@index")->name("settings.index");
    Route::put("/settings/update/", "SettingController@update")->name("settings.update");
});

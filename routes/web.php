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
    Route::get("contact", "ContactController@index")->name("contact");
    Route::get("feedback", "FeedbackController@index")->name("feedback");
    Route::post("feedback/store", "FeedbackController@store")->name("feedback.store");
    Route::get("products/{id}", "ProductController@index")->name("products.view");
    Route::get("search/{pageNumber}", "ProductController@search")->name("search");
    Route::get("products/{id}/{pageNumber}", "ProductController@loadProductsByItemId")->name("products.load");

    // });

    ///Cart Routes
    Route::resource("carts", "CartController");
    // Route::post("carts/update-cart-post/{id}", "CartController@update")->name("carts.update.post");
    Route::post("carts/delete-all-products", "CartController@destroyAll")->name("carts.destroy.all");
});

Route::group(["middleware" => "guest"], function () {
    ///login  Panel Routes
    Route::get("lbc", "dashboard\DashboardController@login")->name("dashboard.login");
    Route::post("lbc/login", "dashboard\DashboardController@attemptLogin")->name("dashboard.attempt");
});

/// Dashboard  Routes
Route::group(["prefix" => "wbc", "middleware" => "auth", "namespace" => "dashboard"], function () {
    Route::get("", "DashboardController@index")->name("dashboard.index");
    Route::get("logout", "DashboardController@logout")->name("dashboard.logout");



    ///Feedback Routes
    Route::get("feedbacks", "FeedbackController@index")->name("dashboard.feedbacks.index");
    Route::get("feedbacks/show/{id}", "FeedbackController@show")->name("dashboard.feedbacks.show");
    Route::delete("feedbacks/delete-all", "FeedbackController@destroyAll")->name("dashboard.feedbacks.destroy.all");
    Route::delete("feedbacks/delete/{id}", "FeedbackController@destroy")->name("dashboard.feedbacks.destroy");
    Route::get("feedbacks-table/{pageNumber}", "FeedbackController@table")->name("dashboard.feedbacks.table");


    ///Items Routes
    Route::get("items-table/{pageNumber}", "ItemController@table")->name("items.table");
    Route::delete("items/delete-all", "ItemController@destroyAll")->name("items.destroy.all");
    Route::resource("items", "ItemController");



    ///Products Routes
    Route::get("products-table/{pageNumber}", "ProductController@table")->name("products.table");
    Route::delete("products/delete-all", "ProductController@destroyAll")->name("products.destroy.all");
    Route::resource("products", "ProductController");



    ////Privacy Routes
    Route::get("users/{user}/privacy", "PrivacyController@index")->name("users.privacy.index");
    Route::put("users/{user}/privacy", "PrivacyController@update")->name("users.privacy.update");

    ///Supervisors Routes
    Route::delete("users/delete-all", "SupervisorController@destroyAll")->name("users.destroy.all");
    Route::get("users-table/{pageNumber}", "SupervisorController@table")->name("users.table");
    Route::resource("users", "SupervisorController");


    ///Roles & Permssions Routes
    Route::delete("roles/delete-all", "RoleController@destroyAll")->name("roles.destroy.all");
    Route::get("roles-table/{pageNumber}", "RoleController@table")->name("roles.table");
    Route::resource("roles", "RoleController");


    //Setting Routes
    Route::resource("settings", "SettingController");
});

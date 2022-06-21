<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    public function index($id)
    {

        $products = Item::find($id)->products()->paginate(6);

        if (Setting::count() < 1)
            Setting::create();

        $setting = Setting::first();

        return view("general.products", ["products" => $products, "setting" => $setting]);
    }

    public function search(Request $request)
    {



        $products  = Product::where("product_name", "like", "%$request->search%")->paginate(6);
        if (Setting::count() < 1)
            Setting::create();

        $setting = Setting::first();

        return view("general.search", ["products" => $products, "setting" => $setting]);
    }
}

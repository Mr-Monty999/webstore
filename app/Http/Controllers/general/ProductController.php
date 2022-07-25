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

        $products = Item::find($id)->products()->with("item")->paginate(6)->onEachSide(0);
        if (Setting::count() < 1)
            Setting::create([]);

        $setting = Setting::first();

        return view("general.products", ["products" => $products, "setting" => $setting]);
    }

    public function search(Request $request, $pageNumber)
    {


        $products  = Product::where("product_name", "like", "%$request->search%")->with("item")->paginate(6, ['*'], 'page', $pageNumber)->onEachSide(0);
        if (Setting::count() < 1)
            Setting::create([]);

        $setting = Setting::first();

        return view("general.search", ["products" => $products, "setting" => $setting]);
    }
}

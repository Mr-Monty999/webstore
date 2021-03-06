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
    public function index($itemId)
    {

        $item = Item::find($itemId);
        $products = $item->products()->with("item")->paginate(6)->onEachSide(0);

        if (Setting::count() < 1)
            Setting::create([]);

        $setting = Setting::first();

        return view("general.products", ["products" => $products, "setting" => $setting, "item" => $item]);
    }

    public function loadProductsByItemId($itemId, $pageNumber)
    {
        $item = Item::find($itemId);
        $products = $item->products()->with("item")->paginate(6, ['*'], 'page', $pageNumber)->onEachSide(0)->withPath(route('products.view', $itemId));

        if (Setting::count() < 1)
            Setting::create([]);

        $setting = Setting::first();

        return view("general.sub-products", ["products" => $products, "setting" => $setting, "item" => $item]);
    }

    public function search(Request $request, $pageNumber)
    {

        $search = $request->search;
        $products  = Product::where("product_name", "like", "%$search%")->with("item")->paginate(6, ['*'], 'page', $pageNumber)->onEachSide(0);
        if (Setting::count() < 1)
            Setting::create([]);

        $setting = Setting::first();

        return view("general.search", ["products" => $products, "setting" => $setting, "searched" => $search]);
    }
}

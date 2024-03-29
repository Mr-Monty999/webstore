<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Product;
use App\Models\Setting;
use App\Services\CartService;
use App\Services\ItemService;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    public function index($itemId)
    {

        $item = ItemService::show($itemId);
        // $products = $item->products()->with("item")->paginate(6)->onEachSide(0);

        $setting = Setting::latest()->firstOrNew();

        return view("general.products", ["setting" => $setting, "item" => $item]);
    }

    public function loadProductsByItemId($itemId, $pageNumber)
    {
        $item = ItemService::show($itemId);
        $products = $item->products()->with("item")->paginate(6, ['*'], 'page', $pageNumber)->onEachSide(0)->withPath(route('products.view', $itemId));



        $setting = Setting::latest()->firstOrNew();

        return view("general.sub-products", ["products" => $products, "setting" => $setting, "item" => $item]);
    }

    public function search(Request $request, $pageNumber)
    {

        $search = $request->search;
        $products  = Product::where("name", "like", "%$search%")->with("item")->paginate(6, ['*'], 'page', $pageNumber)->onEachSide(0);

        $setting = Setting::latest()->firstOrNew();

        return view("general.search", ["products" => $products, "setting" => $setting, "searched" => $search]);
    }
}

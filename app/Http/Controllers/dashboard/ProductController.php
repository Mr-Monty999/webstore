<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Item;
use App\Models\Product;
use App\Services\DeleteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = Product::with("item")->paginate(5)->onEachSide(0);
        $items = Item::all();
        return view("dashboard.products.index", ["products" => $products, "items" => $items]);
    }

    public function table()
    {
        $products = Product::with("item")->paginate(5)->withPath(route("products.index"))->onEachSide(0);
        $items = Item::all();
        return view("dashboard.products.table", ["products" => $products, "items" => $items]);
    }



    public function store(ProductRequest $request)
    {



        $request->validated();
        $data = $request->all();

        $product = Product::where("product_name", $request->product_name);

        if ($product->exists()) {
            $data["success"] = false;
            $data["message"] = "هذا المنتج موجود بالفعل !";
            return response()->json($data, 200);
        }

        $path = null;
        if (file_exists(public_path()))
            $path = public_path();
        else
            $path = base_path();


        $productDiscount = 0;
        if (trim($request->product_discount) != "")
            $productDiscount = trim($request->product_discount);

        $photo = null;
        $photoName = null;
        if ($request->hasFile("product_photo")) {
            $photo = $request->file("product_photo");
            $photoName = time() . "." . $photo->getClientOriginalExtension();
            $photo->move($path . "/images/products", "$photoName");
            $photoName = "/images/products/" . $photoName;
        }

        $data["product_photo"] = $photoName;
        $data["product_discount"] = $productDiscount;

        Product::create($data);
        $data["success"] = true;
        $data["message"] = "تم الاضافة بنجاح";
        return response()->json($data, 200);
    }



    public function edit($id)
    {

        $product = Product::findOrFail($id);
        $items = Item::all();

        return view("dashboard.products.edit", ["product" => $product, "items" => $items]);
    }


    public function update(ProductRequest $request, $id)
    {


        $request->validated();
        $data = $request->all();

        $product = Product::find($id);
        $oldProduct = Product::where("product_name", $request->product_name);

        if ($oldProduct->exists() && $oldProduct->first()->product_name != $product->product_name) {
            $data["success"] = false;
            $data["message"] = "هذا المنتج موجود بالفعل";

            return response()->json($data, 200);
        }

        $path = null;
        if (file_exists(public_path()))
            $path = public_path();
        else
            $path = base_path();


        $productDiscount = 0;
        if (trim($request->product_discount) != "")
            $productDiscount = trim($request->product_discount);

        $photo = null;
        $photoPath = $product->product_photo;
        $photoName = null;
        if ($request->hasFile("product_photo")) {
            $photo = $request->file("product_photo");
            $photoName = time() . "." . $photo->getClientOriginalExtension();

            // Delete Old Photo
            DeleteService::deleteFile($product->product_photo);

            $photo->move($path . "/images/products", "$photoName");
            $photoPath = "/images/products/" . $photoName;
        }


        $data["product_photo"] = $photoPath;
        $data["product_discount"] = $productDiscount;

        $product->update($data);

        $data["success"] = true;
        $data["message"] = "تم تعديل المنتج بنجاح";
        $data["photo_path"] = asset($photoPath);

        return response()->json($data, 200);
    }


    public function destroy(Request $request, $id)
    {
        $product = Product::find($request->id);
        $data["product"] = $product;
        $product->delete();

        //Delete Old Photo
        DeleteService::deleteFile($product->product_photo);

        $data["success"] = true;
        $data["message"] = "تم الحذف بنجاح";

        return response()->json($data, 200);
    }
    public function destroyAll()
    {

        DB::table("products")->delete();

        //Delete All Photos
        DeleteService::deleteAllFiles("/images/products");

        $data["success"] = true;
        $data["message"] = "تم حذف جميع المنتجات بنجاح";
        return response()->json($data);
    }
}

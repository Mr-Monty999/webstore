<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(5);
        $items = Item::all();
        return view("dashboard.products.index", ["products" => $products, "items" => $items]);
    }




    public function store(ProductRequest $request)
    {
        $request->validated();
        $product = Product::where("product_name", $request->product_name);

        if ($product->exists()) {
            return redirect()->back()->with("error", "هذا المنتج موجود بالفعل");
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

        $data = $request->all();
        $data["product_photo"] = $photoName;
        $data["product_discount"] = $productDiscount;

        Product::create($data);
        return redirect()->back()->with("success", "تم اضافة المنتج بنجاح ");
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
        $product = Product::find($id);
        $oldProduct = Product::where("product_name", $request->product_name);

        if ($oldProduct->exists() && $oldProduct->first()->product_name != $product->product_name) {
            return redirect()->back()->with("error", "هذا المنتج موجود بالفعل");
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
        $photoName = $product->product_photo;
        if ($request->hasFile("product_photo")) {
            $photo = $request->file("product_photo");
            $photoName = time() . "." . $photo->getClientOriginalExtension();

            if (file_exists($path . $product->product_photo) && is_file($path . $product->product_photo))
                unlink($path . $product->product_photo);

            $photo->move($path . "/images/products", "$photoName");
            $photoName = "/images/products/" . $photoName;
        }

        $data = $request->all();

        $data["product_photo"] = $photoName;
        $data["product_discount"] = $productDiscount;

        $product->update($data);

        return redirect()->back()->with("success", "تم التعديل بنجاح ");
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->back()->with("success", "تم الحذف بنجاح");
    }
}

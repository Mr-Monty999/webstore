<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CartService::store($request);
        $data = [
            "success" => true,
            "message" => "تم الاضافة بنجاح"
        ];
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        CartService::update($request, $id);

        $data = [
            "success" => true,
            "message" => "تم التعديل بنجاح",
            "data" => $request->all()
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        CartService::destroy($request, $id);
        $data = [
            "success" => true,
            "message" => "تم الحذف بنجاح",
            "product" => $request->all()
        ];

        return response()->json($data, 200);
    }
    public function destroyAll(Request $request)
    {
        $uid = Cookie::get("cart_uid");
        Cart::where("cart_uid", $uid)->first()->products()->detach();

        $data = [
            "success" => true,
            "message" => "تم الحذف بنجاح",
        ];

        return response()->json($data, 200);
    }
}

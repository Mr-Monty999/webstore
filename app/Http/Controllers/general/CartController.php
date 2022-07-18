<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

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
        $uid = Cookie::get("cart_uid");

        Cart::where("cart_uid", $uid)->first()->products()->syncWithoutDetaching($request->product_id);

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
        $uid = Cookie::get("cart_uid");
        Cart::where("cart_uid", $uid)->first()->products()->syncWithoutDetaching([$request->product_id => ["product_amount" => $request->product_amount]]);
        $data = [
            "success" => true,
            "message" => "تم التعديل بنجاح"
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
        $uid = Cookie::get("cart_uid");
        Cart::where("cart_uid", $uid)->first()->products()->detach($request->product_id);

        return  $request->all();
        $data = [
            "success" => true,
            "message" => "تم الحذف بنجاخ"
        ];

        return response()->json($data, 200);
    }
}

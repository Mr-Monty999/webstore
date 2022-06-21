<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "product_name" => "required",
            "product_price" => "required|numeric",
            "product_photo" => "image|nullable",
            "product_discount" => "numeric|nullable"
        ];
    }

    public function messages()
    {
        return [
            "product_name.required" => "الرجاء كتابة اسم المنتج !",
            "product_price.required" => "الرجاء كتابة سعر المنتج !",
            "product_price.numeric" => "الرجاء كتابة ارقام فقط في السعر !",

            "product_photo.image" => "الرجاء رفع صورة فقط !",
            "product_discount.numeric" => "الرجاء ادخال ارقام فقط في  التخفيض !"

        ];
    }
}

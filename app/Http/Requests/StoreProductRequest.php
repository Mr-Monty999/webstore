<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            "name" => "required",
            "price" => "required|numeric",
            "photo" => "image|nullable",
            "discount" => "numeric|nullable",
            "item_id" => "required|numeric"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "الرجاء كتابة اسم المنتج !",
            "price.required" => "الرجاء كتابة سعر المنتج !",
            "price.numeric" => "الرجاء كتابة ارقام فقط في السعر !",

            "photo.image" => "الرجاء رفع صورة فقط !",
            "discount.numeric" => "الرجاء ادخال ارقام فقط في  التخفيض !"

        ];
    }
}

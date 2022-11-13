<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
            "item_name" => "required",
            "item_photo" => "image|nullable"

        ];
    }

    public function messages()
    {

        return [
            "item_name.required" => "الرجاء كتابة اسم الصنف",
            "item_photo.image" => "الرجاء رفع صورة فقط !",

        ];
    }
}

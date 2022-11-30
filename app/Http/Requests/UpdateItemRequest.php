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
            "name" => "required",
            "photo" => "image|nullable"

        ];
    }

    public function messages()
    {

        return [
            "name.required" => "الرجاء كتابة اسم الصنف",
            "photo.image" => "الرجاء رفع صورة فقط !",

        ];
    }
}

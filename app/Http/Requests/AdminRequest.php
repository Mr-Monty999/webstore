<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            "admin_name" => "required",
            // "password" => "required",
            "admin_photo" => "image|nullable"
        ];
    }

    public function messages()
    {
        return [
            "admin_name.required" => "الرجاء كتابة اسم الادمن !",
            // "password.required" => "الرجاء كتابة كلمة المرور !",
            "admin_photo.image" => "الرجاء اختيار صورة فقط !"
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            "name" => "required|unique:users,name",
            "password" => "required",
            "photo" => "image|nullable"
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "الرجاء كتابة اسم المستخدم !",
            "password.required" => "الرجاء كتابة كلمة المرور !",
            "photo.image" => "الرجاء اختيار صورة فقط !",
            "name.unique" => "هذا الأسم موجود بالفعل !"
        ];
    }
}

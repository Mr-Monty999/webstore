<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            "name" => "required|unique:users,name," . $this->route("user"),
            "photo" => "image|nullable",
            "password" => "nullable"
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "الرجاء كتابة اسم المستخدم !",
            "photo.image" => "الرجاء اختيار صورة فقط !",
            "name.unique" => "هذا الأسم موجود بالفعل !"
        ];
    }
}

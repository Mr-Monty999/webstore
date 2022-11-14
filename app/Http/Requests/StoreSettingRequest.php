<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
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
            "store_name" => "required",
            "store_logo" => "image|nullable",
            "store_currency" => "nullable",
            "home_title" => "nullable",
            "whatsapp_phone" => "nullable",
            "contact_phone1" => "nullable",
            "contact_phone2" => "nullable",
            "contact_address" => "nullable",
        ];
    }

    public function messages()
    {
        return [
            "store_logo.image" => "الرجاء رفع صورة فقط !",
            "store_name.required" => "الرجاء كتابة إسم المتجر !"
        ];
    }
}

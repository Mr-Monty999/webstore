<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
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
            "message" => "required",
            'g-recaptcha-response' => 'required|captcha',


        ];
    }

    public function messages()
    {
        return [
            "name.required" => "الرجاء كتابة اسمك !",
            "message.required" => "الرجاء كتابة الرسالة !",
            "g-recaptcha-response.required" => "الرجاء اجتياز التحقق الامني !"
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignInAdminRequest extends FormRequest
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

    public function messages()
    {
        return [
            'email.required' => 'Bạn phải địa chỉ email',
            'password.required' => 'Bạn phải nhập mật khẩu',
            'g-recaptcha-response.required' => 'Vui lòng xác minh bạn không phải là robot.',
            'g-recaptcha-response.captcha' => 'Xác minh thất bại, vui lòng thử lại.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => "required|min:3|max:50|email:rfc,dns",
            'password' => 'required|string|min:8|max:100',
            'g-recaptcha-response' => 'required|captcha',

        ];
    }
}

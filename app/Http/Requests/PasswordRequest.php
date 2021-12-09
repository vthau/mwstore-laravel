<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
    public function messages()
    {
        return [
            'password.required' => 'Bạn phải nhập mật khẩu',
            'password.confirmed' => '2 mật khẩu không khớp',
            'password.min' => 'Mật khẩu phải từ 8 ký tự trở lên',
            'password_confirmation.required' => 'Bạn phải nhập lại mật khẩu',
            'password_confirmation' => 'Mật khẩu nhập lại phải từ 8 ký tự trở lên',
        ];
    }

    public function rules()
    {
        return [
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8'
        ];
    }
}

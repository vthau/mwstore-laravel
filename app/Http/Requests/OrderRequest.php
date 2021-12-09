<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'name' => "required|min:2|max:20|string",
            'email' => "required|min:3|max:50|email:filter",
            'phone' => "required|digits:10",
            'node' => "min:2|min:2|max:100|string",
            'payment' => "required|min:0|integer",
        ];
    }
}

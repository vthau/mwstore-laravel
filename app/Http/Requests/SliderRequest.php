<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        $image_rule = $this->slider ? 'nullable|mimes:jpg,jpeg,png,gif|max:20000' : 'required|mimes:jpg,jpeg,png,gif|max:20000';
        return [
            'name' => 'required|string|min:2|max:20',
            'product_id' => 'required|integer|min:0',
            'show_hide' => 'required|integer|min:0',
            'image' => $image_rule,
        ];
    }
}

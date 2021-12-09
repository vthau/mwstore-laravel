<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return [];
    }

    public function attributes()
    {
        return [];
    }

    public function rules()
    {
        $id = $this->product;
        $image_rule = $id ? 'nullable|mimes:jpg,jpeg,png,gif|max:20000' : 'required|mimes:jpg,jpeg,png,gif|max:20000';
        return [
            'name' => "required|string|min:2|max:50|unique:products,name" . ($id ? ",$id" : ''),
            'price' => "required|min:1000|integer",
            'quantity' => "required|min:1|integer",
            'brand_id' => "required|min:0|integer",
            'description' => "required|string|min:2|max:100",
            'feather' => "required|min:0|integer",
            'image' => $image_rule,
        ];
    }
}

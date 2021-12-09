<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
        return [
            'image.*' => 'required|mimes:jpg,jpeg,png,gif|max:20000'
        ];
    }
}

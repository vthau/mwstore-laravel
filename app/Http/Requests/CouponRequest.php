<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
        $id = $this->coupon;

        return [
            'name' => "required|string|min:2|max:20",
            'code' => "required|string|min:2|max:10|unique:coupons,code" . ($id ? ",$id" : ''),
            'quantity' => "required|min:1|integer",
            'percent' => "required|min:1|integer",
            'start_coupon' => 'required|date_format:Y-m-d',
            'end_coupon' => 'required|date_format:Y-m-d',
        ];
    }
}

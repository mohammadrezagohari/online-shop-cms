<?php

namespace App\Http\Requests\productColor;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductColorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'color_name'=>'nullable|string|max:255|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'color'=>'nullable|string|max:255',
            'product_id'=>'nullable|exists:products,id',
            'price_increase'=>'nullable|integer',
            'status'=>'nullable|numeric|in:0,1',
            'sold_number'=>'nullable|integer',
            'frozen_number'=>'nullable|integer',
            'marketable_number'=>'nullable|integer',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}

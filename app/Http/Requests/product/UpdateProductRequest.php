<?php

namespace App\Http\Requests\product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
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
            'name'=>'nullable|string|max:255|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'introduction'=>'nullable|string|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'status'=>'nullable|numeric|in:0,1',
            'marketable'=>'nullable|numeric|in:0,1',
            'sold_number'=>'nullable|integer',
            'frozen_number'=>'nullable|integer',
            'marketable_number'=>'nullable|integer',
            'images.*'=>'nullable|image|mimes:png,jpg,jpeg,gif|max:2048',
            'brand_id'=>'nullable|exists:brands,id',
            'category_id'=>'nullable|exists:product-categories,id'
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

<?php

namespace App\Http\Requests\productProperty;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductPropertyRequest extends FormRequest
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
           'property_key'=>'required|string|max:255',
           'property_value'=>'required|string|max:255',
           'product_id'=>'required|integer|exists:products,id',
        ];
    }
}

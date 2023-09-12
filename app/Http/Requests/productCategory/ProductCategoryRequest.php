<?php

namespace App\Http\Requests\productCategory;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
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
            'count'=>'nullable|string',
            'name'=>'nullable|string|max:255',
            'english_name'=>'nullable|string|max:255',
            'status'=>'nullable|numeric|in:0,1',
            'parent'=>'nullable'
        ];
    }
}

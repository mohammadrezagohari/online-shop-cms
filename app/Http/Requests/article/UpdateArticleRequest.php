<?php

namespace App\Http\Requests\article;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateArticleRequest extends FormRequest
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
            'title'   => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'author_id'     => 'nullable|exists:users,id',
            'image'     => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'selected_content'     => 'nullable|numeric|in:0,1',
            'product_category_id'     => 'nullable|integer|exists:product_categories,id',
            'article_category_id'     => 'nullable|integer|exists:article_categories,id',
       
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

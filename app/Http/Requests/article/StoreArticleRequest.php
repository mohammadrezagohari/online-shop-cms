<?php

namespace App\Http\Requests\article;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreArticleRequest extends FormRequest
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
     * @return array<string>
     */
    public function rules(): array
    {
        return [
            'title'   => 'required|string|max:255',
            'description'   => 'required|string',
            'author_id'     => 'required|exists:users,id',
            'image'     => 'required|image|mimes:png,jpg,jpeg,svg',
            'selected_content'     => 'required|numeric|in:0,1',
            'product_category_id'     => 'required|integer|exists:product_categories,id',
            'article_category_id'     => 'required|integer|exists:article_categories,id',
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

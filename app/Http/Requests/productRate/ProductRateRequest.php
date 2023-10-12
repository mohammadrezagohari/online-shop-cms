<?php

namespace App\Http\Requests\productRate;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRateRequest extends FormRequest
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
            'product_category_question_id'   => 'nullable|string|exists:product_category_question,id',
            'rate'     => 'nullable|numeric|in:0,1',
            'product_id'   => 'nullable|string|exists:products,id',
            'user_id'     => 'nullable|string|exists:users,id',
            'comment'     => 'nullable|string',
            'status'     => 'nullable|numeric|in:0,1',

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

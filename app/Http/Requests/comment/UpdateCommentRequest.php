<?php

namespace App\Http\Requests\comment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCommentRequest extends FormRequest
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
            'title'=>'nullable|string|min:3|max:255',
            'body'=>'nullable|string|min:3',
            'parent_id'=>'nullable|integer|exists:comments,id',
            'user_id'=>'nullable|exists:users,id',
            'suggestion'=>'nullanle|numeric|in:0,1',
            'approved'=>'nullanle|numeric|in:0,1',
            'type'=>'nullable|string',
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

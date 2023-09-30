<?php

namespace App\Http\Requests\comment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCommentRequest extends FormRequest
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
           'title'=>'required|string|min:3|max:255',
           'body'=>'required|string|min:3',
           'parent_id'=>'nullable|integer|exists:comments,id',
           'post_id'=>'required|integer|exists:posts,id',
           'user_id'=>'required|exists:users,id',
           'suggestion'=>'required|numeric|in:0,1',
           'type'=>'required|string',
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

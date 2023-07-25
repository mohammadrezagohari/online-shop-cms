<?php

namespace App\Http\Requests\post;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;

class StorePostRequest extends FormRequest
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
            'image'=>'required',File::types(['jpeg','jpg','gif','png','svg'])->min(1024)->max(2*1024),
            'status'=>'required|numeric|in:0,1',
            'user_id'=>'required|exists:users,id',
            'category_id'=>'required|exists:post_categories,id',
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

<?php

namespace App\Http\Requests\aboutAttachment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAboutAttachmentRequest extends FormRequest
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
            'about_id'   => 'required|integer|exists:abouts,id',
            'title'     => 'required|string|max:255',
            'icon'     => 'required|image|mimes:png,jpg,jpeg,svg',


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

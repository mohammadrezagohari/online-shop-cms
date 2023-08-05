<?php

namespace App\Http\Requests\emailFile;

use Illuminate\Foundation\Http\FormRequest;

class EmailFileRequest extends FormRequest
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
            'public_mail_id' => 'nullable|exists:public_mail,id',
            'status' => 'nullable|numeric|in:0,1',
            'count' => 'nullable|integer',
        ];
    }
}

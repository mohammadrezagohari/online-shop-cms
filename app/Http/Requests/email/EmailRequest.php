<?php

namespace App\Http\Requests\email;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
            'count'=>'nullable|integer',
            'status'=>'nullable|numeric|in:0,1',
            'published_at'=>'nullable|date|date_default:Y-m-d H:i:s',
        ];
    }
}

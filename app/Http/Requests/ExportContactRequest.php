<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'keyword' => ['nullable', 'string'],
            'gender' => ['nullable'],
            'category_id' => ['nullable', 'integer'],
            'date' => ['nullable', 'date'],
        ];
    }
}
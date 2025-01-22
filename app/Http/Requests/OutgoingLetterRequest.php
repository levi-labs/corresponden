<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutgoingLetterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'letter_type' => 'required|exists:letter_types,id',
            'subject' => 'required|string|max:255',
            'body' => 'nullable',
            'attachment' => 'nullable|max:10240', // Maksimal 10MB
        ];

        return $rules;
    }
}

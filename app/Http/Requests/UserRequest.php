<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'role' => 'required|string|in:admin,staff,lecturer,student'
        ];

        if ($this->method() === 'PUT') {
            $rules['username'] = 'required|unique:users,username,' . $this->route('user')->id;
            $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $this->route('user')->id;
        };

        if ($this->method() === 'POST') {
            $rules['username'] = 'required|unique:users,username';
            $rules['email'] = 'required|string|email|max:255|unique:users,email';
        }

        return $rules;
    }
}

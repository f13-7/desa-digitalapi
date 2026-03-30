<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
        /**
     * Determine if the user is authorized to make this request.
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'name' => 'required|string|max:255',
           'password' => 'nullable|string|min:8'
        ];
    }
        public function attributes()
    {
        return [
           'name' => 'Nama',
           'password' => 'Kata Sandi'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute harus disini',
            'string' => ':attribute harus berupa string',
            'max' => ':attribute maksimal :max karakter',
            'min' => ':attribute minimal :min karakter',
        ];
    }
}

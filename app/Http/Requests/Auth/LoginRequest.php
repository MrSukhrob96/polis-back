<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            "email" => "required|min:6|max:25",
            "password" => "required|min:6|max:25",
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email обязательные поля',
            'password.required' => 'Пароль обязательные поля',
            'email.min' => 'Минимальная длина email не менее 6',
            'email.max' => 'Максимальная длина email не более 25',
            'password.min' => 'Минимальная длина password не менее 6',
            'password.max' => 'Максимальная длина password не более 25',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'    => false,
            'message'   => $validator->errors()->first(),
            'body'      => []
        ], 400));
    }
}

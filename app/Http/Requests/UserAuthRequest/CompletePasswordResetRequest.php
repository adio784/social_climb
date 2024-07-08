<?php

namespace App\Http\Requests\UserAuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Http\Requests\BaseRequest;

class CompletePasswordResetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users',
            'code' => 'required',
            'password' => [
                'required',
                'string',
                'min:8' 
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'Email not found',
            'password' => 'The password must be at least 8 characters long and contain at least one uppercase letter, one digit, and one special character.',
        ];
    }
}

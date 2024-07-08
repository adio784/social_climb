<?php

namespace App\Http\Requests\UserAuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Http\Requests\BaseRequest;

class PasswordResetRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email address is required',
            'email.email' => 'Invalid email address'
        ];
    }
}

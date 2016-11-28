<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PasswordChangeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required|hash:' . auth()->user()->password,
            'password' => 'required|min:5|different:old_password|confirmed',
            'password_confirmation' => 'required'
        ];
    }
}

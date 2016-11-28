<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->type == 'administrator' ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|min:4',
            'username'              => 'required|min:4|unique:users,username',
            'phone'                 => 'required|min:11|max:11',
            'password'              => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5',
            'type'                  => 'required'
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserUpdateRequest extends Request
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
        $id = (int) $this->input('id');
        return [
            'name'                  => 'required|min:4',
            'username'              => 'required|min:4|unique:users,username,' . $id,
            'phone'                 => 'required|min:11|max:11',
            'type'                  => 'required'
        ];
    }
}

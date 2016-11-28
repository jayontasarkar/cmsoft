<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SendingMessageRequest extends Request
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
            'user_id'   => 'required|exists:users,id',
            'subject'   => 'required|min:5',
            'message'   => 'required|min:5',
        ];
    }
}

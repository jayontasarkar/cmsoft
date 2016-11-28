<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ExpenseRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->id ? true : false;
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
            'amount'                => 'required',
            'business_id'           => 'required|exists:businesses,id',
            'season_id'             => 'required|exists:seasons,id',
        ];
    }
}

<?php

namespace App\Http\Requests\Book;

use App\Http\Requests\BaseFormRequest;


class UpdateRequest extends BaseFormRequest
{
    /**
     * --------------------------------------------------
     * Determine if the user is authorized to make this request.
     *--------------------------------------------------
     * @return bool
     * --------------------------------------------------
     */
    public function authorize()
    {
        return true;
    }

    /**
     * --------------------------------------------------
     * Get the validation rules that apply to the request.
     *--------------------------------------------------
     * @return array
     * --------------------------------------------------
     */
    public function rules()
    {
        return [
            'name'=>'required|string',
            'author'=>'required|string',
            'address'=>'required|string',
            'phone'=>'required|string',
            'description'=>'nullable|string'
        ];
    }
}

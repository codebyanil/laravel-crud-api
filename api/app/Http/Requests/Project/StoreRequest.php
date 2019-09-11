<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\BaseFormRequest;


class StoreRequest extends BaseFormRequest
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
            'url'=>'required|string',
            'description'=>'nullable|string'
        ];
    }
}
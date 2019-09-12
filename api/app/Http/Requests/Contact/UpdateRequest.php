<?php

namespace App\Http\Requests\Contact;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;


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
            'email'=>'nullable', 'email',
            'address'=>'required|string',
            'phone'=>'required|string',
        ];
    }
}

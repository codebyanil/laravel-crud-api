<?php

namespace App\Http\Requests\Contact;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;


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
            'name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('contacts')],
            'address' => 'required|string',
            'phone' => 'required|string',
            'dob' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }
}

<?php

namespace App\Http\Requests\Contact;

use App\Http\Requests\BaseFormRequest;
use App\Rules\AscOrDesc;
use App\Rules\IntOrBool;

class IndexRequest extends BaseFormRequest
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
            'per_page' => ['nullable',new IntOrBool],
            'sort_by' => 'nullable|string',
            'sort_order' => ['nullable', new AscOrDesc],
        ];
    }
}
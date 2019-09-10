<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use stdClass;

class BaseFormRequest extends FormRequest
{
    protected $identity;
    protected $baseRequest;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->baseRequest = $request;
        // per page validation
        if ($request->has('per_page')) {
            if ($request->get('per_page') === 0) {
                $request->merge(['per_page' => false]);
            }
        } else {
            $request->merge(['per_page' => env('PER_PAGE', 15)]);
        }

        // fullname fragment
        if ($request->has('fullname')) {
            $words = preg_split('/\s+/', $request->get('fullname'), 0, PREG_SPLIT_NO_EMPTY);
            if (!empty($words)) {
                $request->merge(['last_name' => array_pop($words)]);
                $request->merge(['first_name' => implode(' ', $words)]);
            }
        }
    }

    /**
     * --------------------------------------------------
     * override failed validation and format errors.
     * --------------------------------------------------
     * @param Validator $validator
     * @throws ValidationException
     * --------------------------------------------------
     */
    protected function failedValidation(Validator $validator)
    {
        // format errors
        $errors = $this->formatErrors($validator->errors());
        throw new ValidationException($validator, response()->json(['errors' => $errors], 422));
    }


    /**
     * --------------------------------------------------
     * format the errors in key/value pair object.
     * --------------------------------------------------
     * @param MessageBag $errors
     * @return stdClass
     * --------------------------------------------------
     */
    private function formatErrors(MessageBag $errors)
    {
        $formatted = new stdClass();
        foreach ($errors->messages() as $key => $error) {
            preg_match('/^(?<full>[a-zA-Z0-9\_\-]+\.(?<row>\d+)\.(?<field>[a-zA-Z0-9\_\-]+))$/im', $key, $matches);
            if (isset($matches['row']) && isset($matches['field'])) {
                $row = $matches['row'] + 1;
                $replace_key = str_replace($matches['full'], $matches['field'] . '_' . $row, $key);
                $replace_text = $matches['field'] . ' field at row ' . $row;
                $formatted->$replace_key = preg_replace('/' . $matches['full'] . '(\s+field)?/im', $replace_text, $error[0]);
            } else {
                $formatted->$key = $error[0];
            }
        }
        return $formatted;
    }
}

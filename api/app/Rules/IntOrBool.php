<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IntOrBool implements Rule
{
    /**
     * Create a new rule instance.
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_int($value) || is_bool($value) || preg_match('/^(\d+|false)$/im', $value)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be int or boolean false.';
    }
}

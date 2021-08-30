<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UseDBRequired implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (@$_REQUEST['use_wp'] == 1) {
            return trim(preg_replace('/ |　/', '', $value));
        }
        return true;
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.db_required');
    }
}

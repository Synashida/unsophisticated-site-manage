<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\Utility;

class ExistHost implements Rule
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
        return count(Utility::getHostInfo($value)) == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.already_exist_vhost');
    }
}

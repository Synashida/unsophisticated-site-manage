<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Services\Utility;

class ExistDB implements Rule
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
        // ホントはこれだめ
        if (@$_REQUEST['use_wp'] == 1) {
            try {
                $conn = new \mysqli(Utility::DB_HOST, Utility::DB_USER, Utility::DB_PASSWORD);
                if ($conn->connect_error != null) {
                    return false;
                }
                return !$conn->select_db($value);
            } catch (\Exception $e) {
                var_dump($e);
                exit;
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.already_exist_db');
    }
}

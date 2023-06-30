<?php

namespace App\Rules;

use App\Models\Guardian as ModelsGuardian;
use Illuminate\Contracts\Validation\Rule;

class Guardian implements Rule
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
        $term = '%' . $value . '%';
        return ModelsGuardian::where('parent_id', $value)
            ->orWhere('email', $value)
            ->first();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Parent/Guardian with the provided id or email doesn\'t exist';
    }
}
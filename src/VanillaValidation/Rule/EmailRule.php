<?php

namespace Rentalhost\VanillaValidation\Rule;

class EmailRule extends Rule
{
    /**
     * Validate if input is a valid email.
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        return is_string($input) && filter_var($input, FILTER_VALIDATE_EMAIL);
    }
}

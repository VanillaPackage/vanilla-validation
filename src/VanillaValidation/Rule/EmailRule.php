<?php

namespace Rentalhost\VanillaValidation\Rule;

/**
 * Class EmailRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class EmailRule extends Rule
{
    /**
     * Validate if input is a valid email.
     * @see Rule::validate
     *
     * @param mixed $input      Rule input.
     * @param array $parameters Rule parameters.
     * @param array &$data      Output data.
     *
     * @return bool
     */
    public function validate($input, array $parameters, array &$data)
    {
        return is_string($input) && filter_var($input, FILTER_VALIDATE_EMAIL);
    }
}

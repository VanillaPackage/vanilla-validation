<?php

namespace Rentalhost\VanillaValidation\Rule;

class RequiredRule extends Rule
{
    /**
     * Validate if input is valid.
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        if (is_string($input)) {
            $input = trim($input);
        }

        return !empty($input);
    }

    /**
     * If negative, this rule will ever returns true.
     * @see Rule::validate
     */
    public function validateNegative($input, array $parameters, array &$data)
    {
        return true;
    }
}

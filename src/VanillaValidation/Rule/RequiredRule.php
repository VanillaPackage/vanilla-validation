<?php

namespace Rentalhost\VanillaValidation\Rule;

use Rentalhost\VanillaValidation\Result\FailBreakable;

class RequiredRule extends Rule
{
    /**
     * Validate if input is valid.
     * @param string $parameters[0] Pass true if you like to break validation if it fails (default false).
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        if (is_string($input)) {
            $input = trim($input);
        }

        // If true is passed to first parameter and the input is empty,
        // so we will break the rules iteration.
        if (array_key_exists(0, $parameters)
        &&  $parameters[0] === true
        &&  empty($input)) {
            return new FailBreakable("fail:required");
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

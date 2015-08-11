<?php

namespace Rentalhost\VanillaValidation\Rule;

class EqualsRule extends Rule
{
    /**
     * Validate if input have the same value than expected.
     * Useful to validate by password confirmation.
     * @param mixed   $parameter[0] Value to compare with.
     * @param boolean $parameter[1] Stricty comparison (optional, default false).
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        if (!array_key_exists(0, $parameters)) {
            return false;
        }

        // Strict comparison.
        if (array_key_exists(1, $parameters)
        &&  $parameters[1] === true) {
            return $input === $parameters[0];
        }

        return $input == $parameters[0];
    }
}

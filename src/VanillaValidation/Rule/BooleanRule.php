<?php

namespace Rentalhost\VanillaValidation\Rule;

class BooleanRule extends Rule
{
    /**
     * Validate if input is a boolean.
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        return is_bool($input);
    }
}

<?php

namespace Rentalhost\VanillaValidation\Rule;

class StringRule extends Rule
{
    /**
     * Validate if input is a string.
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        return is_string($input);
    }
}

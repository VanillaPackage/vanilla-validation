<?php

namespace Rentalhost\VanillaValidation\Rule;

class EmptyRule extends Rule
{
    /**
     * Validate if input is empty.
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        return empty($input);
    }
}

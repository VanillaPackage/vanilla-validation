<?php

namespace Rentalhost\VanillaValidation\Rule;

/**
 * Class BooleanRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class BooleanRule extends Rule
{
    /**
     * Validate if input is a boolean.
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
        return is_bool($input);
    }
}

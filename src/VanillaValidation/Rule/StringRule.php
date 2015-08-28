<?php

namespace Rentalhost\VanillaValidation\Rule;

/**
 * Class StringRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class StringRule extends Rule
{
    /**
     * Validate if input is a string.
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
        return is_string($input);
    }
}

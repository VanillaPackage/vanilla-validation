<?php

namespace Rentalhost\VanillaValidation\Rule;

/**
 * Class PositiveRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class PositiveRule extends Rule
{
    /**
     * Validate if input is an integer.
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
        return filter_var($input, FILTER_VALIDATE_FLOAT) !== false && $input >= 0;
    }
}

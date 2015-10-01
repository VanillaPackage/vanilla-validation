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
        return is_numeric($input) !== false && $input >= 0;
    }
}

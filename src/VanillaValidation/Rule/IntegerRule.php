<?php

namespace Rentalhost\VanillaValidation\Rule;

/**
 * Class IntegerRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class IntegerRule extends Rule
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
        /** @noinspection TypeUnsafeComparisonInspection */
        return is_numeric($input) && (int) $input == $input;
    }
}

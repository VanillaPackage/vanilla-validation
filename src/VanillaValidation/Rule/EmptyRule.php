<?php

namespace Rentalhost\VanillaValidation\Rule;

/**
 * Class EmptyRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class EmptyRule extends Rule
{
    /**
     * Validate if input is empty.
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
        return !$input;
    }
}

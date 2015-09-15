<?php

namespace Rentalhost\VanillaValidation\Rule;

use Rentalhost\VanillaValidation\Result\Nullable;

/**
 * Class NullableRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class NullableRule extends Rule
{
    /**
     * Stop validation if input is empty() after trim().
     *
     * @param mixed $input      Rule input.
     * @param array $parameters Rule parameters.
     * @param array $data       Output data.
     *
     * @see Rule::validate
     * @return boolean
     */
    public function validate($input, array $parameters, array &$data)
    {
        if (trim($input) === '') {
            return new Nullable();
        }

        return true;
    }
}

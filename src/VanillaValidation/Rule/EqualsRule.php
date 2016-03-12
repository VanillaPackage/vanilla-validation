<?php

namespace Rentalhost\VanillaValidation\Rule;

/**
 * Class EqualsRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class EqualsRule extends Rule
{
    /**
     * Validate if input have the same value than expected.
     * Useful to validate by password confirmation.
     *
     * @param mixed $input      Rule input.
     * @param array $parameters Rule parameters.
     * @param array &$data      Output data.
     *
     * @var mixed   $parameters [0] Value to compare with.
     * @var bool    $parameters [1] Stricty comparison (optional, default false).
     *
     * @see                     Rule::validate
     * @return bool
     */
    public function validate($input, array $parameters, array &$data)
    {
        if (!array_key_exists(0, $parameters)) {
            return false;
        }
        
        // Strict comparison.
        if (array_key_exists(1, $parameters) &&
            $parameters[1] === true
        ) {
            return $input === $parameters[0];
        }
        
        /** @noinspection TypeUnsafeComparisonInspection */
        
        return $input == $parameters[0];
    }
}

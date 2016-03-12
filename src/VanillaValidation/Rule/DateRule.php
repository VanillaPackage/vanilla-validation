<?php

namespace Rentalhost\VanillaValidation\Rule;

use DateTime;

/**
 * Class DateRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class DateRule extends Rule
{
    /**
     * Validate if input is a date.
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
        if ($input instanceof DateTime) {
            return true;
        }
        else if (!is_string($input)) {
            return false;
        }
        
        return strtotime($input) !== false;
    }
}

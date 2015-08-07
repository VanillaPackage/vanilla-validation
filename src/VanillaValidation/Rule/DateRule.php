<?php

namespace Rentalhost\VanillaValidation\Rule;

use DateTime;

class DateRule extends Rule
{
    /**
     * Validate if input is a date.
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        if ($input instanceof DateTime) {
            return true;
        }
        else
        if (!is_string($input)) {
            return false;
        }

        return strtotime($input) !== false;
    }
}

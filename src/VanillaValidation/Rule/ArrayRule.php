<?php

namespace Rentalhost\VanillaValidation\Rule;

use ArrayAccess;
use Countable;
use Traversable;

class ArrayRule extends Rule
{
    /**
     * Validate if input is an array.
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        return is_array($input) || (
            $input instanceof ArrayAccess &&
            $input instanceof Traversable &&
            $input instanceof Countable
        );
    }
}

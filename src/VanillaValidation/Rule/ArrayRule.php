<?php

namespace Rentalhost\VanillaValidation\Rule;

use ArrayAccess;
use Countable;
use Traversable;

/**
 * Class ArrayRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class ArrayRule extends Rule
{
    /**
     * Validate if input is an array.
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
        return is_array($input) || (
            $input instanceof ArrayAccess &&
            $input instanceof Traversable &&
            $input instanceof Countable
        );
    }
}

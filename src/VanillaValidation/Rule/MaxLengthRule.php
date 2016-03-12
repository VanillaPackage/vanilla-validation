<?php

namespace Rentalhost\VanillaValidation\Rule;

/**
 * Class MaxLengthRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class MaxLengthRule extends Rule
{
    /**
     * Validate if input have a maximum length.
     * @see Rule::validate
     *
     * @param mixed $input      Rule input.
     * @param array $parameters Rule parameters.
     * @param array &$data      Output data.
     *
     * @var int     $parameters [0] Input max length.
     *
     * @return bool
     */
    public function validate($input, array $parameters, array &$data)
    {
        if (!array_key_exists(0, $parameters)) {
            return false;
        }
        
        $data['length']   = (int) $parameters[0];
        $data['quantify'] = $data['length'];
        
        return strlen($input) <= $data['length'];
    }
}

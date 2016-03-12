<?php

namespace Rentalhost\VanillaValidation\Rule;

use Rentalhost\VanillaValidation\Result\FailBreakable;

/**
 * Class RequiredRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class RequiredRule extends Rule
{
    /**
     * Validate if input is valid.
     *
     * @param mixed $input      Rule input.
     * @param array $parameters Rule parameters.
     * @param array &$data      Output data.
     *
     * @var boolean $parameters [0] Pass false if you like to continue validation even if this rule fails (default true).
     *
     * @see Rule::validate
     * @return bool|FailBreakable
     */
    public function validate($input, array $parameters, array &$data)
    {
        if (is_string($input)) {
            $input = trim($input);
        }
        
        // If false is passed to first parameter, the rule will not be braked.
        if (!$input && ( !array_key_exists(0, $parameters) || $parameters[0] === true )) {
            return new FailBreakable('fail:required');
        }
        
        return (bool) $input;
    }
    
    /**
     * If negative, this rule will ever returns true.
     *
     * @param  mixed $input      Rule input.
     * @param  array $parameters Rule parameters.
     * @param  array $data       Output data.
     *
     * @see Rule::validate
     * @return bool
     */
    public function validateNegative($input, array $parameters, array &$data)
    {
        return true;
    }
}

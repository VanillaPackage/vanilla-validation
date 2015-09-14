<?php

namespace Rentalhost\VanillaValidation\Rule;

/**
 * Class CEPRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class CEPRule extends Rule
{
    /**
     * Validate if input is a valid CEP.
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
        return (bool) preg_match('/^\d{8}$/', $input);
    }
}

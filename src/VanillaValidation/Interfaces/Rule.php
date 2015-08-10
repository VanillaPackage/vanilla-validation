<?php

namespace Rentalhost\VanillaValidation\Interfaces;

interface Rule
{
    /**
     * Validate the rule.
     * @param  mixed $input      Input rule.
     * @param  array $parameters Rule parameters.
     * @param  array $data       Output data.
     * @return boolean
     */
    public function validate($input, array $parameters, array &$data);

    /**
     * Negative validation of rule.
     * @see self::validate
     */
    public function validateNegative($input, array $parameters, array &$data);
}

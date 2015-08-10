<?php

namespace Rentalhost\VanillaValidation\Rule;

use Rentalhost\VanillaValidation\Interfaces\Rule as RuleInterface;

abstract class Rule implements RuleInterface
{
    /**
     * Negative validation of rule.
     * @see self::validate
     */
    public function validateNegative($input, array $parameters, array &$data)
    {
        return !$this->validate($input, $parameters, $data);
    }
}

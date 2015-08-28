<?php

namespace Rentalhost\VanillaValidation\Rule;

use Rentalhost\VanillaValidation\Interfaces\Rule as RuleInterface;

/**
 * Class Rule
 * @package Rentalhost\VanillaValidation\Rule
 */
abstract class Rule implements RuleInterface
{
    /**
     * Negative validation of rule.
     * @see self::validate
     *
     * @param mixed $input      Rule input.
     * @param array $parameters Rule parameters.
     * @param array &$data      Output data.
     *
     * @return bool
     */
    public function validateNegative($input, array $parameters, array &$data)
    {
        return !$this->validate($input, $parameters, $data);
    }
}

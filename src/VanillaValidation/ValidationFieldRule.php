<?php

namespace Rentalhost\VanillaValidation;

class ValidationFieldRule
{
    /**
     * Store rule name.
     * @var string
     */
    public $name;

    /**
     * Store rule parameters.
     * @var mixed[]
     */
    public $parameters;

    /**
     * Store if rule is negative.
     * @example notString()
     * @var boolean
     */
    public $negative;

    /**
     * Construct a new rule.
     * @param string  $name       Rule name.
     * @param mixed[] $parameters Rule parameters.
     */
    public function __construct($name, array $parameters = null)
    {
        // Check if rule is negative.
        if (preg_match('/^not[A-Z]/', $name)) {
            $name = substr($name, 3);
            $this->negative = true;
        }

        $this->name = strtolower($name);
        $this->parameters = $parameters ?: [];
    }

    /**
     * Returns the rule qualified name.
     * @return string
     */
    public function getQualifiedName()
    {
        return $this->negative === true ? "{$this->name}.not" : $this->name;
    }

    /**
     * Validate this rule with value.
     * @param mixed $value Value to validate.
     * @return Result
     */
    public function validate($value)
    {
        return ValidationRules::validate($this, $value);
    }
}

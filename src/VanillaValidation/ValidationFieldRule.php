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
     * Store rule original name.
     * @var string
     */
    public $originalName;

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
        $this->originalName = $name;

        // Check if rule is negative.
        if (preg_match('/^not[A-Z]/', $name)) {
            $name = strtolower($name[3]) . substr($name, 4);
            $this->negative = true;
        }

        $this->name = $name;
        $this->parameters = $parameters ?: [];
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

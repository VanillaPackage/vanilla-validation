<?php

namespace Rentalhost\VanillaValidation;

class ValidationChain
{
    /**
     * Store chain rules.
     * @var ValidationFieldRuleList
     */
    public $rules;

    /**
     * Construct a new chain.
     */
    public function __construct()
    {
        $this->rules = new ValidationFieldRuleList;
    }

    /**
     * Add a rule to chain.
     * @param  string $name       Rule name.
     * @param  array  $parameters Rule parameters.
     * @return $this
     */
    public function __call($name, $parameters)
    {
        $this->rules->add($name, $parameters);

        return $this;
    }

    /**
     * Add the collect action.
     * @param  variable &$reference Reference variable.
     * @return $this
     */
    public function collect(&$reference)
    {
        return $this->__call("collect", [ &$reference ]);
    }

    /**
     * Validate each rules of this chain.
     * @return ValidationResult
     */
    public function validate($input)
    {
        return $this->rules->validate($input);
    }
}

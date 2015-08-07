<?php

namespace Rentalhost\VanillaValidation;

class ValidationField
{
    /**
     * Store field name.
     * @var string
     */
    public $name;

    /**
     * Store field value.
     * @var mixed
     */
    public $value;

    /**
     * Store field rules.
     * @var ValidationFieldRuleList
     */
    public $rules;

    /**
     * Construct a new field.
     * @param string $name  Field name.
     * @param mixed  $value Field value.
     */
    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->rules = new ValidationFieldRuleList;
    }

    /**
     * Set a rule to field.
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
     * Validate each rules of this field.
     * It will run the rules list validate method, passing this value
     * and filling the attribute field with this instance.
     * @return ValidationResult
     */
    public function validate()
    {
        $results = $this->rules->validate($this->value);

        foreach ($results->getResults() as $result) {
            $result->field = $this;
        }

        return $results;
    }
}

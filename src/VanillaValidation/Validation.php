<?php

namespace Rentalhost\VanillaValidation;

class Validation
{
    /**
     * Store fields controller.
     * @var ValidationFieldList
     */
    public $fields;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->fields = new ValidationFieldList;
    }

    /**
     * Clone the field list.
     * @return void
     */
    public function __clone()
    {
        $this->fields = clone $this->fields;
    }

    /**
     * Add a field and return the instance.
     * @param  string $name  Field name.
     * @param  mixed  $value Field value.
     * @return ValidationField
     */
    public function field($name, $value = null)
    {
        return $this->fields->add($name, $value);
    }

    /**
     * Validate.
     * You can specify field values here, to overwrite the value added
     * on field method.
     * @param array|null $values Field values to overwrite.
     * @return ValidationResult
     */
    public function validate($values = null)
    {
        $self = $this;

        // Overwrite current values.
        if ($values !== null) {
            $self = clone $this;
            $self->overwriteWith($values);
        }

        return $self->fields->validate();
    }

    /**
     * Same that validate, but will only returns the success boolean.
     * You can recovery the validation result passing a reference variable.
     * @param ValidationResult &$result Reference to validation result.
     * @return boolean
     */
    public function test(ValidationResult &$result = null)
    {
        return $this->testWith(null, $result);
    }

    /**
     * Same that test, but will allow you overwrite fields values.
     * @param  array|null        $values [description]
     * @param  ValidationResult &$result [description]
     * @return boolean
     */
    public function testWith($values, ValidationResult &$result = null)
    {
        $result = $this->validate($values);

        return $result->isSuccess();
    }

    /**
     * Overwrite all fields values on instance.
     * @param  array $values Values to overwrite.
     * @return void
     */
    private function overwriteWith(array $values)
    {
        foreach ($this->fields->all() as $field) {
            if (array_key_exists($field->name, $values)) {
                $field->value = $values[$field->name];
            }
        }
    }

    /**
     * Create a chain instance.
     * @param string $function First chain function.
     * @param mixed  $args     First chain parameters.
     * @return ValidationChain
     */
    public static function __callStatic($function, $args)
    {
        $chain = new ValidationChain;
        $chain->__call($function, $args);

        return $chain;
    }
}

<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaEvent\EventListener;

/**
 * Class Validation
 * @package Rentalhost\VanillaValidation
 * @method static ValidationChain trim( string $trimmable = null )
 * @method static ValidationChain intersectNumbers()
 * @method static ValidationChain required( boolean $breakIfEmpty = null )
 * @method static ValidationChain string()
 * @method static ValidationChain notString()
 * @method static ValidationChain date()
 * @method static ValidationChain notDate()
 * @method static ValidationChain email()
 * @method static ValidationChain notEmail()
 * @method static ValidationChain equals( mixed $value, boolean $strictComparison = false )
 * @method static ValidationChain notEquals( mixed $value, boolean $strictComparison = false )
 * @method static ValidationChain integer()
 * @method static ValidationChain notInteger()
 * @method static ValidationChain int()
 * @method static ValidationChain notInt()
 * @method static ValidationChain mask( string $mask, array $maskDefinition = null )
 * @method static ValidationChain notMask( string $mask, array $maskDefinition = null )
 * @method static ValidationChain minLength( integer $length )
 * @method static ValidationChain notMinLength( integer $length )
 * @method static ValidationChain maxLength( integer $length )
 * @method static ValidationChain notMaxLength( integer $length )
 * @method static ValidationChain sameLength( integer $length )
 * @method static ValidationChain notSameLength( integer $length )
 * @method static ValidationChain breakable()
 * @method static ValidationChain nullable()
 * @method static ValidationChain positive()
 * @method static ValidationChain notPositive()
 * @method static ValidationChain strength( float $expectedStrength )
 * @method static ValidationChain notStrength( float $expectedStrength )
 * @method static ValidationChain empty()
 * @method static ValidationChain notEmpty()
 * @method static ValidationChain emp()
 * @method static ValidationChain notEmp()
 * @method static ValidationChain array()
 * @method static ValidationChain notArray()
 * @method static ValidationChain arr()
 * @method static ValidationChain notArr()
 * @method static ValidationChain boolean()
 * @method static ValidationChain notBoolean()
 * @method static ValidationChain bool()
 * @method static ValidationChain notBool()
 * @method static ValidationChain cep()
 * @method static ValidationChain notCep()
 * @method static ValidationChain cpf()
 * @method static ValidationChain notCpf()
 * @method static ValidationChain cnpj()
 * @method static ValidationChain notCnpj()
 */
class Validation
{
    /**
     * Store validation global options.
     * @var array
     */
    private static $options = [
        /**
         * Locale fallbacks.
         * @var string[]|string
         */
        'locale' => [ 'en' ],
    ];

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
     * Create a chain instance.
     *
     * @param string $function First chain function.
     * @param mixed  $args     First chain parameters.
     *
     * @return ValidationChain
     */
    public static function __callStatic($function, $args)
    {
        $chain = new ValidationChain;

        /** @noinspection ImplicitMagicMethodCallInspection */
        $chain->__call($function, $args);

        return $chain;
    }

    /**
     * Start a validation chain with a reference.
     *
     * @param  mixed &$reference Reference variable.
     *
     * @return ValidationChain
     */
    public static function collect(&$reference)
    {
        /** @noinspection ImplicitMagicMethodCallInspection */
        return self::__callStatic('collect', [ &$reference ]);
    }

    /**
     * Set or get global option.
     *
     * @param  string $key   Option key.
     * @param  mixed  $value Option value (to set).
     *
     * @return mixed|null
     */
    public static function option($key, $value = null)
    {
        if (!array_key_exists($key, self::$options)) {
            return null;
        }

        // Get a option by key.
        if (func_num_args() === 1) {
            return self::$options[$key];
        }

        // Set a existing option.
        self::$options[$key] = $value;

        // Dispatch option.set event.
        EventListener::$global->fire("rentalhost.validation::option.set.{$key}");

        return null;
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
     *
     * @param  string $name  Field name.
     * @param  mixed  $value Field value.
     *
     * @return ValidationField
     */
    public function field($name, $value = null)
    {
        return $this->fields->add($name, $value);
    }

    /**
     * Same that validate, but will only returns the success boolean.
     * You can recovery the validation result passing a reference variable.
     *
     * @param ValidationResult $result Reference to validation result.
     *
     * @return boolean
     */
    public function test(&$result = null)
    {
        return $this->testWith(null, $result);
    }

    /**
     * Same that test, but will allow you overwrite fields values.
     *
     * @param array|null       $values Values to overwrite.
     * @param ValidationResult $result Reference to validation result.
     *
     * @return boolean
     */
    public function testWith($values, &$result = null)
    {
        $result = $this->validate($values);

        return $result->isSuccess();
    }

    /**
     * Validate.
     * You can specify field values here, to overwrite the value added
     * on field method.
     *
     * @param array|null $values Field values to overwrite.
     *
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
     * Overwrite all fields values on instance.
     *
     * @param  array $values Values to overwrite.
     *
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
}

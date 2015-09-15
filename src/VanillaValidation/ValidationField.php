<?php

namespace Rentalhost\VanillaValidation;

/**
 * Class ValidationField
 * @package Rentalhost\VanillaValidation
 * @method $this trim( string $trimmable = null )
 * @method $this intersectNumbers()
 * @method $this required( boolean $breakIfEmpty = null )
 * @method $this string()
 * @method $this notString()
 * @method $this date()
 * @method $this notDate()
 * @method $this email()
 * @method $this notEmail()
 * @method $this equals( mixed $value, boolean $strictComparison = false )
 * @method $this notEquals( mixed $value, boolean $strictComparison = false )
 * @method $this mask( string $mask, array $maskDefinition = null )
 * @method $this notMask( string $mask, array $maskDefinition = null )
 * @method $this minLength( integer $length )
 * @method $this notMinLength( integer $length )
 * @method $this maxLength( integer $length )
 * @method $this notMaxLength( integer $length )
 * @method $this sameLength( integer $length )
 * @method $this notSameLength( integer $length )
 * @method $this breakable()
 * @method $this nullable()
 * @method $this strength( float $expectedStrength )
 * @method $this notStrength( float $expectedStrength )
 * @method $this empty()
 * @method $this notEmpty()
 * @method $this emp()
 * @method $this notEmp()
 * @method $this array()
 * @method $this notArray()
 * @method $this arr()
 * @method $this notArr()
 * @method $this boolean()
 * @method $this notBoolean()
 * @method $this bool()
 * @method $this notBool()
 * @method $this cep()
 * @method $this notCep()
 * @method $this cpf()
 * @method $this notCpf()
 * @method $this cnpj()
 * @method $this notCnpj()
 */
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
     *
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
     *
     * @param  string $name       Rule name.
     * @param  array  $parameters Rule parameters.
     *
     * @return $this
     */
    public function __call($name, $parameters)
    {
        $this->rules->add($name, $parameters);

        return $this;
    }

    /**
     * Add the collect action.
     *
     * @param  mixed &$reference Reference variable.
     *
     * @return $this
     */
    public function collect(&$reference)
    {
        return $this->__call('collect', [ &$reference ]);
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

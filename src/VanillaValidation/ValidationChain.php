<?php

namespace Rentalhost\VanillaValidation;

/**
 * Class ValidationChain
 * @package Rentalhost\VanillaValidation
 *
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
 * @method $this integer()
 * @method $this notInteger()
 * @method $this int()
 * @method $this notInt()
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
     * Validate each rules of this chain.
     *
     * @param mixed $input Input to validate.
     *
     * @return ValidationResult
     */
    public function validate($input)
    {
        return $this->rules->validate($input);
    }
}

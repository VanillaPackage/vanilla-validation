<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaValidation\Interfaces\Action;
use Rentalhost\VanillaValidation\Result\Fail;
use Rentalhost\VanillaValidation\Result\Result;
use Rentalhost\VanillaValidation\Result\Success;

/**
 * Class ValidationRulesSingleton
 * @package Rentalhost\VanillaValidation
 */
class ValidationRulesSingleton
{
    /**
     * Stores defined rules.
     * @var string[]
     */
    private $rules;

    /**
     * Construct default rules.
     */
    public function __construct()
    {
        $this->rules = [
            // Actions.
            'trim'             => Rule\TrimAction::class,
            'collect'          => Rule\CollectAction::class,
            'intersectNumbers' => Rule\IntersectNumbersAction::class,

            // Rules.
            'required'         => Rule\RequiredRule::class,
            'string'           => Rule\StringRule::class,
            'date'             => Rule\DateRule::class,
            'email'            => Rule\EmailRule::class,
            'equals'           => Rule\EqualsRule::class,
            'mask'             => Rule\MaskRule::class,
            'minLength'        => Rule\MinLengthRule::class,
            'maxLength'        => Rule\MaxLengthRule::class,
            'sameLength'       => Rule\SameLengthRule::class,
            'breakable'        => Rule\BreakableRule::class,
            'nullable'         => Rule\NullableRule::class,
            'positive'         => Rule\PositiveRule::class,
            'strength'         => Rule\StrengthRule::class,

            // Rules with aliases.
            'empty'            => Rule\EmptyRule::class,
            'emp'              => Rule\EmptyRule::class,
            'array'            => Rule\ArrayRule::class,
            'arr'              => Rule\ArrayRule::class,
            'boolean'          => Rule\BooleanRule::class,
            'bool'             => Rule\BooleanRule::class,
            'cep'              => Rule\CEPRule::class,
            'CEP'              => Rule\CEPRule::class,
            'cpf'              => Rule\CPFRule::class,
            'CPF'              => Rule\CPFRule::class,
            'cnpj'             => Rule\CNPJRule::class,
            'CNPJ'             => Rule\CNPJRule::class,
            'integer'          => Rule\IntegerRule::class,
            'int'              => Rule\IntegerRule::class,
        ];
    }

    /**
     * Defines a new validator.
     *
     * @param string $name      Rule name.
     * @param string $classname Rule class.
     */
    public function define($name, $classname)
    {
        $this->rules[$name] = $classname;
    }

    /**
     * Check if validator was defined.
     *
     * @param  string $name Rule name.
     *
     * @return boolean
     */
    public function has($name)
    {
        return array_key_exists($name, $this->rules);
    }

    /**
     * Normalize the rule name.
     * It'll return the full name of an alias, for instance.
     * It'll not normalize rule case.
     * Will return null if rule not exists.
     *
     * @param  string $name Rule name to normalize.
     *
     * @return string|null
     */
    public function normalize($name)
    {
        if (!$this->has($name)) {
            return null;
        }

        return array_search($this->rules[$name], $this->rules, true);
    }

    /**
     * Validate a input.
     *
     * @param  ValidationFieldRule $rule  Rule instance.
     * @param  mixed               $input Current input value.
     *
     * @throws Exception\RuleNotImplementedException If rule was not implemented.
     * @return Result
     */
    public function validate(ValidationFieldRule $rule, $input)
    {
        // Check if rule exists.
        if (!$this->has($rule->name)) {
            throw new Exception\RuleNotImplementedException("rule not implemented: {$rule->name}");
        }

        /** @var Action $validateClass */
        $validateClass = new $this->rules[$rule->name];

        // If it is an action, so call action and return it value.
        if (is_subclass_of($validateClass, Action::class)) {
            return $validateClass->action($input, $rule->parameters);
        }

        // Call rule validate method.
        $validateMethod     = $rule->negative === true ? 'validateNegative' : 'validate';
        $validateOutputData = [ ];
        $validateReturn     = call_user_func_array([ $validateClass, $validateMethod ], [
            $input,
            $rule->parameters,
            &$validateOutputData,
        ]);

        // If returns a instance of Result, return it directly.
        if ($validateReturn instanceof Result) {
            return $validateReturn;
        }

        // Returns a success.
        if ($validateReturn) {
            return new Success($validateOutputData);
        }

        // Returns a fail.
        return new Fail('fail:' . $rule->originalName, $validateOutputData);
    }
}

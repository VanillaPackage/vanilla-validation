<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class CEPRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class CEPRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     *
     * @param string $name            Rule name.
     * @param array  $parameters      Rule parameters.
     * @param mixed  $input           Rule input.
     * @param string $expectedMessage Rule result expected message.
     * @param null   $expectedData    Rule result expected data.
     *
     * @covers       Rentalhost\VanillaValidation\Rule\CEPRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\CEPRule::validateNegative
     * @dataProvider dataRule
     */
    public function testRule($name, $parameters, $input, $expectedMessage = 'success', $expectedData = null)
    {
        parent::testRule($name, $parameters, $input, $expectedMessage, $expectedData);
    }

    /**
     * Rules data.
     */
    public function dataRule()
    {
        return [
            1000 =>
                [ 'CEP', [ ], '44419888', 'success' ],
            [ 'CEP', [ ], '25261819', 'success' ],
            [ 'CEP', [ ], '91911840', 'success' ],
            [ 'CEP', [ ], '29255488', 'success' ],
            [ 'CEP', [ ], '68647644', 'success' ],
            [ 'CEP', [ ], '74718697', 'success' ],
            [ 'CEP', [ ], '43423284', 'success' ],
            [ 'CEP', [ ], '45408333', 'success' ],
            [ 'CEP', [ ], '44461102', 'success' ],
            2000 =>
                [ 'CEP', [ ], 'abc', 'fail:cep' ],
            [ 'CEP', [ ], '1', 'fail:cep' ],
            [ 'CEP', [ ], '22', 'fail:cep' ],
            [ 'CEP', [ ], '123', 'fail:cep' ],
            [ 'CEP', [ ], 'aaaaabbb', 'fail:cep' ],
            [ 'CEP', [ ], '00000000011', 'fail:cep' ],
            [ 'CEP', [ ], '00000000000', 'fail:cep' ],
            [ 'CEP', [ ], '992999999999929384', 'fail:cep' ],
            [ 'CEP', [ ], 'not34244419888valid', 'fail:cep' ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        /** @noinspection CallableReferenceNameMismatchInspection */
        static::assertInstanceOf(ValidationChain::class, Validation::CEP());
        static::assertInstanceOf(ValidationChain::class, Validation::cep());
    }

    /**
     * Test intersect numbers with CEP.
     * @coversNothing
     * @return void
     */
    public function testWithIntersectNumbers()
    {
        static::assertTrue(Validation::intersectNumbers()->cep()->validate('12345-678')->isSuccess());
    }
}

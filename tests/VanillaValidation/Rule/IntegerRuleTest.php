<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class IntegerRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class IntegerRuleTest extends RuleTestCase
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
     * @covers       Rentalhost\VanillaValidation\Rule\IntegerRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\IntegerRule::validateNegative
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
                [ 'integer', [ ], 123 ],
            [ 'integer', [ ], -123 ],
            [ 'integer', [ ], '123' ],
            [ 'integer', [ ], '-123' ],
            [ 'integer', [ ], '0123' ],
            [ 'integer', [ ], PHP_INT_MAX ],
            2000 =>
                [ 'integer', [ ], null, 'fail:integer' ],
            [ 'integer', [ ], 'a', 'fail:integer' ],
            [ 'integer', [ ], '0xFF', 'fail:integer' ],
            [ 'integer', [ ], '0b11', 'fail:integer' ],
            [ 'integer', [ ], '0o777', 'fail:integer' ],
            [ 'integer', [ ], 1.23, 'fail:integer' ],
            [ 'integer', [ ], -1.23, 'fail:integer' ],
            [ 'integer', [ ], '1.23', 'fail:integer' ],
            [ 'integer', [ ], '-1.23', 'fail:integer' ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        static::assertInstanceOf(ValidationChain::class, Validation::integer());
        static::assertInstanceOf(ValidationChain::class, Validation::int());
    }
}

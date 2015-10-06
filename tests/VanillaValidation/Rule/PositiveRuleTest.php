<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class PositiveRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class PositiveRuleTest extends RuleTestCase
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
     * @covers       Rentalhost\VanillaValidation\Rule\PositiveRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\PositiveRule::validateNegative
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
                [ 'positive', [ ], 123 ],
            [ 'positive', [ ], '123' ],
            [ 'positive', [ ], '+123' ],
            [ 'positive', [ ], '0123' ],
            [ 'positive', [ ], PHP_INT_MAX ],
            [ 'positive', [ ], 1.23 ],
            [ 'positive', [ ], '1.23' ],
            [ 'positive', [ ], '1.' ],
            [ 'positive', [ ], '.1' ],
            2000 =>
                [ 'positive', [ ], null, 'fail:positive' ],
            [ 'positive', [ ], 'a', 'fail:positive' ],
            [ 'positive', [ ], 'a1', 'fail:positive' ],
            [ 'positive', [ ], '1a', 'fail:positive' ],
            [ 'positive', [ ], -1.23, 'fail:positive' ],
            [ 'positive', [ ], '-1.23', 'fail:positive' ],
            [ 'positive', [ ], -123, 'fail:positive' ],
            [ 'positive', [ ], '-123', 'fail:positive' ],
            [ 'positive', [ ], '0xFF', 'fail:positive' ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        static::assertInstanceOf(ValidationChain::class, Validation::positive());
    }
}

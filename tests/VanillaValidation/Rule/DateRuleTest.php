<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use DateTime;
use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class DateRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class DateRuleTest extends RuleTestCase
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
     * @covers       Rentalhost\VanillaValidation\Rule\DateRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\DateRule::validateNegative
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
                [ 'date', [ ], 'today' ],
            [ 'date', [ ], 'now' ],
            [ 'date', [ ], '2015-01-01' ],
            [ 'date', [ ], '2015-02-30' ],
            [ 'date', [ ], '2015-01-00' ],
            [ 'date', [ ], new DateTime ],
            2000 =>
                [ 'date', [ ], 'invalid', 'fail:date' ],
            [ 'date', [ ], (object) [ ], 'fail:date' ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        static::assertInstanceOf(ValidationChain::class, Validation::date());
    }
}

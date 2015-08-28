<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class MaxLengthRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class MaxLengthRuleTest extends RuleTestCase
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
     * @covers       Rentalhost\VanillaValidation\Rule\MaxLengthRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\MaxLengthRule::validateNegative
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
                [ 'maxLength', [ 5 ], 'hello', 'success', [ 'length' => 5, 'quantify' => 5 ] ],
            [ 'maxLength', [ 10 ], 'hello', 'success', [ 'length' => 10, 'quantify' => 10 ] ],
            2000 =>
                [ 'maxLength', [ ], 'hello', 'fail:maxLength' ],
            [ 'maxLength', [ 0 ], 'hello', 'fail:maxLength', [ 'length' => 0, 'quantify' => 0 ] ],
            [ 'maxLength', [ -5 ], 'hello', 'fail:maxLength', [ 'length' => -5, 'quantify' => -5 ] ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        static::assertInstanceOf(ValidationChain::class, Validation::maxLength(5));
    }
}

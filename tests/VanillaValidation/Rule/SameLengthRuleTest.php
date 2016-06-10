<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class SameLengthRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class SameLengthRuleTest extends RuleTestCase
{
    /**
     * Rules data.
     */
    public function dataRule()
    {
        return [
            1000 =>
                [ 'sameLength', [ 5 ], 'hello', 'success', [ 'length' => 5, 'quantify' => 5 ] ],
            2000 =>
                [ 'sameLength', [ ], 'hello', 'fail:sameLength' ],
            [ 'sameLength', [ 10 ], 'hello', 'fail:sameLength', [ 'length' => 10, 'quantify' => 10 ] ],
            [ 'sameLength', [ 0 ], 'hello', 'fail:sameLength', [ 'length' => 0, 'quantify' => 0 ] ],
            [ 'sameLength', [ -5 ], 'hello', 'fail:sameLength', [ 'length' => -5, 'quantify' => -5 ] ],
        ];
    }

    /**
     * Test rule.
     *
     * @param string $name            Rule name.
     * @param array  $parameters      Rule parameters.
     * @param mixed  $input           Rule input.
     * @param string $expectedMessage Rule result expected message.
     * @param null   $expectedData    Rule result expected data.
     *
     * @covers       Rentalhost\VanillaValidation\Rule\SameLengthRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\SameLengthRule::validateNegative
     * @dataProvider dataRule
     */
    public function testRule($name, $parameters, $input, $expectedMessage = 'success', $expectedData = null)
    {
        parent::testRule($name, $parameters, $input, $expectedMessage, $expectedData);
    }

    /**
     * Test rule directly.
     * @coversNothing
     */
    public function testDirect()
    {
        static::assertInstanceOf(ValidationChain::class, Validation::sameLength(5));
    }
}

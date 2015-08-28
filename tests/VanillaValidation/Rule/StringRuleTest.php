<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class StringRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class StringRuleTest extends RuleTestCase
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
     * @covers       Rentalhost\VanillaValidation\Rule\StringRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\StringRule::validateNegative
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
                [ 'string', [ ], 'test' ],
            [ 'string', [ ], '' ],
            2000 =>
                [ 'string', [ ], 0, 'fail:string' ],
            [ 'string', [ ], [ ], 'fail:string' ],
            [ 'string', [ ], false, 'fail:string' ],
            [ 'string', [ ], null, 'fail:string' ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        static::assertInstanceOf(ValidationChain::class, Validation::string());
    }
}

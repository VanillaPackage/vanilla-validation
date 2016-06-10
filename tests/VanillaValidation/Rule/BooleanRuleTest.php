<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class BooleanRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class BooleanRuleTest extends RuleTestCase
{
    /**
     * Rules data.
     */
    public function dataRule()
    {
        return [
            1000 =>
                [ 'boolean', [ ], true ],
            [ 'boolean', [ ], false ],
            2000 =>
                [ 'boolean', [ ], null, 'fail:boolean' ],
            [ 'boolean', [ ], 123, 'fail:boolean' ],
            [ 'boolean', [ ], [ ], 'fail:boolean' ],
            [ 'boolean', [ ], (object) [ ], 'fail:boolean' ],
            [ 'boolean', [ ], 'abc', 'fail:boolean' ],
            [ 'boolean', [ ], 0, 'fail:boolean' ],
            [ 'boolean', [ ], 1, 'fail:boolean' ],
            3000 =>
                [ 'bool', [ ], null, 'fail:boolean' ],
            [ 'bool', [ ], 123, 'fail:boolean' ],
            [ 'bool', [ ], [ ], 'fail:boolean' ],
            [ 'bool', [ ], (object) [ ], 'fail:boolean' ],
            [ 'bool', [ ], 'abc', 'fail:boolean' ],
            [ 'bool', [ ], 0, 'fail:boolean' ],
            [ 'bool', [ ], 1, 'fail:boolean' ],
            4000 =>
                [ 'notBoolean', [ ], true, 'fail:notBoolean' ],
            [ 'notBoolean', [ ], false, 'fail:notBoolean' ],
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
     * @covers       Rentalhost\VanillaValidation\Rule\BooleanRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\BooleanRule::validateNegative
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
        static::assertInstanceOf(ValidationChain::class, Validation::bool());
        static::assertInstanceOf(ValidationChain::class, Validation::boolean());
    }
}

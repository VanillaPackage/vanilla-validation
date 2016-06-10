<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class EmptyRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class EmptyRuleTest extends RuleTestCase
{
    /**
     * Rules data.
     */
    public function dataRule()
    {
        return [
            1000 =>
                [ 'empty', [ ], 0 ],
            [ 'empty', [ ], [ ] ],
            [ 'empty', [ ], '' ],
            [ 'empty', [ ], false ],
            [ 'empty', [ ], null ],
            2000 =>
                [ 'empty', [ ], 'test', 'fail:empty' ],
            [ 'empty', [ ], ' ', 'fail:empty' ],
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
     * @covers       Rentalhost\VanillaValidation\Rule\EmptyRule::validate
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
        static::assertInstanceOf(ValidationChain::class, Validation::emp());
    }
}

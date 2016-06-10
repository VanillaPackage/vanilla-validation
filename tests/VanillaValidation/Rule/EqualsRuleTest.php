<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class EqualsRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class EqualsRuleTest extends RuleTestCase
{
    /**
     * Rules data.
     */
    public function dataRule()
    {
        return [
            1000 =>
                [ 'equals', [ 'hello' ], 'hello' ],
            [ 'equals', [ 'hello', true ], 'hello' ],
            [ 'equals', [ '1' ], 1 ],
            [ 'equals', [ '1', false ], 1 ],
            [ 'equals', [ 1 ], '1' ],
            [ 'equals', [ 1, true ], 1 ],
            2000 =>
                [ 'equals', [ ], 'hello', 'fail:equals' ],
            [ 'equals', [ 'olleh' ], 'hello', 'fail:equals' ],
            [ 'equals', [ 1, true ], '1', 'fail:equals' ],
            [ 'equals', [ '1', true ], 1, 'fail:equals' ],
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
     * @covers       Rentalhost\VanillaValidation\Rule\EqualsRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\EqualsRule::validateNegative
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
        static::assertInstanceOf(ValidationChain::class, Validation::equals('test'));
    }
}

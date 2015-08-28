<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class StrengthRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class StrengthRuleTest extends RuleTestCase
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
     * @covers       Rentalhost\VanillaValidation\Rule\StrengthRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\StrengthRule::validateNegative
     * @covers       Rentalhost\VanillaValidation\Rule\StrengthRule::calculateStrength
     * @covers       Rentalhost\VanillaValidation\Rule\StrengthRule::percentualToInteger
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
                [ 'strength', [ 0 ], '', 'success', [ 'expected' => 0.0, 'strength' => 0.0 ] ],
            [ 'strength', [ 0 ], 'hello', 'success', [ 'expected' => 0.0, 'strength' => 0.25 ] ],
            [ 'strength', [ '0.10' ], 'hello', 'success', [ 'expected' => 0.10, 'strength' => 0.25 ] ],
            [ 'strength', [ '0%' ], 'hello', 'success', [ 'expected' => 0.0, 'strength' => 0.25 ] ],
            [ 'strength', [ 0.37 ], 'heLLo', 'success', [ 'expected' => 0.37, 'strength' => 0.37 ] ],
            [ 'strength', [ 0.52 ], 'heLLo123', 'success', [ 'expected' => 0.52, 'strength' => 0.52 ] ],
            [ 'strength', [ 0.70 ], 'heLLo123$$', 'success', [ 'expected' => 0.70, 'strength' => 0.70 ] ],
            [ 'strength', [ 0.25 ], 'aaaaaaaaaaaaaaaaaaaaa', 'success', [ 'expected' => 0.25, 'strength' => 0.25 ] ],
            [ 'strength', [ 0.90 ], 'aGoodPa$$wordIsL1keThat', 'success', [ 'expected' => 0.90, 'strength' => 0.90 ] ],
            [ 'strength', [ 0.97 ], 'orUC4nJu$tChec%Tha+Herê', 'success', [ 'expected' => 0.97, 'strength' => 0.97 ] ],
            [ 'strength', [ 0.37 ], 'abcdefghijklmnopqr', 'success', [ 'expected' => 0.37, 'strength' => 0.37 ] ],
            2000 =>
                [ 'strength', [ ], 'hello', 'fail:strength' ],
            [ 'strength', [ 0.70 ], 'abcdefghijklmnopqr', 'fail:strength', [ 'expected' => 0.70, 'strength' => 0.37 ] ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        static::assertInstanceOf(ValidationChain::class, Validation::strength());
    }
}

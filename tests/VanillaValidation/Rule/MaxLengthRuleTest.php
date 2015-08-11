<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class MaxLengthRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     * @covers Rentalhost\VanillaValidation\Rule\MaxLengthRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\MaxLengthRule::validateNegative
     * @dataProvider dataRule
     */
    public function testRule($name, $parameters, $input, $expectedMessage = "success", $expectedData = null)
    {
        return parent::testRule($name, $parameters, $input, $expectedMessage, $expectedData);
    }

    public function dataRule()
    {
        return [
            1000 =>
            [ "maxLength", [ 5 ], "hello", "success", [ "length" => 5, "quantify" => 5 ] ],
            [ "maxLength", [ 10 ], "hello", "success", [ "length" => 10, "quantify" => 10 ] ],

            2000 =>
            [ "maxLength", [], "hello", "fail:maxLength" ],
            [ "maxLength", [ 0 ], "hello", "fail:maxLength", [ "length" => 0, "quantify" => 0 ] ],
            [ "maxLength", [ -5 ], "hello", "fail:maxLength", [ "length" => -5, "quantify" => -5 ] ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::maxLength());
    }
}

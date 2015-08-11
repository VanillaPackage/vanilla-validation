<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class MinLengthRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     * @covers Rentalhost\VanillaValidation\Rule\MinLengthRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\MinLengthRule::validateNegative
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
            [ "minLength", [ 5 ], "hello world", "success", [ "length" => 5, "quantify" => 5 ] ],
            [ "minLength", [ 0 ], "hello world", "success", [ "length" => 0, "quantify" => 0 ] ],
            [ "minLength", [ -5 ], "hello world", "success", [ "length" => -5, "quantify" => -5 ] ],

            2000 =>
            [ "minLength", [], "hello", "fail:minLength" ],
            [ "minLength", [ 10 ], "hello", "fail:minLength", [ "length" => 10, "quantify" => 10 ] ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::minLength());
    }
}

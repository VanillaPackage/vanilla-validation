<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class SameLengthRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     * @covers Rentalhost\VanillaValidation\Rule\SameLengthRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\SameLengthRule::validateNegative
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
            [ "sameLength", [ 5 ], "hello", "success", [ "length" => 5, "quantify" => 5 ] ],

            2000 =>
            [ "sameLength", [], "hello", "fail:sameLength" ],
            [ "sameLength", [ 10 ], "hello", "fail:sameLength", [ "length" => 10, "quantify" => 10 ] ],
            [ "sameLength", [ 0 ], "hello", "fail:sameLength", [ "length" => 0, "quantify" => 0 ] ],
            [ "sameLength", [ -5 ], "hello", "fail:sameLength", [ "length" => -5, "quantify" => -5 ] ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::sameLength());
    }
}

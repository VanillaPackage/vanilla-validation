<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class EqualsRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     * @covers Rentalhost\VanillaValidation\Rule\EqualsRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\EqualsRule::validateNegative
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
            [ "equals", [ "hello" ], "hello" ],
            [ "equals", [ "hello", true ], "hello" ],
            [ "equals", [ "1" ], 1 ],
            [ "equals", [ "1", false ], 1 ],
            [ "equals", [ 1 ], "1" ],
            [ "equals", [ 1, true ], 1 ],

            2000 =>
            [ "equals", [], "hello", "fail:equals" ],
            [ "equals", [ "olleh" ], "hello", "fail:equals" ],
            [ "equals", [ 1, true ], "1", "fail:equals" ],
            [ "equals", [ "1", true ], 1, "fail:equals" ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::equals());
    }
}

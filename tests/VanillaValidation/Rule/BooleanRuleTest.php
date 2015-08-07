<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class BooleanRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     * @covers Rentalhost\VanillaValidation\Rule\BooleanRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\BooleanRule::validateNegative
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
            [ "boolean", [], true ],
            [ "boolean", [], false ],

            2000 =>
            [ "boolean", [], null, "fail:boolean" ],
            [ "boolean", [], 123, "fail:boolean" ],
            [ "boolean", [], [], "fail:boolean" ],
            [ "boolean", [], (object) [], "fail:boolean" ],
            [ "boolean", [], "abc", "fail:boolean" ],
            [ "boolean", [], 0, "fail:boolean" ],
            [ "boolean", [], 1, "fail:boolean" ],

            3000 =>
            [ "notBoolean", [], true, "fail:boolean.not" ],
            [ "notBoolean", [], false, "fail:boolean.not" ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::bool());
        $this->assertInstanceOf(ValidationChain::class, Validation::boolean());
    }
}

<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class StringRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     * @covers Rentalhost\VanillaValidation\Rule\StringRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\StringRule::validateNegative
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
            [ "string", [], "test" ],
            [ "string", [], "" ],
            [ "string", [], 0, "fail:string" ],
            [ "string", [], [], "fail:string" ],
            [ "string", [], false, "fail:string" ],
            [ "string", [], null, "fail:string" ],

            2000 =>
            [ "notString", [], "test", "fail:string.not" ],
            [ "notString", [], "", "fail:string.not" ],
            [ "notString", [], 0 ],
            [ "notString", [], [] ],
            [ "notString", [], false ],
            [ "notString", [], null ],
        ];
    }

    /**
     * Test rule directly.
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::string());
    }
}

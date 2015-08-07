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

            2000 =>
            [ "string", [], 0, "fail:string" ],
            [ "string", [], [], "fail:string" ],
            [ "string", [], false, "fail:string" ],
            [ "string", [], null, "fail:string" ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::string());
    }
}

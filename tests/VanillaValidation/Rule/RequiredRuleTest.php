<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

class RequiredRuleTest extends RuleTestCase
{
    /**
     * Test action.
     * @covers Rentalhost\VanillaValidation\Rule\RequiredRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\RequiredRule::validateNegative
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
            [ "required", [], "test" ],
            [ "required", [], 0, "fail:required" ],
            [ "required", [], [], "fail:required" ],
            [ "required", [], " ", "fail:required" ],
            [ "required", [], "", "fail:required" ],
            [ "required", [], false, "fail:required" ],
            [ "required", [], null, "fail:required" ],

            2000 =>
            [ "notRequired", [], "test" ],
            [ "notRequired", [], 0 ],
            [ "notRequired", [], [] ],
            [ "notRequired", [], " " ],
            [ "notRequired", [], "" ],
            [ "notRequired", [], false ],
            [ "notRequired", [], null ],
        ];
    }
}

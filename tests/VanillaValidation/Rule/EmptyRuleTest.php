<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

class EmptyRuleTest extends RuleTestCase
{
    /**
     * Test action.
     * @covers Rentalhost\VanillaValidation\Rule\EmptyRule::validate
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
            [ "empty", [], 0 ],
            [ "empty", [], [] ],
            [ "empty", [], "" ],
            [ "empty", [], false ],
            [ "empty", [], null ],
            [ "empty", [], "test", "fail:empty" ],
            [ "empty", [], " ", "fail:empty" ],

            2000 =>
            [ "notEmpty", [], 0, "fail:empty.not" ],
            [ "notEmpty", [], [], "fail:empty.not" ],
            [ "notEmpty", [], "", "fail:empty.not" ],
            [ "notEmpty", [], false, "fail:empty.not" ],
            [ "notEmpty", [], null, "fail:empty.not" ],
            [ "notEmpty", [], "test" ],
            [ "notEmpty", [], " " ],
        ];
    }
}

<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class EmptyRuleTest extends RuleTestCase
{
    /**
     * Test rule.
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

            2000 =>
            [ "empty", [], "test", "fail:empty" ],
            [ "empty", [], " ", "fail:empty" ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::emp());
    }
}

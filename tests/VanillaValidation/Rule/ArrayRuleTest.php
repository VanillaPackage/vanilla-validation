<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use ArrayIterator;
use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class ArrayRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     * @covers Rentalhost\VanillaValidation\Rule\ArrayRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\ArrayRule::validateNegative
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
            [ "array", [], [] ],
            [ "array", [], [ 1, 2, 3 ] ],
            [ "array", [], new ArrayIterator ],

            2000 =>
            [ "array", [], null, "fail:array" ],
            [ "array", [], 123, "fail:array" ],
            [ "array", [], (object) [], "fail:array" ],
            [ "array", [], false, "fail:array" ],
            [ "array", [], "abc", "fail:array" ],

            3000 =>
            [ "notArray", [], [], "fail:array.not" ],
            [ "notArray", [], [ 1, 2, 3 ], "fail:array.not" ],
            [ "notArray", [], new ArrayIterator, "fail:array.not" ],
        ];
    }

    /**
     * Test rule directly.
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::arr());
    }
}

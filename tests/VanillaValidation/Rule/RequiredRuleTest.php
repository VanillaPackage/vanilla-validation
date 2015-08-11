<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class RequiredRuleTest extends RuleTestCase
{
    /**
     * Test rule.
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

            2000 =>
            [ "required", [], 0, "fail:required" ],
            [ "required", [], [], "fail:required" ],
            [ "required", [], " ", "fail:required" ],
            [ "required", [], "", "fail:required" ],
            [ "required", [], false, "fail:required" ],
            [ "required", [], null, "fail:required" ],

            3000 =>
            [ "notRequired", [], "test" ],
            [ "notRequired", [], 0 ],
            [ "notRequired", [], [] ],
            [ "notRequired", [], " " ],
            [ "notRequired", [], "" ],
            [ "notRequired", [], false ],
            [ "notRequired", [], null ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::required());
    }

    /**
     * Test if rule breakable parameter works properly.
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::validate
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::validate
     * @covers Rentalhost\VanillaValidation\Rule\RequiredRule::validate
     * @return void
     */
    public function testBreakable()
    {
        $validation = Validation::required()->minLength(8)->validate("");

        $this->assertCount(2, $validation->getFails());

        $validation = Validation::required(true)->minLength(8)->validate("");

        $this->assertCount(1, $validation->getFails());
        $this->assertSame("required", $validation->getFails()[0]->rule->name);
    }
}

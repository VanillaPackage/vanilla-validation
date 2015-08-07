<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class EmailRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     * @covers Rentalhost\VanillaValidation\Rule\EmailRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\EmailRule::validateNegative
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
            [ "email", [], "test@test.com" ],
            [ "email", [], "mail+mail@test.com" ],
            [ "email", [], "mail.mail@subtest.test.com" ],
            [ "email", [], "a@a.a" ],

            2000 =>
            [ "email", [], "test@test", "fail:email" ],
            [ "email", [], "test", "fail:email" ],
            [ "email", [], "test@тест.рф", "fail:email" ],
            [ "email", [], "@test.com", "fail:email" ],
            [ "email", [], "mail@test@test.com", "fail:email" ],
            [ "email", [], "test.test@", "fail:email" ],
            [ "email", [], "test.@test.com", "fail:email" ],
            [ "email", [], "test@.test.com", "fail:email" ],
            [ "email", [], "test@test..com", "fail:email" ],
            [ "email", [], "test@test.com.", "fail:email" ],
            [ "email", [], ".test@test.com", "fail:email" ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::email());
    }
}

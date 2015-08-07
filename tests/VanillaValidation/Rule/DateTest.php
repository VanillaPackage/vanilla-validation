<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use DateTime;
use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class DateRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     * @covers Rentalhost\VanillaValidation\Rule\DateRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\DateRule::validateNegative
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
            [ "date", [], "today" ],
            [ "date", [], "now" ],
            [ "date", [], "2015-01-01" ],
            [ "date", [], "2015-02-30" ],
            [ "date", [], "2015-01-00" ],
            [ "date", [], new DateTime ],

            2000 =>
            [ "date", [], "invalid", "fail:date" ],
            [ "date", [], (object) [], "fail:date" ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::date());
    }
}

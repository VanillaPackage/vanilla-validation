<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class CNPJRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     * @covers Rentalhost\VanillaValidation\Rule\CNPJRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\CNPJRule::validateNegative
     * @covers Rentalhost\VanillaValidation\Rule\CNPJRule::calculateDigit
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
            [ "CNPJ", [], "38175021000110", "success", [ "digits" => "10", "expected" => "38175021000110" ] ],
            [ "CNPJ", [], "37550610000179", "success", [ "digits" => "79", "expected" => "37550610000179" ] ],
            [ "CNPJ", [], "12774546000189", "success", [ "digits" => "89", "expected" => "12774546000189" ] ],
            [ "CNPJ", [], "77456211000168", "success", [ "digits" => "68", "expected" => "77456211000168" ] ],
            [ "CNPJ", [], "02023077000102", "success", [ "digits" => "02", "expected" => "02023077000102" ] ],

            2000 =>
            [ "CNPJ", [], "38175021000177", "fail:cnpj", [ "digits" => "10", "expected" => "38175021000110" ] ],
            [ "CNPJ", [], "37550610000177", "fail:cnpj", [ "digits" => "79", "expected" => "37550610000179" ] ],
            [ "CNPJ", [], "12774546000177", "fail:cnpj", [ "digits" => "89", "expected" => "12774546000189" ] ],
            [ "CNPJ", [], "77456211000177", "fail:cnpj", [ "digits" => "68", "expected" => "77456211000168" ] ],
            [ "CNPJ", [], "02023077000177", "fail:cnpj", [ "digits" => "02", "expected" => "02023077000102" ] ],

            3000 =>
            [ "CNPJ", [], "abc", "fail:cnpj" ],
            [ "CNPJ", [], "1", "fail:cnpj" ],
            [ "CNPJ", [], "22", "fail:cnpj" ],
            [ "CNPJ", [], "123", "fail:cnpj" ],
            [ "CNPJ", [], "00000000000122", "fail:cnpj" ],
            [ "CNPJ", [], "00000000000000", "fail:cnpj" ],
            [ "CNPJ", [], "992999999999929384", "fail:cnpj" ],
            [ "CNPJ", [], "not38175021000110valid", "fail:cnpj" ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::CNPJ());
        $this->assertInstanceOf(ValidationChain::class, Validation::cnpj());
    }

    /**
     * Test intersect numbers with CNPJ.
     * @coversNothing
     * @return void
     */
    public function testWithIntersectNumbers()
    {
        $this->assertTrue(Validation::intersectNumbers()->CNPJ()->validate("38.175.021/0001-10")->isSuccess());
    }
}

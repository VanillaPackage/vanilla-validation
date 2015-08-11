<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class CPFRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     * @covers Rentalhost\VanillaValidation\Rule\CPFRule::validate
     * @covers Rentalhost\VanillaValidation\Rule\CPFRule::validateNegative
     * @covers Rentalhost\VanillaValidation\Rule\CPFRule::calculateDigit
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
            [ "CPF", [], "34244419888", "success", [ "digits" => "88", "expected" => "34244419888" ] ],
            [ "CPF", [], "35045261819", "success", [ "digits" => "19", "expected" => "35045261819" ] ],
            [ "CPF", [], "69331911840", "success", [ "digits" => "40", "expected" => "69331911840" ] ],
            [ "CPF", [], "36889255488", "success", [ "digits" => "88", "expected" => "36889255488" ] ],
            [ "CPF", [], "11598647644", "success", [ "digits" => "44", "expected" => "11598647644" ] ],
            [ "CPF", [], "86734718697", "success", [ "digits" => "97", "expected" => "86734718697" ] ],
            [ "CPF", [], "86223423284", "success", [ "digits" => "84", "expected" => "86223423284" ] ],
            [ "CPF", [], "24845408333", "success", [ "digits" => "33", "expected" => "24845408333" ] ],
            [ "CPF", [], "95574461102", "success", [ "digits" => "02", "expected" => "95574461102" ] ],

            2000 =>
            [ "CPF", [], "11122244405", "fail:CPF", [ "digits" => "01", "expected" => "11122244401" ] ],
            [ "CPF", [], "69331911040", "fail:CPF", [ "digits" => "92", "expected" => "69331911092" ] ],
            [ "CPF", [], "69811111100", "fail:CPF", [ "digits" => "03", "expected" => "69811111103" ] ],
            [ "CPF", [], "12345678900", "fail:CPF", [ "digits" => "09", "expected" => "12345678909" ] ],
            [ "CPF", [], "99299929384", "fail:CPF", [ "digits" => "60", "expected" => "99299929360" ] ],
            [ "CPF", [], "84434895894", "fail:CPF", [ "digits" => "85", "expected" => "84434895885" ] ],
            [ "CPF", [], "44242340000", "fail:CPF", [ "digits" => "28", "expected" => "44242340028" ] ],
            [ "CPF", [], "34244419878", "fail:CPF", [ "digits" => "88", "expected" => "34244419888" ] ],

            3000 =>
            [ "CPF", [], "abc", "fail:CPF" ],
            [ "CPF", [], "1", "fail:CPF" ],
            [ "CPF", [], "22", "fail:CPF" ],
            [ "CPF", [], "123", "fail:CPF" ],
            [ "CPF", [], "00000000011", "fail:CPF" ],
            [ "CPF", [], "00000000000", "fail:CPF" ],
            [ "CPF", [], "992999999999929384", "fail:CPF" ],
            [ "CPF", [], "not34244419888valid", "fail:CPF" ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::CPF());
        $this->assertInstanceOf(ValidationChain::class, Validation::cpf());
    }

    /**
     * Test intersect numbers with CPF.
     * @coversNothing
     * @return void
     */
    public function testWithIntersectNumbers()
    {
        $this->assertTrue(Validation::intersectNumbers()->CPF()->validate("342.444.198-88")->isSuccess());
    }
}

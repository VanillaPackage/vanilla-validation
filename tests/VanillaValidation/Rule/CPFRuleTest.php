<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class CPFRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class CPFRuleTest extends RuleTestCase
{
    /**
     * Test rule.
     *
     * @param string $name            Rule name.
     * @param array  $parameters      Rule parameters.
     * @param mixed  $input           Rule input.
     * @param string $expectedMessage Rule result expected message.
     * @param null   $expectedData    Rule result expected data.
     *
     * @covers       Rentalhost\VanillaValidation\Rule\CPFRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\CPFRule::validateNegative
     * @covers       Rentalhost\VanillaValidation\Rule\CPFRule::calculateDigit
     * @dataProvider dataRule
     */
    public function testRule($name, $parameters, $input, $expectedMessage = 'success', $expectedData = null)
    {
        parent::testRule($name, $parameters, $input, $expectedMessage, $expectedData);
    }

    /**
     * Rules data.
     */
    public function dataRule()
    {
        return [
            1000 =>
                [ 'CPF', [ ], '34244419888', 'success', [ 'digits' => '88', 'expected' => '34244419888' ] ],
            [ 'CPF', [ ], '35045261819', 'success', [ 'digits' => '19', 'expected' => '35045261819' ] ],
            [ 'CPF', [ ], '69331911840', 'success', [ 'digits' => '40', 'expected' => '69331911840' ] ],
            [ 'CPF', [ ], '36889255488', 'success', [ 'digits' => '88', 'expected' => '36889255488' ] ],
            [ 'CPF', [ ], '11598647644', 'success', [ 'digits' => '44', 'expected' => '11598647644' ] ],
            [ 'CPF', [ ], '86734718697', 'success', [ 'digits' => '97', 'expected' => '86734718697' ] ],
            [ 'CPF', [ ], '86223423284', 'success', [ 'digits' => '84', 'expected' => '86223423284' ] ],
            [ 'CPF', [ ], '24845408333', 'success', [ 'digits' => '33', 'expected' => '24845408333' ] ],
            [ 'CPF', [ ], '95574461102', 'success', [ 'digits' => '02', 'expected' => '95574461102' ] ],
            2000 =>
                [ 'CPF', [ ], '11122244405', 'fail:cpf', [ 'digits' => '01', 'expected' => '11122244401' ] ],
            [ 'CPF', [ ], '69331911040', 'fail:cpf', [ 'digits' => '92', 'expected' => '69331911092' ] ],
            [ 'CPF', [ ], '69811111100', 'fail:cpf', [ 'digits' => '03', 'expected' => '69811111103' ] ],
            [ 'CPF', [ ], '12345678900', 'fail:cpf', [ 'digits' => '09', 'expected' => '12345678909' ] ],
            [ 'CPF', [ ], '99299929384', 'fail:cpf', [ 'digits' => '60', 'expected' => '99299929360' ] ],
            [ 'CPF', [ ], '84434895894', 'fail:cpf', [ 'digits' => '85', 'expected' => '84434895885' ] ],
            [ 'CPF', [ ], '44242340000', 'fail:cpf', [ 'digits' => '28', 'expected' => '44242340028' ] ],
            [ 'CPF', [ ], '34244419878', 'fail:cpf', [ 'digits' => '88', 'expected' => '34244419888' ] ],
            3000 =>
                [ 'CPF', [ ], 'abc', 'fail:cpf' ],
            [ 'CPF', [ ], '1', 'fail:cpf' ],
            [ 'CPF', [ ], '22', 'fail:cpf' ],
            [ 'CPF', [ ], '123', 'fail:cpf' ],
            [ 'CPF', [ ], '00000000011', 'fail:cpf' ],
            [ 'CPF', [ ], '00000000000', 'fail:cpf' ],
            [ 'CPF', [ ], '992999999999929384', 'fail:cpf' ],
            [ 'CPF', [ ], 'not34244419888valid', 'fail:cpf' ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        /** @noinspection CallableReferenceNameMismatchInspection */
        static::assertInstanceOf(ValidationChain::class, Validation::CPF());
        static::assertInstanceOf(ValidationChain::class, Validation::cpf());
    }

    /**
     * Test intersect numbers with CPF.
     * @coversNothing
     * @return void
     */
    public function testWithIntersectNumbers()
    {
        static::assertTrue(Validation::intersectNumbers()->cpf()->validate('342.444.198-88')->isSuccess());
    }
}

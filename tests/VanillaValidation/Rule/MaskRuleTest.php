<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class MaskRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class MaskRuleTest extends RuleTestCase
{
    /**
     * Rules data.
     */
    public function dataRule()
    {
        return [
            1000 =>
                [ 'mask', [ '###.###.###-##' ], '000.111.222-33', 'success', [ 'expression' => '~^\d\d\d\.\d\d\d\.\d\d\d\-\d\d$~' ] ],
            [
                'mask',
                [ '##.###.###/####-##' ],
                '00.111.222/3333-44',
                'success',
                [ 'expression' => '~^\d\d\.\d\d\d\.\d\d\d/\d\d\d\d\-\d\d$~' ],
            ],
            [ 'mask', [ '#####-###' ], '00000-111', 'success', [ 'expression' => '~^\d\d\d\d\d\-\d\d\d$~' ] ],
            [ 'mask', [ '@@@' ], 'abc', 'success', [ 'expression' => '~^[a-zA-Z][a-zA-Z][a-zA-Z]$~' ] ],
            [ 'mask', [ '@@@###' ], 'abc123', 'success', [ 'expression' => '~^[a-zA-Z][a-zA-Z][a-zA-Z]\d\d\d$~' ] ],
            [ 'mask', [ 'abc123' ], 'abc123', 'success', [ 'expression' => '~^abc123$~' ] ],
            [ 'mask', [ 'aaaa1#3', [ 'a' => '[bc]' ] ], 'bccb123', 'success', [ 'expression' => '~^[bc][bc][bc][bc]1\d3$~' ] ],
            [ 'mask', [ '@@@###', [ '@' => null, '#' => null ] ], '@@@###', 'success', [ 'expression' => '~^@@@###$~' ] ],
            [ 'mask', [ 'dn', [ 'd' => '\d{3}', 'n' => '\d{9}' ] ], '021911112222', 'success', [ 'expression' => '~^\d{3}\d{9}$~' ] ],
            2000 =>
                [ 'mask', [ ], 'abc', 'fail:mask' ],
            [ 'mask', [ '###.###.###-##' ], '00011122233', 'fail:mask', [ 'expression' => '~^\d\d\d\.\d\d\d\.\d\d\d\-\d\d$~' ] ],
            [
                'mask',
                [ '##.###.###/####-##' ],
                '0011122233344',
                'fail:mask',
                [ 'expression' => '~^\d\d\.\d\d\d\.\d\d\d/\d\d\d\d\-\d\d$~' ],
            ],
            [ 'mask', [ '#####-###' ], '00000111', 'fail:mask', [ 'expression' => '~^\d\d\d\d\d\-\d\d\d$~' ] ],
            [ 'mask', [ '#####-###' ], ' 00000-111 ', 'fail:mask', [ 'expression' => '~^\d\d\d\d\d\-\d\d\d$~' ] ],
            [ 'mask', [ '#####-###', [ '#' => null ] ], '00000-111', 'fail:mask', [ 'expression' => '~^#####\-###$~' ] ],
        ];
    }
    
    /**
     * Test rule.
     *
     * @param string $name            Rule name.
     * @param array  $parameters      Rule parameters.
     * @param mixed  $input           Rule input.
     * @param string $expectedMessage Rule result expected message.
     * @param null   $expectedData    Rule result expected data.
     *
     * @covers       Rentalhost\VanillaValidation\Rule\MaskRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\MaskRule::validateNegative
     * @dataProvider dataRule
     */
    public function testRule($name, $parameters, $input, $expectedMessage = 'success', $expectedData = null)
    {
        parent::testRule($name, $parameters, $input, $expectedMessage, $expectedData);
    }
    
    /**
     * Test CPF with mask.
     * @coversNothing
     * @return void
     */
    public function testCPFMask()
    {
        $validation = Validation::mask('###.###.###-##')
            ->intersectNumbers()->cpf()
            ->mask('###########')->collect($afterAction)
            ->validate('342.444.198-88');
        
        static::assertTrue($validation->isSuccess());
        static::assertSame('34244419888', $afterAction);
    }
    
    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        static::assertInstanceOf(ValidationChain::class, Validation::mask('#-##'));
    }
}

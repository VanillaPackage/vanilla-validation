<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class RequiredRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class RequiredRuleTest extends RuleTestCase
{
    /**
     * Rules data.
     */
    public function dataRule()
    {
        return [
            1000 =>
                [ 'required', [ ], 'test' ],
            2000 =>
                [ 'required', [ ], 0, 'fail:required' ],
            [ 'required', [ ], [ ], 'fail:required' ],
            [ 'required', [ ], ' ', 'fail:required' ],
            [ 'required', [ ], '', 'fail:required' ],
            [ 'required', [ ], false, 'fail:required' ],
            [ 'required', [ ], null, 'fail:required' ],
            3000 =>
                [ 'notRequired', [ ], 'test' ],
            [ 'notRequired', [ ], 0 ],
            [ 'notRequired', [ ], [ ] ],
            [ 'notRequired', [ ], ' ' ],
            [ 'notRequired', [ ], '' ],
            [ 'notRequired', [ ], false ],
            [ 'notRequired', [ ], null ],
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
     * @covers       Rentalhost\VanillaValidation\Rule\RequiredRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\RequiredRule::validateNegative
     * @dataProvider dataRule
     */
    public function testRule($name, $parameters, $input, $expectedMessage = 'success', $expectedData = null)
    {
        parent::testRule($name, $parameters, $input, $expectedMessage, $expectedData);
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
        $validation = Validation::required(false)->minLength(8)->validate('');
        
        static::assertCount(2, $validation->getFails());
        
        $validation = Validation::required()->minLength(8)->validate('');
        
        static::assertCount(1, $validation->getFails());
        static::assertSame('required', $validation->getFails()[0]->rule->name);
    }
    
    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        static::assertInstanceOf(ValidationChain::class, Validation::required());
    }
}

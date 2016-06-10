<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class EmailRuleTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class EmailRuleTest extends RuleTestCase
{
    /**
     * Rules data.
     */
    public function dataRule()
    {
        return [
            1000 =>
                [ 'email', [ ], 'test@test.com' ],
            [ 'email', [ ], 'mail+mail@test.com' ],
            [ 'email', [ ], 'mail.mail@subtest.test.com' ],
            [ 'email', [ ], 'a@a.a' ],
            2000 =>
                [ 'email', [ ], 'test@test', 'fail:email' ],
            [ 'email', [ ], 'test', 'fail:email' ],
            [ 'email', [ ], 'test@тест.рф', 'fail:email' ],
            [ 'email', [ ], '@test.com', 'fail:email' ],
            [ 'email', [ ], 'mail@test@test.com', 'fail:email' ],
            [ 'email', [ ], 'test.test@', 'fail:email' ],
            [ 'email', [ ], 'test.@test.com', 'fail:email' ],
            [ 'email', [ ], 'test@.test.com', 'fail:email' ],
            [ 'email', [ ], 'test@test..com', 'fail:email' ],
            [ 'email', [ ], 'test@test.com.', 'fail:email' ],
            [ 'email', [ ], '.test@test.com', 'fail:email' ],
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
     * @covers       Rentalhost\VanillaValidation\Rule\EmailRule::validate
     * @covers       Rentalhost\VanillaValidation\Rule\EmailRule::validateNegative
     * @dataProvider dataRule
     */
    public function testRule($name, $parameters, $input, $expectedMessage = 'success', $expectedData = null)
    {
        parent::testRule($name, $parameters, $input, $expectedMessage, $expectedData);
    }

    /**
     * Test rule directly.
     * @coversNothing
     */
    public function testDirect()
    {
        static::assertInstanceOf(ValidationChain::class, Validation::email());
    }
}

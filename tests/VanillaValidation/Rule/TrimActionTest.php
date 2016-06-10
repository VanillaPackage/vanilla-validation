<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class TrimActionTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class TrimActionTest extends ActionTestCase
{
    /** @noinspection SenselessProxyMethodInspection */
    /**
     * Actions data.
     */
    public function dataAction()
    {
        return [
            [ 'trim', [ ], 'test', 'test' ],
            [ 'trim', [ ], ' test ', 'test' ],
            [ 'trim', [ '-' ], ' test ', ' test ' ],
            [ 'trim', [ '-' ], '-test-', 'test' ],
        ];
    }

    /**
     * Test action.
     *
     * @param string $name           Action name.
     * @param array  $parameters     Action parameters.
     * @param mixed  $input          Action input.
     * @param mixed  $expectedReturn Action expected return.
     *
     * @covers       Rentalhost\VanillaValidation\Rule\TrimAction::action
     * @dataProvider dataAction
     */
    public function testAction($name, $parameters, $input, $expectedReturn)
    {
        parent::testAction($name, $parameters, $input, $expectedReturn);
    }

    /**
     * Test rule directly.
     * @coversNothing
     */
    public function testDirect()
    {
        static::assertInstanceOf(ValidationChain::class, Validation::trim());
    }
}

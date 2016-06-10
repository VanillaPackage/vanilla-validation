<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

/**
 * Class IntersectNumbersActionTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class IntersectNumbersActionTest extends ActionTestCase
{
    /** @noinspection SenselessProxyMethodInspection */
    /**
     * Actions data.
     */
    public function dataAction()
    {
        return [
            [ 'intersectNumbers', [ ], 'test', '' ],
            [ 'intersectNumbers', [ ], '123', '123' ],
            [ 'intersectNumbers', [ ], '1.2.3', '123' ],
            [ 'intersectNumbers', [ ], 'Hello0', '0' ],
            [ 'intersectNumbers', [ ], '0.55', '055' ],
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
     * @covers       Rentalhost\VanillaValidation\Rule\IntersectNumbersAction::action
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
        static::assertInstanceOf(ValidationChain::class, Validation::intersectNumbers());
    }
}

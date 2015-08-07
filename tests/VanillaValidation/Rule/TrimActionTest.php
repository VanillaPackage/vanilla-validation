<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class TrimActionTest extends ActionTestCase
{
    /**
     * Test action.
     * @covers Rentalhost\VanillaValidation\Rule\TrimAction::action
     * @dataProvider dataAction
     */
    public function testAction($name, $parameters, $input, $expectedReturn)
    {
        return parent::testAction($name, $parameters, $input, $expectedReturn);
    }


    public function dataAction()
    {
        return [
            [ "trim", [], "test", "test" ],
            [ "trim", [], " test ", "test" ],
            [ "trim", [ "-" ], " test ", " test " ],
            [ "trim", [ "-" ], "-test-", "test" ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::trim());
    }
}

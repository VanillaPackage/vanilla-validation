<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class IntersectNumbersActionTest extends ActionTestCase
{
    /**
     * Test action.
     * @covers Rentalhost\VanillaValidation\Rule\IntersectNumbersAction::action
     * @dataProvider dataAction
     */
    public function testAction($name, $parameters, $input, $expectedReturn)
    {
        return parent::testAction($name, $parameters, $input, $expectedReturn);
    }

    public function dataAction()
    {
        return [
            [ "intersectNumbers", [], "test", "" ],
            [ "intersectNumbers", [], "123", "123" ],
            [ "intersectNumbers", [], "1.2.3", "123" ],
            [ "intersectNumbers", [], "Hello0", "0" ],
            [ "intersectNumbers", [], "0.55", "055" ],
        ];
    }

    /**
     * Test rule directly.
     * @coversNothing
     * @return void
     */
    public function testDirect()
    {
        $this->assertInstanceOf(ValidationChain::class, Validation::intersectNumbers());
    }
}

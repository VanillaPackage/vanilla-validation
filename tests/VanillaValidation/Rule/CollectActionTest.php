<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\Validation;
use Rentalhost\VanillaValidation\ValidationChain;

class CollectActionTest extends ActionTestCase
{
    /**
     * Test action.
     * @covers Rentalhost\VanillaValidation\Rule\CollectAction::action
     */
    public function testAction()
    {
        $validation = Validation::collect($beforeAction)->trim()->collect($afterAction)->validate(" hello ");

        $this->assertSame(" hello ", $beforeAction);
        $this->assertSame("hello", $afterAction);
    }

    /**
     * Not useful now.
     */
    public function dataAction()
    {
    }
}

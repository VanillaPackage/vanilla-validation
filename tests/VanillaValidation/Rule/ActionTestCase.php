<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\ValidationFieldRule;
use Rentalhost\VanillaValidation\ValidationRules;
use PHPUnit_Framework_TestCase;

abstract class ActionTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Test action.
     */
    public function testAction($name, $parameters, $input, $expectedReturn)
    {
        $fieldRule = new ValidationFieldRule($name, $parameters);

        $this->assertSame($expectedReturn, $fieldRule->validate($input));
    }

    /**
     * Actions data.
     */
    abstract public function dataAction();
}

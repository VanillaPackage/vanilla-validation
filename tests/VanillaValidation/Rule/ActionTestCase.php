<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\ValidationFieldRule;
use PHPUnit_Framework_TestCase;

/**
 * Class ActionTestCase
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
abstract class ActionTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Test action.
     *
     * @param string $name           Action name.
     * @param array  $parameters     Action parameters.
     * @param mixed  $input          Action input.
     * @param mixed  $expectedReturn Action return value.
     */
    public function testAction($name, $parameters, $input, $expectedReturn)
    {
        $fieldRule = new ValidationFieldRule($name, $parameters);

        static::assertSame($expectedReturn, $fieldRule->validate($input));
    }

    /**
     * Actions data.
     */
    abstract public function dataAction();
}

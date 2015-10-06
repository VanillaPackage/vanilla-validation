<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use PHPUnit_Framework_TestCase;
use Rentalhost\VanillaValidation\Validation;

/**
 * Class CollectActionTest
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
class CollectActionTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test collect action.
     * @covers Rentalhost\VanillaValidation\Rule\CollectAction::action
     */
    public function testAction()
    {
        Validation::collect($beforeAction)->trim()->collect($afterAction)->validate(' hello ');

        static::assertSame(' hello ', $beforeAction);
        static::assertSame('hello', $afterAction);
    }
}

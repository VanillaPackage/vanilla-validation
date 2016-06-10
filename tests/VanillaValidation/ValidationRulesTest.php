<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;

/**
 * Class ValidationRulesTest
 * @package Rentalhost\VanillaValidation
 */
class ValidationRulesTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationRules::__callStatic
     */
    public function testBasic()
    {
        static::assertTrue(ValidationRules::has('required'));
        static::assertFalse(ValidationRules::has('leftTrim'));

        ValidationRules::define('leftTrim', Test\LeftTrimAction::class);

        static::assertTrue(ValidationRules::has('leftTrim'));
    }

    /**
     * Test singleton.
     * @covers Rentalhost\VanillaValidation\ValidationRules::singleton
     */
    public function testSingleton()
    {
        $singleton = ValidationRules::singleton();

        static::assertTrue($singleton->has('required'));
    }
}

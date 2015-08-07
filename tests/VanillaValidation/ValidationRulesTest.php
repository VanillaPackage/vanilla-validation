<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaValidation\Result\Result;
use PHPUnit_Framework_TestCase;

class ValidationRulesTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationRules::__callStatic
     * @return void
     */
    public function testBasic()
    {
        $this->assertTrue(ValidationRules::has("required"));
        $this->assertFalse(ValidationRules::has("leftTrim"));

        ValidationRules::define("leftTrim", Test\LeftTrimAction::class);

        $this->assertTrue(ValidationRules::has("leftTrim"));
    }

    /**
     * Test singleton.
     * @covers Rentalhost\VanillaValidation\ValidationRules::singleton
     * @runInSeparateProcess
     * @return void
     */
    public function testSingleton()
    {
        $singleton = ValidationRules::singleton();

        $this->assertTrue($singleton->has("required"));
    }
}

<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaValidation\Result\Result;
use PHPUnit_Framework_TestCase;

class ValidationRulesSingletonTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::__construct
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::has
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::define
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::normalize
     * @return void
     */
    public function testBasic()
    {
        $rules = new ValidationRulesSingleton;

        $this->assertTrue($rules->has("required"));
        $this->assertFalse($rules->has("leftTrim"));

        $rules->define("leftTrim", Test\LeftTrimAction::class);

        $this->assertTrue($rules->has("leftTrim"));

        $this->assertNull($rules->normalize("inexistent"));
        $this->assertNull($rules->normalize("notRequired"));
        $this->assertSame("required", $rules->normalize("required"));
        $this->assertSame("boolean", $rules->normalize("bool"));
        $this->assertSame("boolean", $rules->normalize("boolean"));
    }

    /**
     * Test validate method.
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::validate
     * @return void
     */
    public function testValidate()
    {
        $rules = new ValidationRulesSingleton;

        $fieldRule = new ValidationFieldRule("trim");

        $this->assertSame("hello", $rules->validate($fieldRule, "hello"));
        $this->assertSame("hello", $rules->validate($fieldRule, " hello "));

        $fieldRule = new ValidationFieldRule("trim", [ "-" ]);

        $this->assertSame("hello", $rules->validate($fieldRule, "-hello-"));

        $fieldRule = new ValidationFieldRule("required");

        $this->assertTrue($rules->validate($fieldRule, "value")->isSuccess());
        $this->assertFalse($rules->validate($fieldRule, "")->isSuccess());
        $this->assertFalse($rules->validate($fieldRule, false)->isSuccess());
        $this->assertFalse($rules->validate($fieldRule, null)->isSuccess());

        $fieldRule = new ValidationFieldRule("notRequired");

        $this->assertTrue($rules->validate($fieldRule, "value")->isSuccess());
        $this->assertTrue($rules->validate($fieldRule, "")->isSuccess());
        $this->assertTrue($rules->validate($fieldRule, false)->isSuccess());
        $this->assertTrue($rules->validate($fieldRule, null)->isSuccess());
    }

    /**
     * Test RuleNotImplementedException.
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::validate
     * @return void
     */
    public function testRuleNotImplementedException()
    {
        $this->setExpectedException(Exception\RuleNotImplementedException::class);

        $fieldRule = new ValidationFieldRule("undefined");

        ValidationRules::validate($fieldRule, null);
    }
}

<?php

namespace Rentalhost\VanillaValidation\Result;

use Rentalhost\VanillaValidation\ValidationField;
use Rentalhost\VanillaValidation\ValidationFieldRule;
use PHPUnit_Framework_TestCase;

class SuccessTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic.
     * @covers Rentalhost\VanillaValidation\Result\Success::__construct
     * @covers Rentalhost\VanillaValidation\Result\Result::__construct
     */
    public function testBasic()
    {
        $resultSuccess = new Success;

        $this->assertInstanceOf(Result::class, $resultSuccess);
        $this->assertTrue($resultSuccess->isSuccess());
        $this->assertSame("success", $resultSuccess->getMessage());
        $this->assertSame([], $resultSuccess->getData());
    }

    /**
     * Test public properties.
     * @covers Rentalhost\VanillaValidation\Result\Result
     */
    public function testPublicProperties()
    {
        $this->assertClassHasAttribute("field", Success::class);
        $this->assertClassHasAttribute("value", Success::class);
        $this->assertClassHasAttribute("ruleIndex", Success::class);
        $this->assertClassHasAttribute("rule", Success::class);

        $validation = new ValidationField("name", "value");
        $validation->required();

        $validationResult = $validation->validate();
        $validationResultFirst = $validationResult->getResults()[0];

        $this->assertInstanceOf(Result::class, $validationResultFirst);
        $this->assertInstanceOf(ValidationField::class, $validationResultFirst->field);
        $this->assertInternalType("string", $validationResultFirst->field->name);
        $this->assertInternalType("string", $validationResultFirst->field->value);
        $this->assertInternalType("string", $validationResultFirst->value);
        $this->assertInternalType("integer", $validationResultFirst->ruleIndex);
        $this->assertEquals(new ValidationFieldRule("required"), $validationResultFirst->rule);
    }
}

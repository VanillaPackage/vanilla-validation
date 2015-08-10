<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaValidation\Result\Fail;
use Rentalhost\VanillaValidation\Result\Success;
use PHPUnit_Framework_TestCase;

class ValidationFieldTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationField::__construct
     * @covers Rentalhost\VanillaValidation\ValidationField::__call
     * @return void
     */
    public function testBasic()
    {
        $this->assertClassHasAttribute("name", ValidationField::class);
        $this->assertClassHasAttribute("value", ValidationField::class);
        $this->assertClassHasAttribute("rules", ValidationField::class);

        $field = new ValidationField("name");

        $this->assertSame("name", $field->name);
        $this->assertSame(null, $field->value);
        $this->assertInstanceOf(ValidationFieldRuleList::class, $field->rules);

        $field = new ValidationField("name", "value");

        $this->assertSame("name", $field->name);
        $this->assertSame("value", $field->value);

        $field->required();

        $fieldRules = new ValidationFieldRuleList;
        $fieldRules->add("required", null);

        $this->assertEquals($fieldRules, $field->rules);
    }

    /**
     * Test validate method.
     * @covers Rentalhost\VanillaValidation\ValidationField::validate
     * @return void
     */
    public function testValidate()
    {
        $field = new ValidationField("name", " ");
        $field->notEmpty()->trim()->notEmpty();

        $fieldResult = $field->validate();

        $resultSuccess = new Success;
        $resultSuccess->field = $field;
        $resultSuccess->value = " ";
        $resultSuccess->ruleIndex = 0;
        $resultSuccess->rule = new ValidationFieldRule("notEmpty");

        $resultFail = new Fail("fail:notEmpty");
        $resultFail->field = $field;
        $resultFail->value = "";
        $resultFail->ruleIndex = 2;
        $resultFail->rule = new ValidationFieldRule("notEmpty");

        $this->assertFalse($fieldResult->isSuccess());
        $this->assertSame("fail", $fieldResult->getMessage());
        $this->assertEquals([ $resultSuccess ], $fieldResult->getSuccesses());
        $this->assertEquals([ $resultSuccess, $resultFail ], $fieldResult->getResults());
        $this->assertEquals([ $resultFail ], $fieldResult->getFails());
    }

    /**
     * Test collect method.
     * @covers Rentalhost\VanillaValidation\ValidationField::collect
     */
    public function testCollect()
    {
        $field = new ValidationField("test", " hello ");
        $field->collect($beforeAction)->trim()->collect($afterAction);
        $field->validate();

        $this->assertSame(" hello ", $beforeAction);
        $this->assertSame("hello", $afterAction);
    }
}

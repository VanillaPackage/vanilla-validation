<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaValidation\Result\Fail;
use Rentalhost\VanillaValidation\Result\Success;
use PHPUnit_Framework_TestCase;

class ValidationFieldRuleListTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::__construct
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::add
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::all
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::clear
     * @return void
     */
    public function testBasic()
    {
        $ruleList = new ValidationFieldRuleList;
        $ruleList->add("name1");
        $ruleList->add("name2");
        $ruleList->add("name3", [ 1, 2, 3 ]);

        $rule1 = new ValidationFieldRule("name1");
        $rule2 = new ValidationFieldRule("name2");
        $rule3 = new ValidationFieldRule("name3", [ 1, 2, 3 ]);

        $this->assertEquals([ $rule1, $rule2, $rule3 ], $ruleList->all());

        $ruleList->clear();

        $this->assertEmpty($ruleList->all());
    }

    /**
     * Test validate method.
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::validate
     * @return void
     */
    public function testValidate()
    {
        $ruleList = new ValidationFieldRuleList;
        $ruleList->add("required");

        // Prepare.
        $ruleListResult = $ruleList->validate("value");

        $resultSuccess = new Success;
        $resultSuccess->value = "value";
        $resultSuccess->ruleIndex = 0;
        $resultSuccess->rule = new ValidationFieldRule("required");

        // Success test.
        $this->assertInstanceOf(ValidationResult::class, $ruleListResult);
        $this->assertTrue($ruleListResult->isSuccess());
        $this->assertSame("success", $ruleListResult->getMessage());
        $this->assertEquals([ $resultSuccess ], $ruleListResult->getResults());
        $this->assertEquals([ $resultSuccess ], $ruleListResult->getSuccesses());
        $this->assertEquals([], $ruleListResult->getFails());

        // Prepare.
        $ruleListResult = $ruleList->validate(null);

        $resultFail = new Fail("fail:required");
        $resultFail->value = null;
        $resultFail->ruleIndex = 0;
        $resultFail->rule = new ValidationFieldRule("required");

        // Fail test.
        $this->assertFalse($ruleListResult->isSuccess());
        $this->assertSame("fail", $ruleListResult->getMessage());
        $this->assertEquals([], $ruleListResult->getSuccesses());
        $this->assertEquals([ $resultFail ], $ruleListResult->getResults());
        $this->assertEquals([ $resultFail ], $ruleListResult->getFails());

        // Prepare.
        $ruleList->clear();
        $ruleList->add("trim");
        $ruleList->add("required");

        $ruleListResult = $ruleList->validate(" ");

        $resultFail = new Fail("fail:required");
        $resultFail->value = "";
        $resultFail->ruleIndex = 1;
        $resultFail->rule = new ValidationFieldRule("required");

        // Fail test, after trim.
        $this->assertFalse($ruleListResult->isSuccess());
        $this->assertSame("fail", $ruleListResult->getMessage());
        $this->assertEquals([], $ruleListResult->getSuccesses());
        $this->assertEquals([ $resultFail ], $ruleListResult->getResults());
        $this->assertEquals([ $resultFail ], $ruleListResult->getFails());

        // Prepare.
        $ruleList->clear();
        $ruleList->add("notEmpty");
        $ruleList->add("trim");

        $ruleListResult = $ruleList->validate(" ");

        $resultSuccess = new Success;
        $resultSuccess->value = " ";
        $resultSuccess->ruleIndex = 0;
        $resultSuccess->rule = new ValidationFieldRule("notEmpty");

        // Success test, before trim (no side-effect).
        $this->assertTrue($ruleListResult->isSuccess());
        $this->assertSame("success", $ruleListResult->getMessage());
        $this->assertEquals([ $resultSuccess ], $ruleListResult->getSuccesses());
        $this->assertEquals([ $resultSuccess ], $ruleListResult->getResults());
        $this->assertEquals([], $ruleListResult->getFails());

        // Prepare.
        $ruleList->clear();
        $ruleList->add("notEmpty");
        $ruleList->add("notEmpty");

        $ruleListResult = $ruleList->validate(" ");

        $resultSuccessFirst = new Success;
        $resultSuccessFirst->value = " ";
        $resultSuccessFirst->ruleIndex = 0;
        $resultSuccessFirst->rule = new ValidationFieldRule("notEmpty");

        $resultSuccessSecond = new Success;
        $resultSuccessSecond->value = " ";
        $resultSuccessSecond->ruleIndex = 1;
        $resultSuccessSecond->rule = new ValidationFieldRule("notEmpty");

        // Success test, double required, required will accept spaces string.
        $this->assertTrue($ruleListResult->isSuccess());
        $this->assertSame("success", $ruleListResult->getMessage());
        $this->assertEquals([ $resultSuccessFirst, $resultSuccessSecond ], $ruleListResult->getSuccesses());
        $this->assertEquals([ $resultSuccessFirst, $resultSuccessSecond ], $ruleListResult->getResults());
        $this->assertEquals([], $ruleListResult->getFails());

        // Prepare.
        $ruleListResult = $ruleList->validate(null);

        $resultFailFirst = new Fail("fail:notEmpty");
        $resultFailFirst->value = null;
        $resultFailFirst->ruleIndex = 0;
        $resultFailFirst->rule = new ValidationFieldRule("notEmpty");

        $resultFailSecond = new Fail("fail:notEmpty");
        $resultFailSecond->value = null;
        $resultFailSecond->ruleIndex = 1;
        $resultFailSecond->rule = new ValidationFieldRule("notEmpty");

        // Fail test, double required in empty value, twice fails.
        $this->assertFalse($ruleListResult->isSuccess());
        $this->assertSame("fail", $ruleListResult->getMessage());
        $this->assertEquals([], $ruleListResult->getSuccesses());
        $this->assertEquals([ $resultFailFirst, $resultFailSecond ], $ruleListResult->getResults());
        $this->assertEquals([ $resultFailFirst, $resultFailSecond ], $ruleListResult->getFails());

        // Prepare.
        $ruleList->clear();
        $ruleList->add("notEmpty");
        $ruleList->add("trim");
        $ruleList->add("notEmpty");

        $ruleListResult = $ruleList->validate(" ");

        $resultSuccess = new Success;
        $resultSuccess->value = " ";
        $resultSuccess->ruleIndex = 0;
        $resultSuccess->rule = new ValidationFieldRule("notEmpty");

        $resultFail = new Fail("fail:notEmpty");
        $resultFail->value = "";
        $resultFail->ruleIndex = 2;
        $resultFail->rule = new ValidationFieldRule("notEmpty");

        // Fail test, first required will pass, but second will fail because of trim.
        $this->assertFalse($ruleListResult->isSuccess());
        $this->assertSame("fail", $ruleListResult->getMessage());
        $this->assertEquals([ $resultSuccess ], $ruleListResult->getSuccesses());
        $this->assertEquals([ $resultSuccess, $resultFail ], $ruleListResult->getResults());
        $this->assertEquals([ $resultFail ], $ruleListResult->getFails());
    }
}

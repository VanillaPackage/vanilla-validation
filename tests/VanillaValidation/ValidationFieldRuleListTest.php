<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;
use Rentalhost\VanillaValidation\Result\Fail;
use Rentalhost\VanillaValidation\Result\FailBreakable;
use Rentalhost\VanillaValidation\Result\Success;

/**
 * Class ValidationFieldRuleListTest
 * @package Rentalhost\VanillaValidation
 */
class ValidationFieldRuleListTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::__construct
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::add
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::all
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::clear
     */
    public function testBasic()
    {
        $ruleList = new ValidationFieldRuleList;
        $ruleList->add('name1');
        $ruleList->add('name2');
        $ruleList->add('name3', [ 1, 2, 3 ]);

        $rule1 = new ValidationFieldRule('name1');
        $rule2 = new ValidationFieldRule('name2');
        $rule3 = new ValidationFieldRule('name3', [ 1, 2, 3 ]);

        static::assertEquals([ $rule1, $rule2, $rule3 ], $ruleList->all());

        $ruleList->clear();

        static::assertEmpty($ruleList->all());
    }

    /**
     * Test breakable rule.
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::validate
     * @covers Rentalhost\VanillaValidation\Rule\BreakableRule::validate
     */
    public function testBreakable()
    {
        $validation = Validation::maxLength(4)->minLength(8)->validate('hello');

        static::assertCount(2, $validation->getFails());

        $validation = Validation::maxLength(4)->breakable()->minLength(8)->validate('hello');

        static::assertCount(1, $validation->getFails());
        static::assertSame('maxLength', $validation->getFails()[0]->rule->name);

        $validation = Validation::maxLength(8)->breakable()->minLength(8)->validate('hello');

        static::assertSame('minLength', $validation->getFails()[0]->rule->name);
    }

    /**
     * Test nullable rule.
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::validate
     * @covers Rentalhost\VanillaValidation\Result\Nullable::__construct
     * @covers Rentalhost\VanillaValidation\Rule\NullableRule::validate
     */
    public function testNullable()
    {
        // Both are invalid, because both is not nullable ('hello' != empty).
        $validation = Validation::nullable()->minLength(8)->validate('hello');

        static::assertCount(1, $validation->getFails());

        $validation = Validation::minLength(8)->nullable()->validate('hello');

        static::assertCount(1, $validation->getFails());

        // But here, one first will works, because it check by nullable first,
        // then the next rule is ignored ('' == empty).
        $validation = Validation::nullable()->minLength(8)->validate('');

        static::assertCount(0, $validation->getFails());

        $validation = Validation::minLength(8)->nullable()->validate('');

        static::assertCount(1, $validation->getFails());
    }

    /**
     * Test validate method.
     * @covers Rentalhost\VanillaValidation\ValidationFieldRuleList::validate
     */
    public function testValidate()
    {
        $ruleList = new ValidationFieldRuleList;
        $ruleList->add('required', [ false ]);

        // Prepare.
        $ruleListResult = $ruleList->validate('value');

        $resultSuccess            = new Success;
        $resultSuccess->value     = 'value';
        $resultSuccess->ruleIndex = 0;
        $resultSuccess->rule      = new ValidationFieldRule('required', [ false ]);

        // Success test.
        static::assertInstanceOf(ValidationResult::class, $ruleListResult);
        static::assertTrue($ruleListResult->isSuccess());
        static::assertSame('success', $ruleListResult->getMessage());
        static::assertEquals([ $resultSuccess ], $ruleListResult->getResults());
        static::assertEquals([ $resultSuccess ], $ruleListResult->getSuccesses());
        static::assertEquals([ ], $ruleListResult->getFails());

        // Prepare.
        $ruleListResult = $ruleList->validate(null);

        $resultFail            = new Fail('fail:required');
        $resultFail->value     = null;
        $resultFail->ruleIndex = 0;
        $resultFail->rule      = new ValidationFieldRule('required', [ false ]);

        // Fail test.
        static::assertFalse($ruleListResult->isSuccess());
        static::assertSame('fail', $ruleListResult->getMessage());
        static::assertEquals([ ], $ruleListResult->getSuccesses());
        static::assertEquals([ $resultFail ], $ruleListResult->getResults());
        static::assertEquals([ $resultFail ], $ruleListResult->getFails());

        // Prepare.
        $ruleList->clear();
        $ruleList->add('trim');
        $ruleList->add('required');

        $ruleListResult = $ruleList->validate(' ');

        $resultFail            = new FailBreakable('fail:required');
        $resultFail->value     = '';
        $resultFail->ruleIndex = 1;
        $resultFail->rule      = new ValidationFieldRule('required');

        // Fail test, after trim.
        static::assertFalse($ruleListResult->isSuccess());
        static::assertSame('fail', $ruleListResult->getMessage());
        static::assertEquals([ ], $ruleListResult->getSuccesses());
        static::assertEquals([ $resultFail ], $ruleListResult->getResults());
        static::assertEquals([ $resultFail ], $ruleListResult->getFails());

        // Prepare.
        $ruleList->clear();
        $ruleList->add('notEmpty');
        $ruleList->add('trim');

        $ruleListResult = $ruleList->validate(' ');

        $resultSuccess            = new Success;
        $resultSuccess->value     = ' ';
        $resultSuccess->ruleIndex = 0;
        $resultSuccess->rule      = new ValidationFieldRule('notEmpty');

        // Success test, before trim (no side-effect).
        static::assertTrue($ruleListResult->isSuccess());
        static::assertSame('success', $ruleListResult->getMessage());
        static::assertEquals([ $resultSuccess ], $ruleListResult->getSuccesses());
        static::assertEquals([ $resultSuccess ], $ruleListResult->getResults());
        static::assertEquals([ ], $ruleListResult->getFails());

        // Prepare.
        $ruleList->clear();
        $ruleList->add('notEmpty');
        $ruleList->add('notEmpty');

        $ruleListResult = $ruleList->validate(' ');

        $resultSuccessFirst            = new Success;
        $resultSuccessFirst->value     = ' ';
        $resultSuccessFirst->ruleIndex = 0;
        $resultSuccessFirst->rule      = new ValidationFieldRule('notEmpty');

        $resultSuccessSecond            = new Success;
        $resultSuccessSecond->value     = ' ';
        $resultSuccessSecond->ruleIndex = 1;
        $resultSuccessSecond->rule      = new ValidationFieldRule('notEmpty');

        // Success test, double required, required will accept spaces string.
        static::assertTrue($ruleListResult->isSuccess());
        static::assertSame('success', $ruleListResult->getMessage());
        static::assertEquals([ $resultSuccessFirst, $resultSuccessSecond ], $ruleListResult->getSuccesses());
        static::assertEquals([ $resultSuccessFirst, $resultSuccessSecond ], $ruleListResult->getResults());
        static::assertEquals([ ], $ruleListResult->getFails());

        // Prepare.
        $ruleListResult = $ruleList->validate(null);

        $resultFailFirst            = new Fail('fail:notEmpty');
        $resultFailFirst->value     = null;
        $resultFailFirst->ruleIndex = 0;
        $resultFailFirst->rule      = new ValidationFieldRule('notEmpty');

        $resultFailSecond            = new Fail('fail:notEmpty');
        $resultFailSecond->value     = null;
        $resultFailSecond->ruleIndex = 1;
        $resultFailSecond->rule      = new ValidationFieldRule('notEmpty');

        // Fail test, double required in empty value, twice fails.
        static::assertFalse($ruleListResult->isSuccess());
        static::assertSame('fail', $ruleListResult->getMessage());
        static::assertEquals([ ], $ruleListResult->getSuccesses());
        static::assertEquals([ $resultFailFirst, $resultFailSecond ], $ruleListResult->getResults());
        static::assertEquals([ $resultFailFirst, $resultFailSecond ], $ruleListResult->getFails());

        // Prepare.
        $ruleList->clear();
        $ruleList->add('notEmpty');
        $ruleList->add('trim');
        $ruleList->add('notEmpty');

        $ruleListResult = $ruleList->validate(' ');

        $resultSuccess            = new Success;
        $resultSuccess->value     = ' ';
        $resultSuccess->ruleIndex = 0;
        $resultSuccess->rule      = new ValidationFieldRule('notEmpty');

        $resultFail            = new Fail('fail:notEmpty');
        $resultFail->value     = '';
        $resultFail->ruleIndex = 2;
        $resultFail->rule      = new ValidationFieldRule('notEmpty');

        // Fail test, first required will pass, but second will fail because of trim.
        static::assertFalse($ruleListResult->isSuccess());
        static::assertSame('fail', $ruleListResult->getMessage());
        static::assertEquals([ $resultSuccess ], $ruleListResult->getSuccesses());
        static::assertEquals([ $resultSuccess, $resultFail ], $ruleListResult->getResults());
        static::assertEquals([ $resultFail ], $ruleListResult->getFails());
    }
}

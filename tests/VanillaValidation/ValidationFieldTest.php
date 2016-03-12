<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;
use Rentalhost\VanillaValidation\Result\Fail;
use Rentalhost\VanillaValidation\Result\Success;

/**
 * Class ValidationFieldTest
 * @package Rentalhost\VanillaValidation
 */
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
        static::assertClassHasAttribute('name', ValidationField::class);
        static::assertClassHasAttribute('value', ValidationField::class);
        static::assertClassHasAttribute('rules', ValidationField::class);

        $field = new ValidationField('name');

        static::assertSame('name', $field->name);
        static::assertSame(null, $field->value);
        static::assertInstanceOf(ValidationFieldRuleList::class, $field->rules);

        $field = new ValidationField('name', 'value');

        static::assertSame('name', $field->name);
        static::assertSame('value', $field->value);

        $field->required();

        $fieldRules = new ValidationFieldRuleList;
        $fieldRules->add('required', null);

        static::assertEquals($fieldRules, $field->rules);
    }

    /**
     * Test collect method.
     * @covers Rentalhost\VanillaValidation\ValidationField::collect
     */
    public function testCollect()
    {
        $field = new ValidationField('test', ' hello ');
        $field->collect($beforeAction)->trim()->collect($afterAction);
        $field->validate();

        static::assertSame(' hello ', $beforeAction);
        static::assertSame('hello', $afterAction);
    }

    /**
     * Test field with data.
     * @coversNothing
     */
    public function testFieldWithData()
    {
        $validationField = new ValidationField(null, null, true);
        $validationField->required();

        $validationResult = $validationField->validate();
        
        static::assertTrue($validationResult->getFails()[0]->field->data);
    }

    /**
     * Test validate method.
     * @covers Rentalhost\VanillaValidation\ValidationField::validate
     * @return void
     */
    public function testValidate()
    {
        $field = new ValidationField('name', ' ');
        $field->notEmpty()->trim()->notEmpty();

        $fieldResult = $field->validate();

        $resultSuccess            = new Success;
        $resultSuccess->field     = $field;
        $resultSuccess->value     = ' ';
        $resultSuccess->ruleIndex = 0;
        $resultSuccess->rule      = new ValidationFieldRule('notEmpty');

        $resultFail            = new Fail('fail:notEmpty');
        $resultFail->field     = $field;
        $resultFail->value     = '';
        $resultFail->ruleIndex = 2;
        $resultFail->rule      = new ValidationFieldRule('notEmpty');

        static::assertFalse($fieldResult->isSuccess());
        static::assertSame('fail', $fieldResult->getMessage());
        static::assertEquals([ $resultSuccess ], $fieldResult->getSuccesses());
        static::assertEquals([ $resultSuccess, $resultFail ], $fieldResult->getResults());
        static::assertEquals([ $resultFail ], $fieldResult->getFails());
    }
}

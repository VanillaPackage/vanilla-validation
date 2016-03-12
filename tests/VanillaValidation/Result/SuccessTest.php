<?php

namespace Rentalhost\VanillaValidation\Result;

use PHPUnit_Framework_TestCase;
use Rentalhost\VanillaValidation\ValidationField;
use Rentalhost\VanillaValidation\ValidationFieldRule;

/**
 * Class SuccessTest
 * @package Rentalhost\VanillaValidation\Result
 */
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
        
        static::assertInstanceOf(Result::class, $resultSuccess);
        static::assertTrue($resultSuccess->isSuccess());
        static::assertSame('success', $resultSuccess->getMessage());
        static::assertSame([ ], $resultSuccess->getData());
    }
    
    /**
     * Test public properties.
     * @covers Rentalhost\VanillaValidation\Result\Result
     */
    public function testPublicProperties()
    {
        static::assertClassHasAttribute('field', Success::class);
        static::assertClassHasAttribute('value', Success::class);
        static::assertClassHasAttribute('ruleIndex', Success::class);
        static::assertClassHasAttribute('rule', Success::class);
        
        $validation = new ValidationField('name', 'value');
        $validation->required();
        
        $validationResult      = $validation->validate();
        $validationResultFirst = $validationResult->getResults()[0];
        
        static::assertInstanceOf(Result::class, $validationResultFirst);
        static::assertInstanceOf(ValidationField::class, $validationResultFirst->field);
        static::assertInternalType('string', $validationResultFirst->field->name);
        static::assertInternalType('string', $validationResultFirst->field->value);
        static::assertInternalType('string', $validationResultFirst->value);
        static::assertInternalType('integer', $validationResultFirst->ruleIndex);
        static::assertEquals(new ValidationFieldRule('required'), $validationResultFirst->rule);
    }
}

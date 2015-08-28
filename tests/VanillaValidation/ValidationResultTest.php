<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaValidation\Result\Fail;
use Rentalhost\VanillaValidation\Result\Success;
use PHPUnit_Framework_TestCase;

/**
 * Class ValidationResultTest
 * @package Rentalhost\VanillaValidation
 */
class ValidationResultTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic.
     * @covers Rentalhost\VanillaValidation\ValidationResult::__construct
     * @covers Rentalhost\VanillaValidation\ValidationResult::getSuccesses
     * @covers Rentalhost\VanillaValidation\ValidationResult::getFails
     * @covers Rentalhost\VanillaValidation\ValidationResult::getResults
     * @covers Rentalhost\VanillaValidation\ValidationResult::getResultsFiltered
     */
    public function testBasic()
    {
        $validationResult = new ValidationResult(true, 'success');
        static::assertInstanceOf(ValidationResult::class, $validationResult);

        static::assertCount(0, $validationResult->getResults());
        static::assertCount(0, $validationResult->getSuccesses());
        static::assertCount(0, $validationResult->getFails());

        // Success.
        $validationResult = new ValidationResult(true, 'success', [ new Success ]);

        static::assertCount(1, $validationResult->getResults());
        static::assertCount(1, $validationResult->getSuccesses());
        static::assertCount(0, $validationResult->getFails());

        // Fail.
        $validationResult = new ValidationResult(true, 'fail', [ new Fail('fail:message') ]);

        static::assertCount(1, $validationResult->getResults());
        static::assertCount(0, $validationResult->getSuccesses());
        static::assertCount(1, $validationResult->getFails());

        // Mixed.
        $validationResult = new ValidationResult(true, 'fail', [ new Success, new Fail('fail:message') ]);

        static::assertCount(2, $validationResult->getResults());
        static::assertCount(1, $validationResult->getSuccesses());
        static::assertCount(1, $validationResult->getFails());
    }
}

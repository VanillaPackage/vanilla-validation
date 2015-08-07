<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;

class ValidationTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\Validation::__construct
     * @covers Rentalhost\VanillaValidation\Validation::__clone
     * @covers Rentalhost\VanillaValidation\Validation::field
     * @covers Rentalhost\VanillaValidation\Validation::validate
     * @covers Rentalhost\VanillaValidation\Validation::overwriteWith
     * @covers Rentalhost\VanillaValidation\Validation::test
     * @covers Rentalhost\VanillaValidation\Validation::testWith
     * @return void
     */
    public function testBasic()
    {
        $validation = new Validation;
        $validation->field("username", "user")->required()->string();
        $validation->field("password", "pass")->required()->string();

        $validationResult = $validation->validate();

        // Default validation test.
        $this->assertInstanceOf(ValidationResult::class, $validationResult);
        $this->assertTrue($validationResult->isSuccess());
        $this->assertCount(0, $validationResult->getFails());
        $this->assertCount(4, $validationResult->getSuccesses());

        // Success test.
        $this->assertTrue($validation->test());
        $this->assertTrue($validation->test($validationResult));

        $this->assertInstanceOf(ValidationResult::class, $validationResult);
        $this->assertTrue($validationResult->isSuccess());
        $this->assertCount(0, $validationResult->getFails());
        $this->assertCount(4, $validationResult->getSuccesses());

        // Fail.
        $validationResult = $validation->validate([ "username" => null ]);

        $this->assertFalse($validationResult->isSuccess());
        $this->assertCount(2, $validationResult->getFails());
        $this->assertCount(2, $validationResult->getSuccesses());

        // Reference test (again success).
        $this->assertTrue($validation->test());
        $this->assertTrue($validation->test($validationResult));

        $this->assertTrue($validationResult->isSuccess());
        $this->assertCount(0, $validationResult->getFails());
        $this->assertCount(4, $validationResult->getSuccesses());

        // Reference test (now fail).
        $this->assertFalse($validation->testWith([ "username" => null ]));
        $this->assertFalse($validation->testWith([ "username" => null ], $validationResult));

        $this->assertFalse($validationResult->isSuccess());
        $this->assertCount(2, $validationResult->getFails());
        $this->assertCount(2, $validationResult->getSuccesses());
    }

    /**
     * Test static/chain method.
     * @covers Rentalhost\VanillaValidation\Validation::__callStatic
     * @return void
     */
    public function testStatic()
    {
        $this->assertTrue(Validation::required()->string()->validate("test")->isSuccess());
    }
}

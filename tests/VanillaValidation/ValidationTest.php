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

    /**
     * Test collect method.
     * @covers Rentalhost\VanillaValidation\Validation::collect
     * @return void
     */
    public function testCollect()
    {
        $validation = Validation::collect($beforeAction)->trim()->collect($afterAction)->validate(" hello ");

        $this->assertSame(" hello ", $beforeAction);
        $this->assertSame("hello", $afterAction);

        // Pre-definition of values.
        $validation = new Validation;
        $validation->field("name1", " hello ")->collect($beforeAction1)->trim()->collect($afterAction1);
        $validation->field("name2", " hello ")->collect($beforeAction2)->trim()->collect($afterAction2);

        $this->assertNull($beforeAction1);
        $this->assertNull($beforeAction2);
        $this->assertNull($afterAction1);
        $this->assertNull($afterAction2);

        $validation->validate();

        $this->assertSame(" hello ", $beforeAction1);
        $this->assertSame(" hello ", $beforeAction2);
        $this->assertSame("hello", $afterAction1);
        $this->assertSame("hello", $afterAction2);

        unset($beforeAction1, $beforeAction2, $afterAction1, $afterAction2);

        // Post-definition of values.
        $validation = new Validation;
        $validation->field("name1")->collect($beforeAction1)->trim()->collect($afterAction1);
        $validation->field("name2")->collect($beforeAction2)->trim()->collect($afterAction2);

        $this->assertNull($beforeAction1);
        $this->assertNull($beforeAction2);
        $this->assertNull($afterAction1);
        $this->assertNull($afterAction2);

        $validation->validate([
            "name1" => " hello ",
            "name2" => " hello ",
        ]);

        $this->assertSame(" hello ", $beforeAction1);
        $this->assertSame(" hello ", $beforeAction2);
        $this->assertSame("hello", $afterAction1);
        $this->assertSame("hello", $afterAction2);
    }

    /**
     * Test option method.
     * @covers Rentalhost\VanillaValidation\Validation::option
     * @covers Rentalhost\VanillaValidation\Validation::getEventListener
     * @runInSeparateProcess
     * @return void
     */
    public function testOption()
    {
        $defaultLocale = Validation::option("locale");

        $this->assertNotEmpty($defaultLocale);

        Validation::option("locale", null);

        $this->assertNull(Validation::option("locale"));

        Validation::option("locale", "pt-BR");

        $this->assertSame("pt-BR", Validation::option("locale"));

        $this->assertNull(Validation::option("unexistentOption"));

        Validation::option("unexistentOption", "value");

        $this->assertNull(Validation::option("unexistentOption"));

        Validation::option("locale", $defaultLocale);
    }
}

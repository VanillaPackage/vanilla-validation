<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;

/**
 * Class ValidationTest
 * @package Rentalhost\VanillaValidation
 */
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
     */
    public function testBasic()
    {
        $validation = new Validation;
        $validation->field('username', 'user')->required(false)->string();
        $validation->field('password', 'pass')->required(false)->string();

        $validationResult = $validation->validate();

        // Default validation test.
        static::assertInstanceOf(ValidationResult::class, $validationResult);
        static::assertTrue($validationResult->isSuccess());
        static::assertCount(0, $validationResult->getFails());
        static::assertCount(4, $validationResult->getSuccesses());

        // Success test.
        static::assertTrue($validation->test());
        static::assertTrue($validation->test($validationResult));

        static::assertInstanceOf(ValidationResult::class, $validationResult);
        static::assertTrue($validationResult->isSuccess());
        static::assertCount(0, $validationResult->getFails());
        static::assertCount(4, $validationResult->getSuccesses());

        // Fail.
        $validationResult = $validation->validate([ 'username' => null ]);

        static::assertFalse($validationResult->isSuccess());
        static::assertCount(2, $validationResult->getFails());
        static::assertCount(2, $validationResult->getSuccesses());

        // Reference test (again success).
        static::assertTrue($validation->test());
        static::assertTrue($validation->test($validationResult));

        static::assertTrue($validationResult->isSuccess());
        static::assertCount(0, $validationResult->getFails());
        static::assertCount(4, $validationResult->getSuccesses());

        // Reference test (now fail).
        static::assertFalse($validation->testWith([ 'username' => null ]));
        static::assertFalse($validation->testWith([ 'username' => null ], $validationResult));

        static::assertFalse($validationResult->isSuccess());
        static::assertCount(2, $validationResult->getFails());
        static::assertCount(2, $validationResult->getSuccesses());
    }

    /**
     * Test collect method.
     * @covers Rentalhost\VanillaValidation\Validation::collect
     */
    public function testCollect()
    {
        Validation::collect($beforeAction)->trim()->collect($afterAction)->validate(' hello ');

        static::assertSame(' hello ', $beforeAction);
        static::assertSame('hello', $afterAction);

        // Pre-definition of values.
        $validation = new Validation;
        $validation->field('name1', ' hello ')->collect($beforeAction1)->trim()->collect($afterAction1);
        $validation->field('name2', ' hello ')->collect($beforeAction2)->trim()->collect($afterAction2);

        static::assertNull($beforeAction1);
        static::assertNull($beforeAction2);
        static::assertNull($afterAction1);
        static::assertNull($afterAction2);

        $validation->validate();

        static::assertSame(' hello ', $beforeAction1);
        static::assertSame(' hello ', $beforeAction2);
        static::assertSame('hello', $afterAction1);
        static::assertSame('hello', $afterAction2);

        unset( $beforeAction1, $beforeAction2, $afterAction1, $afterAction2 );

        // Post-definition of values.
        $validation = new Validation;
        $validation->field('name1')->collect($beforeAction1)->trim()->collect($afterAction1);
        $validation->field('name2')->collect($beforeAction2)->trim()->collect($afterAction2);

        static::assertNull($beforeAction1);
        static::assertNull($beforeAction2);
        static::assertNull($afterAction1);
        static::assertNull($afterAction2);

        $validation->validate([
            'name1' => ' hello ',
            'name2' => ' hello ',
        ]);

        static::assertSame(' hello ', $beforeAction1);
        static::assertSame(' hello ', $beforeAction2);
        static::assertSame('hello', $afterAction1);
        static::assertSame('hello', $afterAction2);
    }

    /**
     * Test field with data.
     * @coversNothing
     */
    public function testFieldWithData()
    {
        $validation = new Validation;
        $validation->field(null, null, true)->required();

        $validationResult = $validation->validate();

        static::assertTrue($validationResult->getFails()[0]->field->data);
    }

    /**
     * Test option method.
     * @covers Rentalhost\VanillaValidation\Validation::option
     */
    public function testOption()
    {
        $defaultLocale = Validation::option('locale');

        static::assertNotEmpty($defaultLocale);

        Validation::option('locale', null);

        static::assertNull(Validation::option('locale'));

        Validation::option('locale', 'pt-BR');

        static::assertSame('pt-BR', Validation::option('locale'));

        static::assertNull(Validation::option('unexistentOption'));

        Validation::option('unexistentOption', 'value');

        static::assertNull(Validation::option('unexistentOption'));

        Validation::option('locale', $defaultLocale);
    }

    /**
     * Test static/chain method.
     * @covers Rentalhost\VanillaValidation\Validation::__callStatic
     */
    public function testStatic()
    {
        static::assertTrue(Validation::required()->string()->validate('test')->isSuccess());
    }
}

<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;

/**
 * Class ValidationFieldRuleTest
 * @package Rentalhost\VanillaValidation
 */
class ValidationFieldRuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationFieldRule::__construct
     * @return void
     */
    public function testBasic()
    {
        static::assertClassHasAttribute('name', ValidationFieldRule::class);
        static::assertClassHasAttribute('parameters', ValidationFieldRule::class);
        static::assertClassHasAttribute('negative', ValidationFieldRule::class);

        $fieldRule = new ValidationFieldRule('name');

        static::assertSame('name', $fieldRule->name);
        static::assertSame('name', $fieldRule->originalName);
        static::assertSame([ ], $fieldRule->parameters);
        static::assertNull($fieldRule->negative);

        $fieldRule = new ValidationFieldRule('nameWillNotBeLowercase');

        static::assertSame('nameWillNotBeLowercase', $fieldRule->name);

        $fieldRule = new ValidationFieldRule('notName');

        static::assertTrue($fieldRule->negative);
        static::assertSame('name', $fieldRule->name);
        static::assertSame('notName', $fieldRule->originalName);

        $fieldRule = new ValidationFieldRule('NotWillBeNegative');

        static::assertNull($fieldRule->negative);
        static::assertSame('NotWillBeNegative', $fieldRule->name);
        static::assertSame('NotWillBeNegative', $fieldRule->originalName);

        $fieldRule = new ValidationFieldRule('notwillbenegative');

        static::assertNull($fieldRule->negative);
        static::assertSame('notwillbenegative', $fieldRule->name);
        static::assertSame('notwillbenegative', $fieldRule->originalName);

        $fieldRule = new ValidationFieldRule('name', [ 1, 2, 3 ]);

        static::assertSame([ 1, 2, 3 ], $fieldRule->parameters);
    }

    /**
     * Test validate method.
     * @covers Rentalhost\VanillaValidation\ValidationFieldRule::validate
     * @return void
     */
    public function testValidate()
    {
        $fieldRule = new ValidationFieldRule('required');

        static::assertTrue($fieldRule->validate('hello')->isSuccess());
        static::assertFalse($fieldRule->validate('')->isSuccess());
    }
}

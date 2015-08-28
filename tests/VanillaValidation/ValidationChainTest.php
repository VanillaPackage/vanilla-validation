<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;

/**
 * Class ValidationChainTest
 * @package Rentalhost\VanillaValidation
 */
class ValidationChainTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationChain::__construct
     * @covers Rentalhost\VanillaValidation\ValidationChain::__call
     * @covers Rentalhost\VanillaValidation\ValidationChain::validate
     * @return void
     */
    public function testBasic()
    {
        static::assertClassHasAttribute('rules', ValidationChain::class);

        $chain = new ValidationChain;

        static::assertTrue($chain->notEmpty()->trim()->validate(' ')->isSuccess());

        $chain = new ValidationChain;

        static::assertFalse($chain->required()->validate(' ')->isSuccess());

        $chain = new ValidationChain;

        static::assertTrue($chain->required()->string()->validate('hello')->isSuccess());
        static::assertFalse($chain->required()->string()->validate(123)->isSuccess());
        static::assertFalse($chain->required()->string()->validate(null)->isSuccess());
    }

    /**
     * Test collect method.
     * @covers Rentalhost\VanillaValidation\ValidationChain::collect
     * @return void
     */
    public function testCollect()
    {
        Validation::collect($beforeAction)->trim()->collect($afterAction)->validate(' hello ');

        static::assertSame(' hello ', $beforeAction);
        static::assertSame('hello', $afterAction);
    }
}

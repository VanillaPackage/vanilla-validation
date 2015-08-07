<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaValidation\Result\Fail;
use Rentalhost\VanillaValidation\Result\Success;
use PHPUnit_Framework_TestCase;

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
        $this->assertClassHasAttribute("rules", ValidationChain::class);

        $chain = new ValidationChain;

        $this->assertTrue($chain->notEmpty()->trim()->validate(" ")->isSuccess());

        $chain = new ValidationChain;

        $this->assertFalse($chain->required()->validate(" ")->isSuccess());

        $chain = new ValidationChain;

        $this->assertTrue($chain->required()->string()->validate("hello")->isSuccess());
        $this->assertFalse($chain->required()->string()->validate(123)->isSuccess());
        $this->assertFalse($chain->required()->string()->validate(null)->isSuccess());
    }
}

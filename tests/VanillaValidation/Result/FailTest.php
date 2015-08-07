<?php

namespace Rentalhost\VanillaValidation\Result;

use PHPUnit_Framework_TestCase;

class FailTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic.
     * @covers Rentalhost\VanillaValidation\Result\Fail::__construct
     * @covers Rentalhost\VanillaValidation\Result\Result::__construct
     */
    public function testBasic()
    {
        $resultFail = new Fail("fail:message");

        $this->assertInstanceOf(Result::class, $resultFail);
        $this->assertFalse($resultFail->isSuccess());
        $this->assertSame("fail:message", $resultFail->getMessage());
        $this->assertSame([], $resultFail->getData());
    }
}

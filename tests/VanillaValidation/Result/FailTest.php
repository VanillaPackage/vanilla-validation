<?php

namespace Rentalhost\VanillaValidation\Result;

use Rentalhost\VanillaValidation\Validation;
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

    /**
     * Test locale.
     * @covers Rentalhost\VanillaValidation\Result\Fail::getLocalized
     */
    public function testLocale()
    {
        $optionLocale = Validation::option("locale");

        // Valid.
        Validation::option("locale", [ "pt-BR" ]);

        $validation = Validation::required()->validate("");

        $this->assertCount(1, $validation->getFails());

        $validationFail = $validation->getFails()[0];

        $this->assertSame("o campo é obrigatório", $validationFail->getLocalized());

        Validation::option("locale", "pt-BR");

        $this->assertSame("o campo é obrigatório", $validationFail->getLocalized());

        Validation::option("locale", [ "unknow", "pt-BR" ]);

        $this->assertSame("o campo é obrigatório", $validationFail->getLocalized());

        // Fail.
        Validation::option("locale", [ "unknow" ]);

        $this->assertSame("fail:required", $validationFail->getLocalized());

        Validation::option("locale", "unknow");

        $this->assertSame("fail:required", $validationFail->getLocalized());

        Validation::option("locale", $optionLocale);
    }
}

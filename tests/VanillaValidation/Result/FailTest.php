<?php

namespace Rentalhost\VanillaValidation\Result;

use Rentalhost\VanillaValidation\Validation;
use PHPUnit_Framework_TestCase;

/**
 * Class FailTest
 * @package Rentalhost\VanillaValidation\Result
 */
class FailTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic.
     * @covers Rentalhost\VanillaValidation\Result\Fail::__construct
     * @covers Rentalhost\VanillaValidation\Result\Result::__construct
     */
    public function testBasic()
    {
        $resultFail = new Fail('fail:message');

        static::assertInstanceOf(Result::class, $resultFail);
        static::assertFalse($resultFail->isSuccess());
        static::assertSame('fail:message', $resultFail->getMessage());
        static::assertSame([ ], $resultFail->getData());
    }

    /**
     * Test locale.
     * @covers Rentalhost\VanillaValidation\Result\Fail::getLocalized
     */
    public function testLocale()
    {
        $optionLocale = Validation::option('locale');

        // Valid.
        Validation::option('locale', [ 'pt-BR' ]);

        $validation = Validation::required()->validate('');

        static::assertCount(1, $validation->getFails());

        $validationFail = $validation->getFails()[0];

        static::assertSame('o campo é obrigatório', $validationFail->getLocalized());

        Validation::option('locale', 'pt-BR');

        static::assertSame('o campo é obrigatório', $validationFail->getLocalized());

        Validation::option('locale', [ 'unknow', 'pt-BR' ]);

        static::assertSame('o campo é obrigatório', $validationFail->getLocalized());

        // Fail.
        Validation::option('locale', [ 'unknow' ]);

        static::assertSame('fail:required', $validationFail->getLocalized());

        Validation::option('locale', 'unknow');

        static::assertSame('fail:required', $validationFail->getLocalized());

        Validation::option('locale', $optionLocale);
    }
}

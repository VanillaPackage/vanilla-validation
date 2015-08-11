<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;

class ValidationLocalizeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationLocalize::__construct
     * @covers Rentalhost\VanillaValidation\ValidationLocalize::singleton
     * @runInSeparateProcess
     * @return void
     */
    public function testSingleton()
    {
        $singleton = ValidationLocalize::singleton();

        $this->assertInstanceOf(ValidationLocalize::class, $singleton);

        $singletonCached = ValidationLocalize::singleton();

        $this->assertInstanceOf(ValidationLocalize::class, $singletonCached);
    }

    /**
     * Test translateFail method.
     * @covers Rentalhost\VanillaValidation\ValidationLocalize::translateFail
     * @covers Rentalhost\VanillaValidation\ValidationLocalize::maskKey
     * @covers Rentalhost\VanillaValidation\ValidationLocalize::configureLocale
     * @return void
     */
    public function testTranslateFail()
    {
        Validation::option("locale", "pt-BR");

        $validation = new Validation;
        $validation->field("username", "")->required();
        $validationFails = $validation->validate()->getFails();

        $this->assertSame('o campo "username" é obrigatório', $validationFails[0]->getLocalized());

        $validationFails = Validation::required()->validate("")->getFails();

        $this->assertSame('o campo é obrigatório', $validationFails[0]->getLocalized());

        Validation::option("locale", [ "unknow", "pt-BR", "en" ]);

        $validationFails = Validation::cpf()->validate("11122244405")->getFails();

        $this->assertSame('o campo deve ser um CPF', $validationFails[0]->getLocalized());
    }
}

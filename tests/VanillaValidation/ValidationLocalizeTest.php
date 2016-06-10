<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;
use ReflectionProperty;

/**
 * Class ValidationLocalizeTest
 * @package Rentalhost\VanillaValidation
 */
class ValidationLocalizeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test if quantify system works properly.
     * @covers Rentalhost\VanillaValidation\ValidationLocalize::translateFail
     */
    public function testQuantify()
    {
        $defaultLocale = Validation::option('locale');

        Validation::option('locale', 'pt-BR');

        $validationFails = Validation::minLength(1)->validate('')->getFails();

        static::assertSame('o campo deve possuir no mínimo um caractere', $validationFails[0]->getLocalized());

        $validationFails = Validation::minLength(10)->validate('hello')->getFails();

        static::assertSame('o campo deve possuir no mínimo 10 caracteres', $validationFails[0]->getLocalized());

        Validation::option('locale', $defaultLocale);
    }

    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationLocalize::__construct
     * @covers Rentalhost\VanillaValidation\ValidationLocalize::singleton
     */
    public function testSingleton()
    {
        $singleton = ValidationLocalize::singleton();

        static::assertInstanceOf(ValidationLocalize::class, $singleton);

        $singletonCached = ValidationLocalize::singleton();

        static::assertInstanceOf(ValidationLocalize::class, $singletonCached);

        /** @var ReflectionProperty $resetInstance */
        $resetInstance = new ReflectionProperty(ValidationLocalize::class, 'instance');
        $resetInstance->setAccessible(true);
        $resetInstance->setValue(null);

        $singletonUncached = ValidationLocalize::singleton();

        static::assertInstanceOf(ValidationLocalize::class, $singletonUncached);
    }

    /**
     * Test translateFail method.
     * @covers Rentalhost\VanillaValidation\ValidationLocalize::translateFail
     * @covers Rentalhost\VanillaValidation\ValidationLocalize::maskKey
     * @covers Rentalhost\VanillaValidation\ValidationLocalize::configureLocale
     */
    public function testTranslateFail()
    {
        $defaultLocale = Validation::option('locale');

        Validation::option('locale', 'pt-BR');

        $validation = new Validation;
        $validation->field('username', '')->required();
        $validationFails = $validation->validate()->getFails();

        static::assertSame('o campo "username" é obrigatório', $validationFails[0]->getLocalized());

        $validationFails = Validation::required()->validate('')->getFails();

        static::assertSame('o campo é obrigatório', $validationFails[0]->getLocalized());

        Validation::option('locale', [ 'unknow', 'pt-BR', 'en' ]);

        $validationFails = Validation::cpf()->validate('11122244405')->getFails();

        static::assertSame('o campo deve ser um CPF válido', $validationFails[0]->getLocalized());

        Validation::option('locale', $defaultLocale);
    }
}

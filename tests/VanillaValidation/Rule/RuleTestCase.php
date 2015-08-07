<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\ValidationFieldRule;
use Rentalhost\VanillaValidation\ValidationRules;
use Rentalhost\VanillaValidation\Result\Result;
use PHPUnit_Framework_TestCase;

abstract class RuleTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Test rule.
     */
    public function testRule($name, $parameters, $input, $expectedMessage, $expectedData)
    {
        $fieldRule = new ValidationFieldRule($name, $parameters);
        $validation = $fieldRule->validate($input);

        $this->assertInstanceOf(Result::class, $validation);
        $this->assertSame($expectedMessage === "success" ? true : false, $validation->isSuccess());
        $this->assertSame($expectedMessage, $validation->getMessage());
        $this->assertSame($expectedData ?: [], $validation->getData());
    }

    /**
     * Rules data.
     */
    abstract public function dataRule();
}

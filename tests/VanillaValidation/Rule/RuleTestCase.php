<?php

namespace Rentalhost\VanillaValidation\Test\Rule;

use Rentalhost\VanillaValidation\ValidationFieldRule;
use Rentalhost\VanillaValidation\Result\Result;
use PHPUnit_Framework_TestCase;

/**
 * Class RuleTestCase
 * @package Rentalhost\VanillaValidation\Test\Rule
 */
abstract class RuleTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Test rule.
     *
     * @param string $name            Rule name.
     * @param array  $parameters      Rule parameters.
     * @param mixed  $input           Rule input.
     * @param string $expectedMessage Rule result expected message.
     * @param null   $expectedData    Rule result expected data.
     */
    public function testRule($name, $parameters, $input, $expectedMessage, $expectedData)
    {
        $fieldRule = new ValidationFieldRule($name, $parameters);
        $validation = $fieldRule->validate($input);

        static::assertInstanceOf(Result::class, $validation);
        static::assertSame($expectedMessage === 'success', $validation->isSuccess());
        static::assertSame($expectedMessage, $validation->getMessage());
        static::assertSame($expectedData ?: [ ], $validation->getData());
    }

    /**
     * Rules data.
     */
    abstract public function dataRule();
}

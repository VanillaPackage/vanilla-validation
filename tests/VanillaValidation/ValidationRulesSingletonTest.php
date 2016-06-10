<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;

/**
 * Class ValidationRulesSingletonTest
 * @package Rentalhost\VanillaValidation
 */
class ValidationRulesSingletonTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::__construct
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::has
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::define
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::normalize
     */
    public function testBasic()
    {
        $rules = new ValidationRulesSingleton;

        static::assertTrue($rules->has('required'));
        static::assertFalse($rules->has('leftTrim'));

        $rules->define('leftTrim', Test\LeftTrimAction::class);

        static::assertTrue($rules->has('leftTrim'));

        static::assertNull($rules->normalize('inexistent'));
        static::assertNull($rules->normalize('notRequired'));
        static::assertSame('required', $rules->normalize('required'));
        static::assertSame('boolean', $rules->normalize('bool'));
        static::assertSame('boolean', $rules->normalize('boolean'));
    }

    /**
     * Test RuleNotImplementedException.
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::validate
     */
    public function testRuleNotImplementedException()
    {
        $this->expectException(Exception\RuleNotImplementedException::class);

        $fieldRule = new ValidationFieldRule('undefined');

        ValidationRules::validate($fieldRule, null);
    }

    /**
     * Test validate method.
     * @covers Rentalhost\VanillaValidation\ValidationRulesSingleton::validate
     */
    public function testValidate()
    {
        $rules = new ValidationRulesSingleton;

        $fieldRule = new ValidationFieldRule('trim');

        static::assertSame('hello', $rules->validate($fieldRule, 'hello'));
        static::assertSame('hello', $rules->validate($fieldRule, ' hello '));

        $fieldRule = new ValidationFieldRule('trim', [ '-' ]);

        static::assertSame('hello', $rules->validate($fieldRule, '-hello-'));

        $fieldRule = new ValidationFieldRule('required');

        static::assertTrue($rules->validate($fieldRule, 'value')->isSuccess());
        static::assertFalse($rules->validate($fieldRule, '')->isSuccess());
        static::assertFalse($rules->validate($fieldRule, false)->isSuccess());
        static::assertFalse($rules->validate($fieldRule, null)->isSuccess());

        $fieldRule = new ValidationFieldRule('notRequired');

        static::assertTrue($rules->validate($fieldRule, 'value')->isSuccess());
        static::assertTrue($rules->validate($fieldRule, '')->isSuccess());
        static::assertTrue($rules->validate($fieldRule, false)->isSuccess());
        static::assertTrue($rules->validate($fieldRule, null)->isSuccess());
    }
}

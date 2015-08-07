<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;

class ValidationFieldRuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationFieldRule::__construct
     * @return void
     */
    public function testBasic()
    {
        $this->assertClassHasAttribute("name", ValidationFieldRule::class);
        $this->assertClassHasAttribute("parameters", ValidationFieldRule::class);
        $this->assertClassHasAttribute("negative", ValidationFieldRule::class);

        $fieldRule = new ValidationFieldRule("name");

        $this->assertSame("name", $fieldRule->name);
        $this->assertSame("name", $fieldRule->originalName);
        $this->assertSame([], $fieldRule->parameters);
        $this->assertNull($fieldRule->negative);

        $fieldRule = new ValidationFieldRule("nameWillNotBeLowercase");

        $this->assertSame("nameWillNotBeLowercase", $fieldRule->name);

        $fieldRule = new ValidationFieldRule("notName");

        $this->assertTrue($fieldRule->negative);
        $this->assertSame("name", $fieldRule->name);
        $this->assertSame("notName", $fieldRule->originalName);

        $fieldRule = new ValidationFieldRule("NotWillBeNegative");

        $this->assertNull($fieldRule->negative);
        $this->assertSame("NotWillBeNegative", $fieldRule->name);
        $this->assertSame("NotWillBeNegative", $fieldRule->originalName);

        $fieldRule = new ValidationFieldRule("notwillbenegative");

        $this->assertNull($fieldRule->negative);
        $this->assertSame("notwillbenegative", $fieldRule->name);
        $this->assertSame("notwillbenegative", $fieldRule->originalName);

        $fieldRule = new ValidationFieldRule("name", [ 1, 2, 3 ]);

        $this->assertSame([ 1, 2, 3 ], $fieldRule->parameters);
    }

    /**
     * Test validate method.
     * @covers Rentalhost\VanillaValidation\ValidationFieldRule::validate
     * @return void
     */
    public function testValidate()
    {
        $fieldRule = new ValidationFieldRule("required");

        $this->assertTrue($fieldRule->validate("hello")->isSuccess());
        $this->assertFalse($fieldRule->validate("")->isSuccess());
    }
}

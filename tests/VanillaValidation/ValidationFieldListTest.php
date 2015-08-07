<?php

namespace Rentalhost\VanillaValidation;

use PHPUnit_Framework_TestCase;

class ValidationFieldListTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test basic methods.
     * @covers Rentalhost\VanillaValidation\ValidationFieldList::__construct
     * @covers Rentalhost\VanillaValidation\ValidationFieldList::__clone
     * @covers Rentalhost\VanillaValidation\ValidationFieldList::add
     * @covers Rentalhost\VanillaValidation\ValidationFieldList::all
     * @covers Rentalhost\VanillaValidation\ValidationFieldList::clear
     * @return void
     */
    public function testBasic()
    {
        $fieldList = new ValidationFieldList;
        $fieldList->add("name1", "value1");
        $fieldList->add("name2", "value2");

        $field1 = new ValidationField("name1", "value1");
        $field2 = new ValidationField("name2", "value2");

        $this->assertEquals([ $field1, $field2 ], $fieldList->all());

        $fieldListClone = clone $fieldList;

        $this->assertNotSame($fieldListClone->all(), $fieldList->all());

        $fieldListClone->clear();

        $this->assertEmpty($fieldListClone->all());
        $this->assertNotEmpty($fieldList->all());
    }

    /**
     * Test validate method.
     * @covers Rentalhost\VanillaValidation\ValidationFieldList::validate
     * @return void
     */
    public function testValidate()
    {
        $fieldList = new ValidationFieldList;
        $fieldList->add("name1", "value1")->string()->required();
        $fieldList->add("name2", "value2")->string()->required();

        $fieldListResult = $fieldList->validate();

        $this->assertTrue($fieldListResult->isSuccess());
        $this->assertCount(0, $fieldListResult->getFails());
        $this->assertCount(4, $fieldListResult->getSuccesses());

        $fieldList = new ValidationFieldList;
        $fieldList->add("name1", "value1")->string()->required();
        $fieldList->add("name2", 123)->string()->required();

        $fieldListResult = $fieldList->validate();

        $this->assertFalse($fieldListResult->isSuccess());
        $this->assertCount(1, $fieldListResult->getFails());
        $this->assertCount(3, $fieldListResult->getSuccesses());
    }
}

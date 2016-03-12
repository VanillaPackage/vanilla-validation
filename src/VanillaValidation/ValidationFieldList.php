<?php

namespace Rentalhost\VanillaValidation;

/**
 * Class ValidationFieldList
 * @package Rentalhost\VanillaValidation
 */
class ValidationFieldList
{
    /**
     * Store fields.
     * @var ValidationField[]
     */
    private $fields;
    
    /**
     * Construct.
     */
    public function __construct()
    {
        $this->fields = [ ];
    }
    
    /**
     * Clone all fields too.
     * @return void
     */
    public function __clone()
    {
        foreach ($this->fields as &$field) {
            $field = clone $field;
        }
    }
    
    /**
     * Add a new field and return it instance.
     *
     * @param string $name  Field name.
     * @param mixed  $value Field value.
     *
     * @return ValidationField
     */
    public function add($name, $value = null)
    {
        $field = new ValidationField($name, $value);
        
        $this->fields[] = $field;
        
        return $field;
    }
    
    /**
     * Returns all fields.
     * @return ValidationField[]
     */
    public function all()
    {
        return $this->fields;
    }
    
    /**
     * Clear all fields.
     * @return void
     */
    public function clear()
    {
        $this->fields = [ ];
    }
    
    /**
     * Validate all fields.
     * Basically it compiles all fields validations results into one.
     * If at least one of this validations fails, it'll fail too.
     * @return ValidationResult
     */
    public function validate()
    {
        $results      = [ ];
        $resultStatus = true;
        
        // Run each fields rules.
        foreach ($this->fields as $field) {
            $fieldResults = $field->validate();
            $resultStatus = $resultStatus && $fieldResults->isSuccess();
            
            $results[] = $fieldResults->getResults();
        }
        
        return new ValidationResult(
            $resultStatus,
            $resultStatus ? 'success' : 'fail',
            $results ? call_user_func_array('array_merge', $results) : [ ]
        );
    }
}

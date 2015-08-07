<?php

namespace Rentalhost\VanillaValidation\Result;

use Rentalhost\VanillaResult\Result as BaseResult;

abstract class Result extends BaseResult
{
    /**
     * Stores field.
     * @var ValidationField
     */
    public $field;

    /**
     * Stores input value. Which was passed to validator.
     * @var string|mixed
     */
    public $value;

    /**
     * Stores rule index from the field rules set.
     * @var integer
     */
    public $ruleIndex;

    /**
     * Stores rule instance.
     * @var ValidationFieldRule
     */
    public $rule;

    /**
     * Construct a result.
     * @param boolean $status  Status.
     * @param string  $message Message of result.
     * @param array   $data    Additional data (default empty array).
     */
    public function __construct($status = true, $message = null, array $data = null)
    {
        $this->setStatus($status);
        $this->message = $message;
        $this->data = $data ?: [];
    }
}

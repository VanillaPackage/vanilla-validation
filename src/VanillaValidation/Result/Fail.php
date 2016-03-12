<?php

namespace Rentalhost\VanillaValidation\Result;

use Rentalhost\VanillaValidation\ValidationLocalize;

/**
 * Class Fail
 * @package Rentalhost\VanillaValidation\Result
 */
class Fail extends Result
{
    /**
     * Costruct a fail result.
     *
     * @param string $message Fail message.
     * @param mixed  $data    Fail data.
     */
    public function __construct($message, $data = null)
    {
        parent::__construct(false, $message, $data);
    }
    
    /**
     * Returns the fail message localized.
     * @return string
     */
    public function getLocalized()
    {
        return ValidationLocalize::singleton()->translateFail($this);
    }
}

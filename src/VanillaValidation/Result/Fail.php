<?php

namespace Rentalhost\VanillaValidation\Result;

class Fail extends Result
{
    /**
     * Costruct a fail result.
     * @param string $message Fail message.
     * @param mixed  $data    Fail data.
     */
    public function __construct($message, $data = null)
    {
        parent::__construct(false, $message, $data);
    }
}

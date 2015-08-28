<?php

namespace Rentalhost\VanillaValidation\Result;

/**
 * Class Success
 * @package Rentalhost\VanillaValidation\Result
 */
class Success extends Result
{
    /**
     * Construct a Success result.
     *
     * @param array $data Data to pass to success result.
     */
    public function __construct(array $data = null)
    {
        parent::__construct(true, 'success', $data);
    }
}

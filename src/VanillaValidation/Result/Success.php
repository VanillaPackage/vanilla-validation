<?php

namespace Rentalhost\VanillaValidation\Result;

class Success extends Result
{
    /**
     * Construct a Success result.
     */
    public function __construct(array $data = null)
    {
        parent::__construct(true, "success", $data);
    }
}

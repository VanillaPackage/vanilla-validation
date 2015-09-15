<?php

namespace Rentalhost\VanillaValidation\Result;

/**
 * Class Nullable
 * @package Rentalhost\VanillaValidation\Result
 */
class Nullable extends Result
{
    /**
     * Construct a Nullable result.
     */
    public function __construct()
    {
        parent::__construct(true, 'success');
    }
}

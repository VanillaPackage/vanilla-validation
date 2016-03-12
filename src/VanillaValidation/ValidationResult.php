<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaResult\Result;
use Rentalhost\VanillaValidation\Result\Fail;
use Success;

/**
 * Class ValidationResult
 * @package Rentalhost\VanillaValidation
 */
class ValidationResult extends Result
{
    /**
     * Returns all fails results.
     * @return Fail[]
     */
    public function getFails()
    {
        return $this->getResultsFiltered(false);
    }
    
    /**
     * Returns both fails and successes results.
     * @return Fail[]|Success[]
     */
    public function getResults()
    {
        return $this->getData() ?: [ ];
    }
    
    /**
     * Returns all successes results.
     * @return Success[]
     */
    public function getSuccesses()
    {
        return $this->getResultsFiltered(true);
    }
    
    /**
     * Get results filtered.
     *
     * @param  boolean $status Result status.
     *
     * @return Result[]
     */
    private function getResultsFiltered($status)
    {
        $results = [ ];
        
        foreach ($this->getResults() as $result) {
            if ($result->isSuccess() === $status) {
                $results[] = $result;
            }
        }
        
        return $results;
    }
}

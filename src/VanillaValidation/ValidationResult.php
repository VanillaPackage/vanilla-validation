<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaResult\Result;

class ValidationResult extends Result
{
    /**
     * Returns all fails results.
     * @return Result\Result[]
     */
    public function getFails()
    {
        return $this->getResultsFiltered(false);
    }

    /**
     * Returns all successes results.
     * @return Result\Result[]
     */
    public function getSuccesses()
    {
        return $this->getResultsFiltered(true);
    }

    /**
     * Returns both fails and successes results.
     * @return Result\Result[]
     */
    public function getResults()
    {
        return $this->getData() ?: [];
    }

    /**
     * Get results filtered.
     * @param  boolean $status Result status.
     * @return Result\Result[]
     */
    private function getResultsFiltered($status)
    {
        $results = [];

        foreach ($this->getResults() as $result) {
            if ($result->isSuccess() === $status) {
                $results[] = $result;
            }
        }

        return $results;
    }
}

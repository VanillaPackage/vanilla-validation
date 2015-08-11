<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaValidation\Result\Fail;
use Rentalhost\VanillaValidation\Result\FailBreakable;
use Rentalhost\VanillaValidation\Result\Success;
use Rentalhost\VanillaValidation\Result\Result;

class ValidationFieldRuleList
{
    /**
     * Store rules.
     * @var ValidationFieldRule[]
     */
    private $rules;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->rules = [];
    }

    /**
     * Add a new rule.
     * @param string $name       Rule name.
     * @param array  $parameters Rule parameters.
     * @return void
     */
    public function add($name, $parameters = null)
    {
        $this->rules[] = new ValidationFieldRule($name, $parameters);
    }

    /**
     * Returns all rules.
     * @return ValidationFieldRule[]
     */
    public function all()
    {
        return $this->rules;
    }

    /**
     * Clear all rules.
     * @return void
     */
    public function clear()
    {
        $this->rules = [];
    }

    /**
     * Validate all rules with value.
     * @param mixed $input Initial input.
     * @return Result
     */
    public function validate($input)
    {
        $results = [];
        $resultStatus = true;

        // Run each rules in this list.
        foreach ($this->rules as $ruleIndex => $rule) {
            // Fill breakable first parameter with current status.
            if ($rule->name === "breakable") {
                $rule->parameters[0] = $resultStatus;
            }

            // Default validation.
            $ruleResult = $rule->validate($input);

            // If it returns a FailBreakable and is a breakable, so break iteration.
            if ($rule->name === "breakable"
            &&  $ruleResult instanceof FailBreakable) {
                break;
            }

            // If it results in a Result instance, will treat it as a validation.
            if ($ruleResult instanceof Result) {
                // Update status when it fails.
                $resultStatus = $resultStatus && $ruleResult->isSuccess();

                // Fill result attributes.
                $ruleResult->value = $input;
                $ruleResult->ruleIndex = $ruleIndex;
                $ruleResult->rule = $rule;

                // Add to results.
                $results[] = $ruleResult;

                // If it's a FailBreakable instance, break the iteration.
                if ($ruleResult instanceof FailBreakable) {
                    break;
                }

                continue;
            }

            // Else, it'll overwrite current input.
            $input = $ruleResult;
        }

        return new ValidationResult($resultStatus, $resultStatus ? "success" : "fail", $results);
    }
}

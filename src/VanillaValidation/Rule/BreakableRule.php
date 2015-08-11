<?php

namespace Rentalhost\VanillaValidation\Rule;

use Rentalhost\VanillaValidation\Result\FailBreakable;

class BreakableRule extends Rule
{
    /**
     * Validate only if none error happen before this rule.
     * @param string $parameters[0] If false, it'll returns a FailBreakable.
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        // If first parameter is false, so returns a FailBreakable.
        // This parameter is filled automatically in ValidationFieldRuleList::validate method.
        if (array_key_exists(0, $parameters)
        &&  $parameters[0] === false) {
            return new FailBreakable("fail:breakable");
        }

        return true;
    }
}

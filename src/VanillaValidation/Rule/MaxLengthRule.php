<?php

namespace Rentalhost\VanillaValidation\Rule;

class MaxLengthRule extends Rule
{
    /**
     * Validate if input have a maximum length.
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        if (!array_key_exists(0, $parameters)) {
            return false;
        }

        $data["length"] = intval($parameters[0]);
        $data["quantify"] = $data["length"];

        return strlen($input) <= $data["length"];
    }
}

<?php

namespace Rentalhost\VanillaValidation\Rule;

class MaskRule extends Rule
{
    private static $defaultMasks = [
        "~" => '\~',
        "#" => "\d",
        "@" => "[a-zA-Z]",
    ];

    /**
     * Validate if input match with mask.
     * @param string   $parameters[0] Mask definition.
     * @param string[] $parameters[1] Mask rules (optional).
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        // Parameter 0 (mask) is required.
        if (empty($parameters[0])) {
            return false;
        }

        $mask = $parameters[0];
        $maskRules = self::$defaultMasks;

        // Parameter 1 (rules) will overwrite mask rules.
        if (!empty($parameters[1])) {
            $maskRules = array_filter(array_replace($maskRules, $parameters[1]));
        }

        // Define mask quotted keys.
        $maskQuotes = array_diff(array_unique(str_split($mask)), array_keys($maskRules));
        $maskExpression = '~^' . str_replace(
                array_keys($maskRules),
                array_values($maskRules),
                str_replace($maskQuotes, array_map("preg_quote", $maskQuotes), $mask)
            ) . '$~';

        // Data.
        $data["expression"] = $maskExpression;

        return preg_match($maskExpression, $input);
    }
}

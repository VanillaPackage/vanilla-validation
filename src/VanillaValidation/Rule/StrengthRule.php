<?php

namespace Rentalhost\VanillaValidation\Rule;

class StrengthRule extends Rule
{
    /**
     * Validate if input password is strength enough.
     * @param float $parameters[0] Expected strength from 0 to 1 (or in percentual string like "80%").
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        if (!array_key_exists(0, $parameters)) {
            return false;
        }

        $data["expected"] = self::percentualToInteger($parameters[0]) ?: floatval($parameters[0]);
        $data["strength"] = round(self::calculateStrength($input), 2);

        return $data["strength"] >= $data["expected"];
    }

    /**
     * Calculate password strength.
     * @param  string $input Password input.
     * @return float
     */
    private static function calculateStrength($input)
    {
        $perfectStrength = 60;
        $inputStrength = 0;

        // Input length: max 8.
        $inputStrength+= min(8, strlen($input) - 8);

        // Input content: max 4.
        $inputStrength =
            preg_match('/\d/', $inputStrength) +
            preg_match('/[a-z]/', $inputStrength) +
            preg_match('/[A-Z]/', $inputStrength) +
            preg_match('/[^\d\w]/', $inputStrength);

        // Input unique chars: max 8.
        $inputStrength+= min(8, count(array_unique(str_split($input))));

        // Input special chars: max 8.
        $inputStrength+= min(4, count(array_unique(str_split(preg_replace('/[\d\w]/', null, $input))))) * 2;

        // Input chars distance: max 32.
        $inputDistance = 0;
        $lastCharacterOrd = 0;

        foreach (str_split($input) as $inputCharacter) {
            $currentCharacterOrd = ord($inputCharacter);
            $inputDistance+= min(5, floor(abs($currentCharacterOrd - $lastCharacterOrd) / 2));
            $lastCharacterOrd = $currentCharacterOrd;
        }

        $inputStrength+= min(32, $inputDistance);

        return min(1, 1 / $perfectStrength * $inputStrength);
    }

    /**
     * Returns a float from a percentual string.
     * @param  string $percentual Percentual value (with "%").
     * @return float
     */
    private static function percentualToInteger($percentual)
    {
        if (!preg_match('/^(\d+)%$/', $percentual, $percentualMatch)) {
            return null;
        }

        return $percentualMatch[1] / 100;
    }
}

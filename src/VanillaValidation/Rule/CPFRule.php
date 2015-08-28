<?php

namespace Rentalhost\VanillaValidation\Rule;

/**
 * Class CPFRule
 * @package Rentalhost\VanillaValidation\Rule
 */
class CPFRule extends Rule
{
    /**
     * Validate if input is a valid CPF.
     * @see Rule::validate
     *
     * @param mixed $input      Rule input.
     * @param array $parameters Rule parameters.
     * @param array &$data      Output data.
     *
     * @return bool
     */
    public function validate($input, array $parameters, array &$data)
    {
        // 1. Check if CPF have exactly 11 characters.
        // 2. Invalidate if CPF starts with 9 repeated numbers (ex. 111111111).
        if (!preg_match('/^\d{11}$/', $input) ||
            count(array_count_values(str_split(substr($input, 0, 9)))) === 1
        ) {
            return false;
        }

        $inputSplitted = str_split($input);

        // Calculate tenth and eleventh digits.
        $tenthDigit = self::calculateDigit($inputSplitted, 10);

        $inputSplitted[9] = $tenthDigit;
        $eleventhDigit = self::calculateDigit($inputSplitted, 11);

        // Store verificator digits and full expected value on output data.
        $data['digits'] = $tenthDigit . $eleventhDigit;
        $data['expected'] = substr($input, 0, 9) . $data['digits'];

        // Returns true if this verificator digits matches.
        return substr($input, -2) === $data['digits'];
    }

    /**
     * Calculate digit value.
     *
     * @param  string|integer[] $inputSplitted Input splitted.
     * @param  integer          $positions     Number of positions to calculate.
     *
     * @return integer
     */
    private static function calculateDigit($inputSplitted, $positions)
    {
        $digit = 0;
        $position = 0;

        // Sum and multiply.
        for ($i = $positions; $i >= 2; $i--) {
            $digit += $inputSplitted[$position] * $i;
            $position++;
        }

        // Zero.
        if ($digit % 11 < 2) {
            return 0;
        }

        return 11 - ( $digit % 11 );
    }
}

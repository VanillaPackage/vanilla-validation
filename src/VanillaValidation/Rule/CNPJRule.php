<?php

namespace Rentalhost\VanillaValidation\Rule;

class CNPJRule extends Rule
{
    /**
     * Stores CNPJ mask.
     * @var integer[]
     */
    private static $CNPJMask = [ 6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2 ];

    /**
     * Validate if input is a valid CNPJ.
     * @see Rule::validate
     */
    public function validate($input, array $parameters, array &$data)
    {
        // 1. Check if CNPJ have exactly 14 characters.
        // 2. Invalidate if CNPJ starts with 8 repeated numbers (ex. 11111111).
        if (!preg_match('/^\d{14}$/', $input)
        ||  count(array_unique(str_split(substr($input, 0, 8)))) === 1) {
            return false;
        }

        $inputSplitted = str_split($input);

        // Calculate thirtheenth and fourteenth digits.
        $thirteenthDigit = self::calculateDigit($inputSplitted, 12, 1);

        $inputSplitted[12] = $thirteenthDigit;
        $fourteenthDigit = self::calculateDigit($inputSplitted, 13, 0);

        // Store verificator digits and full expected value on output data.
        $data["digits"] = $thirteenthDigit . $fourteenthDigit;
        $data["expected"] = substr($input, 0, 12) . $data["digits"];

        // Returns true if this verificator digits matches.
        return substr($input, -2) === $data["digits"];
    }

    /**
     * Calculate digit value.
     * @param  string|integer[] $inputSplitted Input splitted.
     * @param  integer          $position      Number of positions to calculate.
     * @param  integer          $startFrom     Position to start from.
     * @return integer
     */
    private static function calculateDigit($inputSplitted, $positions, $startFrom)
    {
        $digit = 0;

        // Sum and multiply.
        for ($i = 0; $i < $positions; $i++) {
            $digit+= $inputSplitted[$i] * self::$CNPJMask[$startFrom + $i];
        }

        // Zero.
        if ($digit % 11 < 2) {
            return 0;
        }

        return 11 - ( $digit % 11 );
    }
}

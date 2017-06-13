<?php

namespace App;

class IntegerConversion implements IntegerConversionInterface
{
    const MIN_VAL = 1;
    const MAX_VAL = 3999;
    const BAD_REQUEST = 400;

    //Roman-numeral constants.
    const UNITS = 'I';
    const FIVES = 'V';
    const TENS = 'X';
    const FIFTIES = 'L';
    const HUNDREDS = 'C';
    const FIVE_HUNDREDS = 'D';
    const THOUSANDS = 'M';

    /**
     * Integer divide $a by $b with integer result. Not necessary with PHP 7 where this function exists.
     *
     * @param int $a The dividend
     * @param int $b The divisor.
     *
     * @return int The result of the division.
     */
    private static function intdiv($a, $b)
    {
        return ($a - $a % $b) / $b;
    }

    /**
     * Checks for $unitMultiple being greater than or equal to 5. If it is, five is subtracted
     * from unitMultiple, and $fiveMultiple is set to 1.
     *
     * @param int $fiveMultiple Represents the number of 5 multiples (V, L, or D).
     * @param int $unitMultiple Represents the number of power-of-10 multiples (I, X, C or M).
     */
    private static function checkAndAdjustFives(&$fiveMultiple, &$unitMultiple)
    {
        if ($unitMultiple >= 5) {
            $fiveMultiple = 1;
            $unitMultiple -= 5;
        }
    }

    /**
     * Convert $integer, expected to be in the range 1 to 3999, to Roman numeral string.
     *
     * @param int $integer The integer to convert
     *
     * @return string The equivalent roman-numeral string.
     *
     * @throws \Exception If an invalid $integer is passed.
     */
    public function toRomanNumerals($integer)
    {
        //First, ensure $integer is valid.
        $integer = (int) $integer; //Ensure integer type.
        if ($integer < self::MIN_VAL || $integer > self::MAX_VAL) {
            throw new \Exception("Invalid number specified", self::BAD_REQUEST);
        }

        //Next, extract the Roman-numeral components of the integer.
        $components = [
            self::THOUSANDS => 0,
            self::FIVE_HUNDREDS => 0,
            self::HUNDREDS => 0,
            self::FIFTIES => 0,
            self::TENS => 0,
            self::FIVES => 0,
            self::UNITS => 0
        ];

        $components[self::UNITS] = $integer % 10;
        self::checkAndAdjustFives($components[self::FIVES], $components[self::UNITS]);
        $integer = self::intdiv($integer,10);

        $components[self::TENS] = $integer % 10;
        self::checkAndAdjustFives($components[self::FIFTIES], $components[self::TENS]);
        $integer = self::intdiv($integer,10);

        $components[self::HUNDREDS] = $integer % 10;
        self::checkAndAdjustFives($components[self::FIVE_HUNDREDS], $components[self::HUNDREDS]);
        $integer = self::intdiv($integer,10);

        $components[self::THOUSANDS] = $integer; //Can be at most 3, so no modulus operator necessary.

        //Now we have the components, work out the actual string.
        $romanNumerals = '';
        $saveFiveUnitNumeral = null;
        $saveUnitNumeral = null;
        $pendingFiveNumeral = null;
        $isFiveMultiple = false;

        //Go through the numerals from most significant ('M') down to least significant ('I').
        foreach ($components as $numeral => &$quantity) {
            if ($isFiveMultiple) {
                if ($quantity == 1) {
                    //Can't add it to output string yet, as if the quantity of the next unit down is
                    //4 we don't add it (e.g. we output 'IX' instead of 'VIIII').
                    $pendingFiveNumeral = $numeral;
                }
                $saveFiveUnitNumeral = $numeral;
            } else {
                if ($pendingFiveNumeral) {
                    if ($quantity == 4) {
                        $romanNumerals .= ($numeral.$saveUnitNumeral); //i.e. 'CM', 'XC' or 'IX'
                        $quantity = 0;
                    } else {
                        $romanNumerals .= $pendingFiveNumeral;
                    }
                    $pendingFiveNumeral = null;
                }
                if ($quantity > 0) {
                    if ($quantity == 4 && $saveFiveUnitNumeral) {
                        $romanNumerals .= ($numeral.$saveFiveUnitNumeral); //i.e. 'CD', 'XL' or 'IV'
                    } else {
                        $romanNumerals .= str_repeat($numeral, $quantity);
                    }
                }
                $saveUnitNumeral = $numeral;
            }
            $isFiveMultiple = !$isFiveMultiple;
        }

        return $romanNumerals;
    }
}

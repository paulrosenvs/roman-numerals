<?php

namespace App;

class IntegerConversion implements IntegerConversionInterface
{
    const MIN_VAL = 1;
    const MAX_VAL = 3999;
    const BAD_REQUEST = 400;

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

    public function toRomanNumerals($integer)
    {
        //First, ensure $integer is valid.
        $integer = (int) $integer;
        if ($integer < self::MIN_VAL || $integer > self::MAX_VAL) {
            throw new \Exception("Invalid number specified", self::BAD_REQUEST);
        }

        //Next, extract the roman-numeral components of the integer.
        $numUnits = $integer % 10;
        $numFives = 0;
        if ($numUnits >= 5) {
            $numFives = 1;
            $numUnits -= 5;
        }
        $integer = self::intdiv($integer,10);

        $numTens = $integer % 10;
        $numFifties = 0;
        if ($numTens >= 5) {
            $numFifties = 1;
            $numTens -= 5;
        }
        $integer = self::intdiv($integer,10);

        $numHundreds = $integer % 10;
        $numFiveHundreds = 0;
        if ($numHundreds >= 5) {
            $numFiveHundreds = 1;
            $numHundreds -= 5;
        }
        $integer = self::intdiv($integer,10);

        $numThousands = $integer; //Can be at most 3, so no modulus operator necessary.

        //Now we have the components, work out the actual string.
        $romanNumerals = '';
        if ($numThousands > 0) {
            $romanNumerals .= str_repeat('M', $numThousands);
        }
        if ($numFiveHundreds == 1) {
            if ($numHundreds == 4) {
                $romanNumerals .= 'CM';
                $numHundreds = 0;
            } else {
                $romanNumerals .= 'D';
            }
        }
        if ($numHundreds > 0) {
            if ($numHundreds == 4) {
                $romanNumerals .= 'CD';
            } else {
                $romanNumerals .= str_repeat('C', $numHundreds);
            }
        }
        if ($numFifties == 1) {
            if ($numTens == 4) {
                $romanNumerals .= 'XC';
                $numTens = 0;
            } else {
                $romanNumerals .= 'L';
            }
        }
        if ($numTens > 0) {
            if ($numTens == 4) {
                $romanNumerals .= 'XL';
            } else {
                $romanNumerals .= str_repeat('X', $numTens);
            }
        }
        if ($numFives == 1) {
            if ($numUnits == 4) {
                $romanNumerals .= 'IX';
                $numUnits = 0;
            } else {
                $romanNumerals .= 'V';
            }
        }
        if ($numUnits > 0) {
            if ($numUnits == 4) {
                $romanNumerals .= 'IV';
            } else {
                $romanNumerals .= str_repeat('I', $numUnits);
            }
        }
        return $romanNumerals;
    }
}
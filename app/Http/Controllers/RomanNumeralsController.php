<?php

namespace App\Http\Controllers;

use App\Transformers\ConvertTransformer;
use App\Transformers\ErrorTransformer;
use Illuminate\Http\Request;
use App\IntegerConversionInterface;
use App\RomanNumeral;

class RomanNumeralsController extends Controller
{
    private $integerToRomanConversion;

    public function __construct(IntegerConversionInterface $integerConversion)
    {
        $this->integerToRomanConversion = $integerConversion;
    }

    /**
     * Convert $num, which should be a number between 1 to 3999, to a roman-numeral string.
     *
     * @param int $num The number to convert.
     *
     * @return string A JSON response consisting of the input number and the roman-numeral equivalent.
     */
    public function convert($num)
    {
        $num = (int) $num; //Ensure integer.
        try {
            $romanNumeralStr = $this->integerToRomanConversion->toRomanNumerals($num);
        }
        catch (\Exception $e) {
            return fractal()
                ->item($e)
                ->transformWith(new ErrorTransformer())
                ->toJson();
        }

        $romanNumeral = RomanNumeral::find($num);
        if (!$romanNumeral) {
            $romanNumeral = new RomanNumeral();
            $romanNumeral->int_val = $num;
            $romanNumeral->roman_numeral = $romanNumeralStr;
            $romanNumeral->num_conversions = 1;
        } else {
            $romanNumeral->num_conversions++;
        }
        $romanNumeral->save();

        return fractal()
            ->item($romanNumeral)
            ->transformWith(new ConvertTransformer())
            ->toJson();
    }

    public function showRecent()
    {

    }
}

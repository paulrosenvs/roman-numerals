<?php

namespace App\Transformers;

use App\RomanNumeral;
use League\Fractal\TransformerAbstract;

class ConvertTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param RomanNumeral $romanNumeralItem The Roman numeral data to transform.
     *
     * @return array The transformed data.
     */
    public function transform(RomanNumeral $romanNumeralItem)
    {
        return [
            'decimal' => $romanNumeralItem->int_val,
            'roman-numeral' => $romanNumeralItem->roman_numeral
        ];
    }
}

<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ErrorTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param \Exception $error The exception containing details of the error.
     *
     * @return array The transformed array.
     */
    public function transform(\Exception $error)
    {
        return [
            'message' => $error->getMessage(),
            'status' => $error->getCode()
        ];
    }
}

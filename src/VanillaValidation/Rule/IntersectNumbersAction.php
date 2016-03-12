<?php

namespace Rentalhost\VanillaValidation\Rule;

use Rentalhost\VanillaValidation\Interfaces\Action;

/**
 * Class IntersectNumbersAction
 * @package Rentalhost\VanillaValidation\Rule
 */
class IntersectNumbersAction implements Action
{
    /**
     * Will affect the input to keep only numeric characters.
     *
     * @param string $input      Current input.
     * @param array  $parameters Action parameters.
     *
     * @return string
     */
    public function action($input, array $parameters)
    {
        return preg_replace('/\D/', null, $input);
    }
}

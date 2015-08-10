<?php

namespace Rentalhost\VanillaValidation\Rule;

use Rentalhost\VanillaValidation\Interfaces\Action;

class IntersectNumbersAction implements Action
{
    /**
     * Will affect the input to keep only numeric characters.
     * @param  string $input Current input.
     * @return string
     */
    public function action($input, array $parameters)
    {
        return preg_replace("/\D/", null, $input);
    }
}

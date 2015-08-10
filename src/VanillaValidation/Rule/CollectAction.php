<?php

namespace Rentalhost\VanillaValidation\Rule;

use Rentalhost\VanillaValidation\Interfaces\Action;

class CollectAction implements Action
{
    /**
     * Collect current input and store to the reference variable.
     * @param  mixed     $input         Current input.
     * @param  variable &$parameters[0] Reference variable.
     * @return mixed
     */
    public function action($input, array $parameters)
    {
        $parameters[0] = $input;

        return $input;
    }
}

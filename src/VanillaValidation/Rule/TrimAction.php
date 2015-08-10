<?php

namespace Rentalhost\VanillaValidation\Rule;

use Rentalhost\VanillaValidation\Interfaces\Action;

class TrimAction implements Action
{
    /**
     * Trim the input.
     * @param  string $input         Trim input.
     * @param  string $parameters[0] Characters to trim (optional).
     * @return string
     */
    public function action($input, array $parameters)
    {
        array_unshift($parameters, $input);

        return call_user_func_array("trim", $parameters);
    }
}

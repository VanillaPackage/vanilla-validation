<?php

namespace Rentalhost\VanillaValidation\Rule;

class TrimAction extends Action
{
    /**
     * Trim the input.
     * @param  string $input         Trim input.
     * @param  array  $parameters[0] Characters to trim (optional).
     * @return string
     */
    public function action($input, array $parameters)
    {
        array_unshift($parameters, $input);

        return call_user_func_array("trim", $parameters);
    }
}

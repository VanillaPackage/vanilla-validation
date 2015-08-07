<?php

namespace Rentalhost\VanillaValidation\Test;

use Rentalhost\VanillaValidation\Rule\Action;

class LeftTrimAction extends Action
{
    /**
     * Do a left trim on input.
     * @param  string $input      Input to left trim.
     * @param  string $characters Characters to trim.
     * @return string
     */
    public function action($input, $characters = null)
    {
        return call_user_func_array("ltrim", func_get_args());
    }
}

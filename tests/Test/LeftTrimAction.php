<?php

namespace Rentalhost\VanillaValidation\Test;

use Rentalhost\VanillaValidation\Interfaces\Action;

/**
 * Class LeftTrimAction
 * @package Rentalhost\VanillaValidation\Test
 */
class LeftTrimAction implements Action
{
    /**
     * Do a left trim on input.
     *
     * @param  string $input      Input to left trim.
     * @param array   $parameters Action parameters.
     *
     * @var string    $parameters [0] Characters to trim.
     * @return string
     *
     */
    public function action($input, array $parameters)
    {
        return call_user_func_array('ltrim', func_get_args());
    }
}

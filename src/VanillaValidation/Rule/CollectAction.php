<?php

namespace Rentalhost\VanillaValidation\Rule;

use Rentalhost\VanillaValidation\Interfaces\Action;

/**
 * Class CollectAction
 * @package Rentalhost\VanillaValidation\Rule
 */
class CollectAction implements Action
{
    /**
     * Collect current input and store to the reference variable.
     *
     * @param  mixed $input      Action input.
     * @param  array $parameters Action parameters.
     *
     * @return mixed
     */
    public function action($input, array $parameters)
    {
        /** @noinspection OnlyWritesOnParameterInspection */
        $parameters[0] = $input;

        return $input;
    }
}

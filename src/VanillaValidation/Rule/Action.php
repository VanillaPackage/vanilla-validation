<?php

namespace Rentalhost\VanillaValidation\Rule;

abstract class Action
{
    /**
     * Action of this class.
     * @param  mixed  $input      Action input.
     * @param  array  $parameters Rule parameters.
     * @return mixed
     */
    abstract public function action($input, array $parameters);
}

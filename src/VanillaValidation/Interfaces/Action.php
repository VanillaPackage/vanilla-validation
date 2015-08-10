<?php

namespace Rentalhost\VanillaValidation\Interfaces;

interface Action
{
    /**
     * Action of this class.
     * @param  mixed  $input      Action input.
     * @param  array  $parameters Rule parameters.
     * @return mixed
     */
    public function action($input, array $parameters);
}

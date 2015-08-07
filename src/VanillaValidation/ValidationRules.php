<?php

namespace Rentalhost\VanillaValidation;

class ValidationRules
{
    /**
     * Store singleton instance.
     * @var self
     */
    private static $singleton;

    /**
     * Returns the singleton instance or create it.
     * @return self
     */
    public static function singleton()
    {
        if (!self::$singleton) {
            self::$singleton = new ValidationRulesSingleton;
        }

        return self::$singleton;
    }

    /**
     * Call a method from a singleton.
     * @param  string $name Method name.
     * @param  array  $args Method args.
     * @return mixed
     */
    public static function __callStatic($name, $args)
    {
        return call_user_func_array([ self::singleton(), $name ], $args);
    }
}

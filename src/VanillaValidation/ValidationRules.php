<?php

namespace Rentalhost\VanillaValidation;

use Rentalhost\VanillaResult\Result;

/**
 * Class ValidationRules
 * @package Rentalhost\VanillaValidation
 * @method static void define( string $name, string $classname )
 * @method static boolean has( string $name )
 * @method static string|null normalize( string $name )
 * @method static Result validate( ValidationFieldRule $rule, $input )
 */
class ValidationRules
{
    /**
     * Store singleton instance.
     * @var self
     */
    private static $instance;

    /**
     * Returns the singleton instance or create it.
     * @return self
     */
    public static function singleton()
    {
        if (!self::$instance) {
            self::$instance = new ValidationRulesSingleton;
        }

        return self::$instance;
    }

    /**
     * Call a method from a singleton.
     *
     * @param  string $name Method name.
     * @param  array  $args Method args.
     *
     * @return mixed
     */
    public static function __callStatic($name, $args)
    {
        return call_user_func_array([ self::singleton(), $name ], $args);
    }
}

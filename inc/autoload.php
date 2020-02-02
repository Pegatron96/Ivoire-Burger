<?php


namespace Autoload;


class Autoloader
{
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    private function autoload($class_name)
    {
        require 'inc/' . $class_name . '.php';
    }
}
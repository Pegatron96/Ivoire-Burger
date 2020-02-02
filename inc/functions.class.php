<?php


namespace Functions;


class Functions
{
    private static $_instance;

    public static function login()
    {
        if(isset($_POST['connect']))
        {
            header("Location: users/login.php");
        }
    }

    public function see()
    {
        if(isset($_POST['seew'])):

            header("Location: whishlist.php");

        endif;
    }

    public static function getInstance()
    {
        if(is_null(self::$_instance))
        {
            self::$_instance = new Functions();
        }

        return self::$_instance;
    }
}
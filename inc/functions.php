<?php


function debug($var)
{
    echo "<pre>" . print_r($var, true) .  "</pre>";
}

function verifyInput($var)
{
    $var = trim($var);
    $var = htmlspecialchars($var);
    $var = stripslashes($var);
    $var = htmlentities($var);

    return $var;
}

function logged_only()
{
    if(!isset($_SESSION['auth']))
    {
        header("Location: admin-login.php");

        $_SESSION['flash']['danger'] = "Vous n'avez plus accès à ses informations veuillez vous reconnecter";

        exit();

    }

}

function users_logged_only()
{
    if(!isset($_SESSION['auth']))
    {
        $_SESSION['flash']['danger'] = "Vous n'avez plus accès à ses informations veuillez vous reconnecter";

        header("Location: users/login.php");

        exit();

    }
}

function logged_cart_only()
{
    if(!isset($_SESSION['auth']))
    {
        $_SESSION['flash']['danger'] = "Vous devez être connecté pour accéder au panier";

        header("Location: users/login.php");

        exit();
    }
}

function logged_whish_only()
{
    if(!isset($_SESSION['auth']))
    {
        $_SESSION['flash']['danger'] = "Vous devez être connecté pour voir votre liste d'envie";

        header("Location: users/login.php");

            exit();
    }
}

function cart_only()
{
    if(empty($_SESSION['panier']))
    {
        $_SESSION['flash']['warning'] = "Votre panier est vide, veuillez d'abord le remplir !";

        header("Location: cart.php");

        exit();
    }
}


function isEmail($var)
{
    return filter_var($var, FILTER_VALIDATE_EMAIL);
}

function isPhone($var)
{
    return preg_match("/^[0-9 ]*$/", $var);
}

function isUsername($var)
{
    return preg_match("#[^a-z ?0-9]#i", $var);
}

function str_random($length)
{

    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";

    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);

}

$password = password_hash("24dxohwd", PASSWORD_BCRYPT);

echo "<script>" . "alert('$password')" . "</script>";




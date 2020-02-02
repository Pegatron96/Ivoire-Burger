<?php

session_start();

//setcookie('remember', NULL, -1);

unset($_SESSION['panier']);

unset($_SESSION['auth']);

$_SESSION['flash']['success'] = "Vous êtes maintenant déconnecter";

header("Location: login.php");






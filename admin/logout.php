<?php


session_start();

unset($_SESSION['auth']);

$_SESSION['flash']['success'] = "Vous êtes maintenant déconnecter! A bientôt";

header('Location: admin-login.php');

exit();
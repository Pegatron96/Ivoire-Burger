<?php

session_start();

$user_id = $_GET['id'];
$token = $_GET['token'];

require_once '../inc/database.php';

$db = Database::connect();

$req = $db->prepare('SELECT * FROM users WHERE id = ?');

$req->execute([$user_id]);

$user = $req->fetch();


if($user && $user['confirmation_token'] == $token ){


    $db->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);

    $_SESSION['flash']['success'] = "Votre compte a bien été validé";

    $_SESSION['auth'] = $user;

    header('location: account.php');
    exit();

}else{

    $_SESSION['flash']['warning'] = "Ce code de confirmation n'est plus valide";

    header('Location: login.php');

    exit();

}




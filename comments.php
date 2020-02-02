<?php

$error = array();

$error['message'] = $error['firstname'] = $error['email'] = $error['message'] = $error['emailerror'] = $error['firstnameerror'] = $error['messageerror'] = "";
$error['isSuccess'] = false;

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $error['firstname'] = verifyInput($_POST['firstname']);
    $error['email'] = verifyInput($_POST['email']);
    $error['message'] = verifyInput($_POST['message']);
    $error['isSuccess'] = true;


if(empty($error['firstname']))
{
    $error['firstnameerror'] = "Ce champs ne peut être vide";
    $error['isSuccess'] = false;
}

if(empty($error['email']) || !isEmail($error['email']))
{
    $error['emailerror'] = "Ce champ ne peut être vide";
    $error['isSuccess'] = false;

}

if(empty($error['message']))
{
    $error['messageerror'] = "Ecrivez votre commentaire svp";
    $error['isSuccess'] = false;
}

if($error['isSuccess'])
{
    $db = Database::connect();
    $req = $db->prepare("INSERT INTO comments SET message = ?, created_by = ?");
    $req->execute([$error['message'], $_SESSION['auth']['id']]);
    $_SESSION['flash']['success'] = "Votre commentaire a bien été posté";
}

echo json_encode($error);

}
<?php

//Traitement de l'adresse e-mail à l'état focus, avant que les données soient postées

require_once "../inc/functions.php";

if(!empty($_POST['email_check'])){

    $email = verifyInput($_POST['email_check']);

    if(empty($email) || !isEmail($email)) {
        echo "Saisissez une adresse e-mail valide";
    }else{
        echo "success";
    }
}
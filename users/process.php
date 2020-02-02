<?php

//Return all data to an ajax call

require_once "../inc/functions.php";

if(!empty($_POST['password_check']) && !empty($_POST['confirm_password_check']))
{


    if(strlen(verifyInput($_POST['password_check'])) < 8 || strlen(verifyInput($_POST['password_check'])) < 8)
    {
       echo "Trop court, saissez un mot de passe d'au moins 8 caractères";

       exit();
    }
    elseif($_POST['password_check'] == $_POST['confirm_password_check'])
    {
        echo "success";
        exit();
    }
    else
    {
        echo "Les deux mots de passe ne correspondent pas";
        exit();

    }
}

if(!empty($_POST['email_check']))
{
    $email = verifyInput($_POST['email_check']);

    if(!isEmail($email))
    {
        echo "Adresse e-mail invalide";
        exit();
    }
   elseif(isEmail($email))
    {
        require_once "../inc/database.php";

        $db = Database::connect();

        $req = $db->prepare("SELECT id FROM users WHERE email = ?");

        $req->execute([$email]);

        $user = $req->rowCount();

        if($user > 0)
        {
            echo "Cette adresse email est déjà associée à un compte";
            exit();
        }
        else
        {
            echo "success";
            exit();
        }

    }




}

if(isset($_POST['email']))
{
    require "../inc/database.php";

    extract($_POST);

    $db = Database::connect();

    $req = $db->prepare("SELECT id FROM users WHERE email = ?");
    $req->execute([$_POST['email']]);

    $email_check = $req->rowCount();
    
    if(empty($_POST['firstname']))
    {
        echo "Saisissez votre nom de famille";

    }

    if(empty($_POST['lastname']))
    {
        echo "Saisissez votre prénom";

    }

    if(empty($email) || !isEmail($email))
    {
        echo "Adresse e-mail invalide";
    }

    if(empty($password))
    {
        echo "Mot de passe invalide";
    }

    if($password != $confirm_password)
    {
        echo "Les mots de passe ne correspondent pas";
    }

    if(strlen($password) < 8)
    {
        echo "Créez un mot de passe de plus de 8 caractères";
    }

    if($email_check > 0)
    {
        echo "Cette adresse e-mail est délà associée à un compte";
    }

    if(!empty($firstname) && !empty($lastname) && !empty($email) && isEmail($email) && !empty($password) && !empty($confirm_password) && $password == $confirm_password && strlen($password) >= 8 && $email_check == 0)
    {

        $newpass = password_hash($password, PASSWORD_BCRYPT);


        $req = $db->prepare("INSERT INTO users SET firstname = ?, lastname = ?, email = ?, password = ?, ip = ?, confirmation_token = ?");

        $token = str_random(60);


        $req->execute([$firstname, $lastname, $email, $newpass, $_SERVER['REMOTE_ADDR'], $token]);

        $req = $db->prepare("SELECT id FROM users WHERE email = ?");

        $req->execute([$email]);

        $user = $req->fetch();

        $user_id = $user['id']; //LastInsertId()

        if(mail($email, 'Confirmation de votre compte client Ivoire Burger',"Bonjour $lastname veuillez cliquer sur ce lien pour confirmer votre compte\n\nhttp://localhost/ivoire-burger/users/confirm.php?id=$user_id&token=$token")){
            echo "register_success";

       }








    }



}




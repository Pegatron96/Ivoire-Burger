<?php

session_start();

require_once "../inc/database.php";
require_once  "../inc/functions.php";

//logged();

if(!empty($_POST))
{
    $errors = array();

    if(empty($_POST['username']))
    {
        $errors['username'] = "Saisissez un nom d'utilisateur ou une adresse électronique";
    }

    if(empty($_POST['password']))
    {
        $errors['password'] = "Saisissez un mot de passe valide";
    }

    if(empty($errors))
    {
        $db = Database::connect();

        $req = $db->prepare("SELECT * FROM admin WHERE username = :username OR email = :username");

        $req->execute(['username' => $_POST['username']]);

        $user = $req->fetch();

        $_SESSION['auth'] = $user;

        $id = $_SESSION['auth']['id'];

        if(password_verify($_POST['password'], $user['password'])){

            $req = $db->prepare("UPDATE admin SET last_login = NOW() WHERE id = ?");

            $req->execute([$id]);

            $_SESSION['flash']['success'] = "Vous êtes maintenant connecté ! Content de vous revoir ". "<span style='text-transform:capitalize'>". $user['firstname'] . " " . $user['lastname']. "</span>";

            header("Location: index.php");

            exit();



        }else{
            $errors['error'] = "Identifiant ou mot de passe incorrecte";
        }

        Database::disconnect();
    }


}
?>

<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ivoire Burger - Admin</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css"
    <link rel="stylesheet" href="../vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/jpg" href="../img/tetra.jpg">
    <style>

        .text-logo
        {
            color: #e7480f;
            text-shadow: 2px 2px #ffd301;
            font-size:48px;
            padding:60px 0px;
            font-family: 'Algerian', sans-serif;

        }

        body
        {
            background: url(../img/bg.png);
        }

        .container h1
        {
            margin-top: 30px;
        }

        .fa-cutlery
        {
            color: #ffd301;
        }

        .admin
        {
           // background: #fff;
            //padding: 50px;
            //border-radius: 10px;
        }

        form
        {
            padding: 50px !important;
            background: #fff;
            margin: auto;
            width: auto;
            margin-bottom: 73px ;
            color: #525252 !important;
        }

        .form-group
        {
            width: auto;
            margin:auto;
        }

        .form-group > label
        {
            font-size: 18px;
            font-weight: /*bold;*/
            color: /*#515151;*/
            text-transform: uppercase;
            font-family: /*Algerian, sans-serif;*/
            color: #303030;
            text-shadow: /*2px 2px #ffd301;*/

        }

        .form-group > input
        {
            //border: solid 1px #e7480f;
        }


        .form-actions
        {
            word-spacing: 40px;
            font-family: Algerian, sans-serif;
            width: auto;
            margin-left:50px;

        }

        input[type=text]:focus, input[type=password]:focus
        {
            box-shadow: 5px 5px rgba(128, 128, 128, 0.23);
            transition: box-shadow 500ms;

        }



    </style>
</head>
<body>

<h1 style="text-transform: uppercase" class="text-center text-logo"><i class="fa fa-cutlery"></i> Ivoire Burger Connexion Cpanel <i class="fa fa-cutlery"></i></h1>
<div class="container admin">

    <?php
        if(!empty($errors)):
    ?>

    <div style="margin:auto; width: auto;" class="alert alert-danger col-md-6">
        <p>Erreurs récurentes dans vos informations de connexion</p>
         <ul><?php foreach($errors as $error): ?>
        <li><?php echo $error ?></li>


             <?php endforeach; ?>

         </ul>
    </div> <br>

    <?php endif; ?>

    <?php if(isset($_SESSION['flash'])):  ?>

        <?php foreach($_SESSION['flash'] as $type => $message):  ?>

            <div class="alert alert-<?= $type; ?> alert-dismissible fade show" role="alert" data-toggle="alert">
                <?= $message;  ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="false">&times;</span>
                </button>

            </div>
        <?php endforeach; ?>

        <?php unset($_SESSION['flash']);  ?>

    <?php endif;  ?>


    <form class="img-thumbnail col-lg-6" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <div class="form-group">
            <label for="username">Identifiant ou adresse e-mail</label>
           <i class="fa fa-envelope-o"></i> <input data-toggle="tooltip" title="Saisissez votre identifiant admin" type="text" name="username"  placeholder="Username admin ou e-mail" class="form-control">
        </div> <br>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input data-toggle="tooltip" title="Votre mot de passe" type="password" name="password" placeholder="Mot de passe admin" class="form-control">
        </div> <br> <br>

        <div class="form-actions">
            <button data-toggle="tooltip" title="Let's connect :)" type="submit" class="btn btn-outline-primary btn-md" name="submit">Connexion <i class="fa fa-sign-in"></i> </button>

            <button data-toggle="tooltip" title="Effacer" type="reset" class="btn btn-outline-primary btn-md">Annuler <i class="fa fa-try"></i> </button>
        </div>


    </form>


</div>  <br> <br> <br>
<?php require_once "../inc/footer.php" ?>

<!--Bootstrap Core Javascript-->

<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script type="text/javascript" type="text/javascript" src="../js/main.js"></script>
</body>
</html>
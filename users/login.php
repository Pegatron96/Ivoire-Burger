<?php

session_start();

require_once "../inc/database.php";
require_once "../inc/functions.php";

//Google Oauth
require_once "../config.php";

$loginUrl = $gClient->createAuthUrl();



if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){



    $remember_token = $_COOKIE['remember'];

    $parts = explode('==', $remember_token);

    $user_id = $parts[0];

    $db = Database::connect();

    $req = $db->prepare("SELECT * FROM users WHERE id = ?");

    $req->execute([$user_id]);

    $user = $req->fetch();

    if($user){

        $expected =  $user_id . '==' . $user->$remember_token . sha1($user_id . 'ratonlaveurs');

        if($expected == $remember_token){

            $_SESSION['auth'] = $user;

            setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);


        }else{
            setcookie('remember', NULL, -1);
        }


    }else{

        setcookie('remember', NULL, -1);


    }


}

$mailingError = $passwordError = "";
$isSuccess = false;

if(isset($_POST['send']))
{
    $mailing = verifyInput($_POST['email']);
    $password = verifyInput($_POST['password']);
    $isSuccess = true;

    if(empty($mailing) || !isEmail($mailing))
    {
        $mailingError = "Saisissez une adresse e-mail valide";
        $isSuccess = false;
    }

    if(empty($password))
    {
        $passwordError = "Saisissez un mot de passe valide";
        $isSuccess = false;
    }


    if($isSuccess)
    {
        $db = Database::connect();

        $req = $db->prepare("SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL");

        $req->execute([$mailing]);

        $user = $req->fetch();


        if(password_verify($password, $user['password']))
        {

            $_SESSION['auth'] = $user;

            $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")->execute([$_SESSION['auth']['id']]);

            $_SESSION['flash']['success'] = "Vous êtes maintenant connecté ! Content de vous revoir" . " " . $user['lastname'];

            if($_POST['remember']){

                $remember_token = str_random(250);

                $db->prepare("UPDATE users SET remember_token = ?, remember_at = NOW() WHERE id = ?")->execute([$remember_token, $user['id']]);

                setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . 'ratonlaveurs'), time() + 60 * 60 * 24 * 7);


            }

           header("Location: account.php");

           exit();

        }else{

            $_SESSION['flash']['danger'] = "Adresse e-mail ou mot de passe incorrecte";
        }

    }




}


require_once "traitement.php";


?>

<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="../img/tetra.jpg">
    <title>Ivoire Burger | Connexion</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="../vendor/animate/animate.css">
    <link rel="stylesheet" href="../css/util.css">


    <style>

        .site
        {
            /*@font-face
                src: url("fonts/poppins/Poppins-Black.ttf") format("ttf");*/
            font-family: 'algerian', sans-serif;
        }

        form
        {
            font-family: sans-serif;
            width: auto !important;
            margin: auto !important;
            background: #c3e6cb;
            padding: 45px !important;
        }

        form > .form-group > label
        {
            color: #6a727a;
        }


        .text-logo
        {
            color: #e7480f;
            text-shadow: 2px 2px #ffd301;
            font-size:40px;
            padding:40px 0px;

        }

        .fa-cutlery
        {
            color: #ffd301;
        }

        button[type=submit]
        {
            background: #e7480f !important;
            border: 0px;
        }

        button[type=submit]:hover
        {
            background: #c13c0d !important;
        }

        strong > a
        {
            color: #e7480f !important;
        }

        strong > a:hover
        {
            text-decoration: none !important;
            color: rgba(231, 72, 15, 0.77) !important;
        }

        .input-symbol
        {
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            position: absolute;
            border-radius: 25px;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding-left: 35px;
            pointer-events: none;
            color: #666666;

            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }

        .focus
        {
            display: block;
            position: absolute;
            border-radius: 25px;
            bottom: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            box-shadow: 0px 0px 0px 0px;
            color: rgba(87,184,70, 0.8);

        }



        .input-focus:focus + .focus {
            -webkit-animation: anim-shadow 0.5s ease-in-out forwards;
            animation: anim-shadow 0.5s ease-in-out forwards;
        }

        @-webkit-keyframes anim-shadow {
            to {
                box-shadow: 0px 0px 70px 25px;
                opacity: 0;
            }
        }

        @keyframes anim-shadow {
            to {
                box-shadow: 0px 0px 70px 25px;
                opacity: 0;
            }
        }

        .small_image
        {
            border: 0px;
            width:30px !important;
            height:30px !important;
        }

        #help-inline, #help-inline-e
        {
            color: red !important;
        }

        input[type=checkbox]
        {
            width: 15px !important;
        }



    </style>


</head>
<body>
<div class="container site">

    <h1 style="text-transform: uppercase" class="text-center text-logo"><i class="fa fa-cutlery"></i> Ivoire Burger Connexion <i class="fa fa-cutlery"></i></h1><br><br>

    <?php if(isset($_SESSION['flash'])):  ?>

        <?php foreach($_SESSION['flash'] as $type => $message):  ?>

            <div style="width: auto !important; margin:auto !important; font-family: sans-serif !important;" class="col-md-5 text-center alert alert-<?= $type; ?> alert-dismissible fade show" role="alert">
                <?= $message;  ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div> <br>
        <?php endforeach; ?>

        <?php unset($_SESSION['flash']);  ?>

    <?php endif;  ?>

    <form class="img-thumbnail col-md-5 col-sm-10" method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <div class="form-group">
            <label for="email">E-mail</label>
            <input id="email" type="email" class="form-control input-focus" name="email" placeholder="Adresse e-mail" data-toggle="tooltip" title="Champ obligatoire">
            <span class="focus"></span>
            <span class="input-symbol"></span>
            <small id="help-inline-e"><?= $mailingError; ?></small>
        </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input id="password" type="password" class="form-control input-focus" name="password" placeholder="Mot de passe" data-toggle="tooltip" title="Champ obligatoire">
                <span class="focus"></span>
                <span class="input-symbol"></span>
                <small id="help-inline"><?= $passwordError; ?></small>

            </div>

        <div class="row">
        <label class="col-md-6" style="font-size: 14px; color: #6a727a; margin-bottom: 20px !important;">
            <input style="color:blue !important;" type="checkbox" class="img-thumbnail custom-checkbox" checked="checked" name="remember" value="1"> Rester connecté
        </label>
        <label class="col-md-6"><a data-toggle="tooltip" title="Cliquez sur le lien pour réinitialiser votre mot de passe" class="text-right" style="color: #e7480f; font-size: 12px;" href="remember.php">(Mot de passe oublié ?)</a></label><br>
        </div>
        <div class="form-actions">
            <button type="submit" name="send" id="register" data-toggle="tooltip" title="Se connecter" class="btn btn-primary">Connexion <i class="fa fa-sign-in"></i></button><br>
            <div class="form-group text-center">
                <label style="font-size: 15px; margin-top: 20px; color: #e7480f" class="text-center">Connectez-vous avec <a href="<?php echo $loginUrl; ?>"><img style="width:50px;height:50px;" src="../img/icon-google.png" alt="" data-toggle="tooltip" title="Connexion avec google"></a></label>

            </div>
        </div> <br>

        <div  class="dropdown-divider col-md-12"></div>
        <div class="text-center form-check">
            <label class="text-center" style="font-size:15px;color: #e7480f">Pas de compte ? <strong><a href="register.php">Inscription</a></strong> <i class="fa fa-arrow-circle-o-right"></i></label>
        </div>

    </form> <br><br>








</div>




<!--Bootstrap Core Javascript at the end of the page to load page fastly-->

<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/popper.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/tooltip.js"></script>
<script type="text/javascript" src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/main.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="../js/alert.js"></script>
<script type="text/javascript" src="../js/owl.carousel.min.js"></script>
<script type="text/javascript" src="../js/popper.min.js"></script>
<script type="text/javascript" src="../js/toast.js"></script>
<script src="../js/login.js"></script>
<script type="text/javascript" src="../js/util.js"></script>


<?php require_once "../inc/footer.php"; ?>

</body>





</html>

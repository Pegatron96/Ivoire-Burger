<?php

session_start();

require_once "../inc/database.php";
require_once "../inc/functions.php";

if(!empty($_POST) && !empty($_POST['email'])){

    $db = Database::connect();

    $req = $db->prepare("SELECT * FROM users WHERE email = ? AND confirmed_at IS NOT NULL");

    $req->execute([$_POST['email']]);

    $user = $req->fetch();

    if($user){

        $reset_token = str_random(60);

        $db->prepare("UPDATE users SET remember_token = ?, reset_at = NOW() WHERE id = ?")->execute([$reset_token, $user['id']]);

        $id = $user['id'];

        $_SESSION['flash']['success'] = "Un lien de réinitialisation de votre mot de passe a été envoyé par email";

        mail($_POST['email'], 'Réinitialisation du mot de passe de votre compte client Ivoire Burger ', "Afin de réinitialiser votre mot de passe veuillez cliquer sur ce lien\n\nhttp://localhost/ivoire-burger/users/reset.php?id=$id&token=$reset_token");

        header("Location: login.php");

        exit();


    }else{
        $_SESSION['flash']['danger'] = "Aucun compte ne correspond à cette adresse email";

    }

}


?>

<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="../img/tetra.jpg">
    <title>Ivoire Burger | Réinitialisation mot de passe</title>
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

    <h1 style="text-transform: uppercase" class="text-center text-logo"><i class="fa fa-cutlery"></i> Ivoire Burger Reset Password <i class="fa fa-cutlery"></i></h1><br><br>

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

        <h5 style="position: relative; text-transform: uppercase;bottom:15px; font-weight: bold; color: #e7480f">Réinitialisation mot de passe <i class="fa fa-edit"></i> </h5>
        <i style="color:#e7480f; font-size:18px;" class="fa fa-info-circle"></i> <div style="font-size: 14px; word-wrap: break-word; color:#6a727a;">Saisissez votre adresse e-mail ci-dessous, un lien de réinitialisation du mot de
        passe vous y sera envoyé.
        </div> <br>

        <div class="form-group">
            <input type="email" class="form-control input-focus" name="email" placeholder="Adresse e-mail">
            <span class="focus"></span>
        </div> <br>

        <div class="form-actions">
            <button style="text-transform: uppercase" type="submit" name="send" id="register" data-toggle="tooltip" title="Réinitialiser" class="form-control btn btn-primary">Réinitialiser <i class="fa fa-share-square-o"></i></button><br>

        </div> <br>
        <div class="row">
        <a  style="color: #e7480f; font-size: 13px; font-weight: bold" class="col-md-12 text-center" href="login.php">RETOUR</a>
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

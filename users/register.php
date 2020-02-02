<?php

session_start();
require_once "../inc/database.php";
require_once "process.php";
//require_once  "../inc/functions.php";


?>


<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="../img/tetra.jpg">
    <title>Ivoire Burger | Inscription</title>
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
        
        input[type=submit]
        {
            background: #e7480f !important;
            border: 0px;
        }

        input[type=submit]:hover
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



    </style>


</head>
<body>
<div class="container site">

    <h1 style="text-transform: uppercase" class="text-center text-logo"><i class="fa fa-cutlery"></i> Ivoire Burger Inscription <i class="fa fa-cutlery"></i></h1><br><br>

    <?php if(isset($_SESSION['flash'])):  ?>

        <?php foreach($_SESSION['flash'] as $type => $message):  ?>

            <div class="alert alert-<?= $type; ?> alert-dismissible fade show" role="alert">
                <?= $message;  ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        <?php endforeach; ?>

        <?php unset($_SESSION['flash']);  ?>

    <?php endif;  ?>

    <form id="register_form" class="img-thumbnail col-md-6 col-sm-10" onsubmit="return false;">

        <div style="font-size:12px !important;" id="statut" class="text-center col-md-auto"></div><br>

        <div class="row">

           <div class="col-md-6">
            <div class="form-group">
            <label style="color: #6a727a !important;" for="firstname">Nom</label style="color: #6a727a !important;">
            <input id="firstname" type="text" class="form-control input-focus" name="firstname" placeholder="Ex: Ette" data-toggle="tooltip" title="Quel est votre nom ?">
                <span class="focus"></span>
                <span class="input-symbol"></span>
                <small id="help-inline-f"></small>
            </div>
           </div>

            <div class="col-md-6">
            <div class="form-group">
                <label style="color: #6a727a !important;" for="lastname">Prénoms</label>
                <input id="lastname" type="text" class="form-control input-focus" name="lastname" placeholder="Ex: Jude" data-toggle="tooltip" title="Quel est votre prénom ?">
                <span class="focus"></span>
                <span class="input-symbol"></span>
                <small id="help-inline-l"></small>

            </div>
            </div>
        </div>



        <div class="form-group">
            <label for="email">E-mail</label>
            <input id="email" type="email" class="form-control input-focus" name="email" placeholder="your-name@example.com" data-toggle="tooltip" title="Quel est votre adresse e-mail ?">
            <span class="focus"></span>
            <span class="input-symbol"></span>
            <small id="help-inline-e"></small>
        </div>
        <div class="row" style="color: #6a727a !important;">
        <div class="form-group col-md-6">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" class="form-control input-focus" name="password" placeholder="Mot de passe" data-toggle="tooltip" title="Créez un mot de passe s'il vous plait !">
            <span class="focus"></span>
            <span class="input-symbol"></span>
            <small id="help-inline-p"></small>

        </div>

        <div class="form-group col-md-6">
            <label for="confirm_password">Confirmation</label>
            <input id="confirm_password" type="password" class="form-control input-focus" name="confirm_password" placeholder="Confirmation mot de passe" data-toggle="tooltip" title="Confirmez le mot de passe que vous venez de créer !">
            <span class="focus"></span>
            <span class="input-symbol"></span>
            <small id="help-inline-c"></small>


        </div>
        </div>
         <br>

        <div class="form-actions">
            <input type="submit" id="register" data-toggle="tooltip" value="Inscription" title="S'inscrire" class="btn btn-primary btn-lg"><!--Inscription <i class="fa fa-check"></i>--><br>
            <div class="form-group text-center">
                <label style="font-size: 15px; margin-top: 20px; color: #e7480f" class="text-center">Inscrivez-vous avec <a href="https://www.mail.google.com"><img style="width:50px;height:50px;" src="../img/icon-google.png" alt="" data-toggle="tooltip" title="Inscription avec google"></a></label>

            </div>
        </div> <br>

        <div  class="dropdown-divider col-md-12"></div>
        <div class="text-center form-check">
            <label class="text-center" style="font-size:15px;color: #e7480f">Déjà un compte ? <strong><a href="login.php">Connexion</a></strong> <i class="fa fa-sign-in"></i></label><br>
        </div>

    </form> <br><br><br><br>








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
<script src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/util.js"></script>


<?php require_once "../inc/footer.php"; ?>

</body>





</html>
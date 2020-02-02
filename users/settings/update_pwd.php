<?php

session_start();

require_once "../../inc/database.php";
require_once "../../inc/functions.php";

if(!isset($_SESSION['auth']))
{
    $_SESSION['flash']['danger'] = "Session terminé veuillez vous reconnecter";

    header("Location: ../login.php");

    exit();
}

$old_passwordError = $new_password_lengthError = $new_pass_confirmError = "";
$isSuccess = false;

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $old_password = verifyInput($_POST['old_password']);

    $new_password = verifyInput($_POST['new_password']);

    $new_pass_confirm = verifyInput($_POST['new_pass_confirm']);

    $new_password_length = strlen($new_password);

    $isSuccess = true;

    if(empty($old_password))
    {
        $old_passwordError = "Saisissez un mot de passe valide";
        $isSuccess = false;
    }

    if(!password_verify($old_password, $_SESSION['auth']['password']))
    {
        $old_passwordError = "Le mot de passe que vous avez saisi est incorrecte";
        $isSuccess = false;
    }
    if($new_password_length < 8 || empty($new_password))
    {
        $new_password_lengthError = "Créez un mot de passe de plus de 8 caractères";
        $isSuccess = false;
    }

    if($new_password != $new_pass_confirm)
    {
        $new_passwordError = "Les deux mots de passes ne correspondent pas";
        $new_pass_confirmError = "Les deux mots de passes ne correspondent pas";
        $isSuccess = false;
    }

    if($isSuccess)
    {
        $db = Database::connect();

        $id = $_SESSION['auth']['id'];

        $req = $db->prepare("UPDATE users SET password = ? WHERE id = ?");

        $realpass = password_hash($new_password, PASSWORD_BCRYPT);

        $req->execute([$realpass, $id]);

        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour" . " ". $_SESSION['auth']['lastname'];

        header("Location: ../account.php");

        exit();
    }








}

?>


<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" width="device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="../../img/tetra.jpg">
    <title>Ivoire Burger | Mise à jour du mot de passe</title>
    <!--<link rel="stylesheet" type="text/css" href="../../css/main.css">-->
    <link rel="stylesheet" href="../../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../fonts/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../../vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="../../vendor/animate/animate.css">

    <style>
        .site
        {
            font-family: sans-serif;
            background: #F5F5F5;
        }

        .nav-link
        {
            color:#fff;
        //text-shadow: 2px 2px #333;
            font-size: 18px;
        }
        .nav-link:hover, .nav-link:focus
        {
            background: #fff;
            color: #e7480f;
        }

        .text-logo
        {
            color: #e7480f;
            text-shadow: 2px 2px #ffd301;
            font-size:24px;
            font-family: Algerian, sans-serif;
            margin: 0px;

        }

        .fa-cutlery
        {
            color: #ffd301;
        }



        p
        {
            font-size: 13px;
            word-wrap: break-word;
        }


        input[type=search]
        {
            outline: none;
            font-family: sans-serif;
            font-size: 13px;
            margin-top:5px;
            color: #000 !important;
            padding-right: 19px;
            border: 1px solid #CDCDD2;
            padding-left:45px !important;
            background: url(../../img/user_search.PNG) no-repeat left;
            width:350px;
            padding: 8px;

        }


        #search
        {
            color:#fff;
        }

        #res
        {
            font-family: sans-serif;
            color: rgba(0, 0, 0, 0.66);
        }

        .drop > li > a:hover
        {
            text-decoration:none;

        }

        .drop, .drop > li > a
        {
            color: #e7480f;
            padding-top: 20px;
            position: relative;
            left:15px;
            font-size:15px;

        }

        .drop > li:hover
        {
            border-left: 4px solid #e7480f;
        }

        body {
            overflow-x: hidden;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            -webkit-transition: margin .25s ease-out;
            -moz-transition: margin .25s ease-out;
            -o-transition: margin .25s ease-out;
            transition: margin .25s ease-out;
            border-right: 1px solid #DAE0E5;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
        }

        #page-content-wrapper {
            min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }

        .list-group-flush > a
        {
            background: #fff !important;
        }

        #navbarSupportedContent > h1 > a
        {
            color: #e7480f;
        }

        #navbarSupportedContent > h1 > a:hover
        {
            text-decoration: none;
        }

        .list-group > a:hover
        {
            background: rgba(255, 193, 7, 0589) !important;
        }

        .img-thumbnail  ul li, .img-thumbnail  ul li a
        {
            color: #5b5b5b;
        }

        .img-thumbnail  ul li:hover
        {
            color: #A4A4A4;
        }

        .img-thumbnail ul li a:hover
        {
            color: #A4A4A4;
            text-decoration: none;
        }

        .col-xs-3 > ul
        {
            list-style-type: none;
        }

        .img-thumbnail ul
        {
            font-size: 14px;
        }

        .naving:hover
        {
            text-decoration: none;
        }

        .col-md-8 > h4
        {
            color: #495057;
        }

        th
        {
            text-transform: uppercase;
            color: #495057;
            font-size: 13px;
            padding: 10px;
            border-bottom: 1px !important;
        }

        td
        {
            text-transform: capitalize;
            font-size:16px;
            padding:10px;
        }

        td > span
        {
            text-transform: lowercase !important;
            font-style: italic;
            font-size: 15px;
        }

        #update a, .locked
        {
            text-transform:uppercase !important;
            font-style:normal;
            color:#e7480f;
            font-weight:bold;
        }

        #update a:hover
        {
            text-decoration: none;
        }

        form label
        {
            color: #969596;
        }

        small
        {
            color: red;
        }








    </style>


</head>
<body>
<div class="site d-flex" id="wrapper">


    <div style="background: #fff !important;" class="bg-light border-right" id="sidebar-wrapper">
        <div style="color: #E7480F" class="sidebar-heading">Tableau de bord <i class="fa fa-dashboard"></i> </div>
        <div style="background: #fff !important;" class="list-group list-group-flush">
            <a href="../../index.php" class="list-group-item list-group-item-action bg-light"> <i class="fa fa-home"></i> Accueil</a>
            <a href="../../menus.php" class="list-group-item list-group-item-action bg-light"> Menus</a>
            <a href="../../burgers.php" class="list-group-item list-group-item-action bg-light">Burgers</a>
            <a href="../../snacks.php" class="list-group-item list-group-item-action bg-light">Snacks</a>
            <a href="../../salades.php" class="list-group-item list-group-item-action bg-light">Salades</a>
            <a href="../../boissons.php" class="list-group-item list-group-item-action bg-light"> Boissons</a>
            <a href="../contact.php" class="list-group-item list-group-item-action bg-light"> Nous contactez</a>
        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <nav style="position: relative; bottom:5px ;background: #fff !important;" class="navbar navbar-expand-lg navbar-light bg-light border-bottom fixed-top">

            <button class="navbar-toggler-icon img-thumbnail" style="border: 0px;font-size: 20px; position: relative; left: 40px;"  id="menu-toggle"></button>



            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <h1 style="margin-left: 63px;text-transform: uppercase" class="text-center text-logo"><a href="../index.php"><i class="fa fa-cutlery"></i> Ivoire Burger <i class="fa fa-cutlery"></i></a></h1>
                <span style="margin-left: 80px;">
                    <form method="GET" action="../../menus.php">
                        <input class="img-thumbnail" type="search" name="search" id="search" placeholder="Effectuer une recherche..."> <button class="btn btn-warning" type="submit">Search</button>

                    </form>
                </span>
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">

                    <li class="nav-item dropdown">
                        <?php if(strlen($_SESSION['auth']['lastname']) >= 9): ?>

                            <a style="font-size:13px ; text-transform: capitalize" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php  echo "Bonjour," . " " . $_SESSION['auth']['lastname']; ?>
                            </a>
                        <?php else: ?>

                            <a style="font-size:15px ; text-transform: capitalize" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php  echo "Bonjour," . " " . $_SESSION['auth']['lastname']; ?>
                            </a>

                        <?php endif; ?>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="../index.php"><i class="fa fa-home"></i> Accueil</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../../whishlist.php"><i class="fa fa-heart-o"></i> Liste d'envie</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../checkout.php"><i class="fa fa-dropbox"></i> Mes Commandes </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../contact.php"><i class="fa fa-question-circle"></i> Suggestions </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../logout.php"><i class="fa fa-sign-out"></i> Se déconnecter </a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a style="color: #757575" class="nav-link" href="../../cart.php"><i class="fa fa-shopping-cart"></i>  Panier</a>
                    </li>

                </ul>
            </div>
        </nav> <br><br>

        <?php if(isset($_SESSION['flash'])):  ?>

            <?php foreach($_SESSION['flash'] as $type => $message):  ?>

                <div style="width: auto !important; margin:auto !important; font-family: sans-serif !important;" class="col-md-6 text-center alert alert-<?= $type; ?> alert-dismissible fade show" role="alert">
                    <?= $message;  ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div> <br>
            <?php endforeach; ?>

            <?php unset($_SESSION['flash']);  ?>

        <?php endif;  ?>

        <div class="container">
            <div class="row">
                <nav class="col-md-3 col-xs-3 img-thumbnail" style="border: 0px; background: #fff !important; padding: 13px; margin-bottom:20px;">
                    <ul style="padding: 0px !important;">
                        <li class="nav-item active"><i class="fa fa-user-o"></i> <a href="../account.php">Votre compte Ivoire Burger</a></li>
                        <li class="dropdown-divider"></li>
                        <a class="naving" href="../../whishlist.php"><li class="nav-item"><i class="fa fa-heart-o"></i> Votre liste d'envies</li></a>
                        <li class="dropdown-divider"></li>
                        <a class="naving" href="../checkout.php"><li class="nav-item"><i class="fa fa-dropbox"></i> Vos commandes</li></a>
                        <li class="dropdown-divider"></li>
                        <a class="naving" href="update_info.php?update_info_for=<?= $_SESSION['auth']['lastname'] . $_SESSION['auth']['firstname'] ?>">
                            <li class="nav-item"><i class="fa fa-info-circle"></i>
                                Informations personnelles
                            </li>
                        </a>
                        <li class="dropdown-divider"></li>
                        <a class="naving" href="update_pwd.php?update_pwd_for=<?= $_SESSION['auth']['lastname'] . $_SESSION['auth']['firstname'] ?>"><li class="nav-item"><i class="fa fa-lock"></i> Modifier mot de passe</li></a>
                        <li class="dropdown-divider"></li>
                        <a class="naving" href="update_addresse.php"><li class="nav-item"><i class="fa fa-building"></i> Adresses de livraison</li></a>
                        <li class="dropdown-divider"></li>
                        <a class="naving" href="../stats_customers.php?stats_for=<?= $_SESSION['auth']['lastname'] . $_SESSION['auth']['firstname'] ?>"><li class="nav-item"><i class="fa fa-bar-chart"></i> Statistiques Clients</li></a>
                        <li class="dropdown-divider"></li>
                        <li class="nav-item text-center"><a style="color: #e7480f" href="../logout.php?session_die=true"><i class="fa fa-sign-out"></i> Déconnexion</a></li>



                    </ul>
                </nav> <br> <br>
                <div class="col-md-8 col-lg-8">
                    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>"  style="background: #fff; padding: 15px;">
                        <h4 class="text-justify" style="color:#495057">Modifier le mot de passe <i class="fa fa-lock"></i></h4> <br>

                        <div class="form-group">
                            <label for="old_password">Ancien mot de passe</label>
                            <input type="password" name="old_password" class="form-control" placeholder="Saisissez votre ancien mot de passe">
                            <small><?= $old_passwordError; ?></small>

                        </div>

                        <div class="form-group">
                            <label for="new_password">Nouveau mot de passe</label>
                            <input type="password" class="form-control" name="new_password" placeholder="Saisissez votre nouveau mot de passe">
                            <small><?= $new_password_lengthError; ?></small>
                            <small><?= $new_pass_confirmError; ?></small>
                        </div>

                        <div class="form-group">
                            <label for="new_pass_confirm">Confirmation nouveau mot de passe</label>
                            <input type="password" class="form-control" name="new_pass_confirm" placeholder="Confirmez votre nouveau mot de passe">
                            <small><?= $new_pass_confirmError; ?></small>
                        </div> <br>

                        <div class="form-actions">
                            <button style="font-weight:bold" type="submit" name="sub_submit" class="btn-block btn btn-warning">SOUMETTRE <i class="fa fa-check"></i> </button>
                        </div>


                </div>
                </form>

            </div>

        </div>

    </div>

</div>


<!-- /#page-content-wrapper -->

</div>


<!-- /#wrapper -->

<!--Bootstrap Core Javascript at the end of the page to load page fastly-->

<script type="text/javascript" src="../../vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../vendor/bootstrap/js/popper.js"></script>
<script type="text/javascript" src="../../vendor/bootstrap/js/tooltip.js"></script>
<script type="text/javascript" src="../../vendor/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../../js/main.js"></script>
<script type="text/javascript" src="../../vendor/bootstrap/js/bootstrap.js"></script>
<!--<script type="text/javascript" src="../../js/alert.js"></script>-->
<script type="text/javascript" src="../../js/owl.carousel.min.js"></script>
<script type="text/javascript" src="../../js/popper.min.js"></script>
<script type="text/javascript" src="../../js/toast.js"></script>
<script type="text/javascript" src="../../js/tooltip.js"></script>
<script type="text/javascript" src="../../js/util.js"></script>
<script type="text/javascript" src="../../js/update.js"></script>

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

</body>



</html>





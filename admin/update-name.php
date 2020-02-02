<?php


session_start();

require_once "../inc/functions.php";

//Fonction qui restreint l'accès de certaines pages du site aux utilisateurs non authentifiés

logged_only();

require_once "../inc/database.php";

$db = Database::connect();

$req = $db->query("SELECT * FROM admin");

$admin = $req->fetch(PDO::FETCH_OBJ);

$lastnameError = $firstnameError = "";
$isSuccess = false;
if(isset($_POST['submit']))
{

    $firstname = verifyInput($_POST['firstname']);
    $lastname = verifyInput($_POST['lastname']);
    $isSuccess = true;
   

    if(empty($firstname))
    {
        $firstnameError = "Remplissez ce champ svp!";
        $isSuccess = false;
    }

    if(empty($lastname))
    {
        $lastnameError = "Remplissez ce champ svp!";
        $isSuccess = false;
    }

    if($isSuccess)
    {
        $req = $db->prepare("UPDATE admin SET firstname = ?, lastname = ? WHERE id = ?");
        $req->execute([$firstname, $lastname, $admin->id]);
        $_SESSION['flash']['success'] = "Vos informations personnelles ont bien été mise à jour";
        header("Location: update-info.php");
        exit();
    }



}




?>


<!Doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="../img/tetra.jpg">
    <?php echo "<title>" . "Ivoire Burger - Cpanel | Paramètres" . "</title>";  ?>
    <!--<link rel="stylesheet" type="text/css" href="../css/main.css">-->
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="../vendor/animate/animate.css">

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

        .price
        {
            background: #5cb85c;
            box-shadow: 0 1px rgba(0, 0, 0, 0.2);
            -moz-box-shadow: 0 1px rgba(0, 0, 0, 0.2);
            -webkit-box-shadow: 0 1px rgba(0, 0, 0, 0.2);
            color:#fff;
            text-shadow: 2px 2px #333;
            position:absolute;
            right:6px;
            top:20px;
            padding:5px 10px;
            font-size: 20px;
            border-radius: 3px;

        }

        .price:before
        {
            border: 4px solid transparent;
            border-bottom: 4px solid #4a934a;
            border-left: 4px solid #4a934a;
            content: "";
            position:absolute;
            right: 1px;
            top: -8px;
        }

        .caption h4
        {
            color: #e7480f;
            font-size: 18px;
        }

        .btn-order
        {
            background: #e7480f;
            color: #fff;
            text-shadow: 2px 2px #333;
        }

        .btn-order:hover, .btn-order:focus
        {
            background: #c13c0d;
            color: #fff;


        }

        p
        {
            font-size: 13px;
            word-wrap: break-word;
        }

        .cart, .user
        {
            color: #e7480f;
            font-size: 20px;
        }
        .cart:hover, .cart:focus, .user:hover, .user:focus
        {
            background: transparent !important;
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
            background: url(../img/user_search.PNG) no-repeat left;
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

        .dropdown-item:hover
        {
            border-left:#e7480f 4px solid;
        }

        .border
        {
            border-radius: 5px !important;
        }

        #img
        {
            animation: 1.5s spin infinite ease-in-out;
            position: fixed;
            padding: 11px;
            font-size: 38px;
            border-radius: 500px !important;
            cursor: pointer;
        }

        @keyframes spin {
            to{
                transform: rotate(360deg);
            }
        }
    </style>


</head>
<body>
<div class="site d-flex" id="wrapper">


    <div style="background: #fff !important;" class="bg-light border-right" id="sidebar-wrapper">
        <div style="color: #E7480F" class="sidebar-heading">Tableau de bord <i class="fa fa-dashboard"></i> </div>
        <div style="background: #fff !important;" class="list-group list-group-flush">
            <a href="<?= $_SERVER['PHP_SELF']; ?>" class="list-group-item list-group-item-action bg-light"> <i class="fa fa-home"></i> Accueil</a>
            <a href="items.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-product-hunt"></i>  Gestion des items</a>
            <a href="users.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-users"></i> Gestion des utilisateurs</a>
            <a href="messenger.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-dropbox"></i> Gestion des commandes</a>
            <a href="setting.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-cogs"></i> Paramètres</a>
            <a href="logout.php" class="text-center list-group-item list-group-item-action bg-light"><i class="fa fa-sign-out"></i> Déconnexion</a>

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
                <h1 style="margin-left: 63px;text-transform: uppercase" class="text-center text-logo"><a href="<?= $_SERVER['PHP_SELF']; ?>"><i class="fa fa-cutlery"></i> Ivoire Burger <i class="fa fa-cutlery"></i></a></h1>
                <span style="margin-left: 80px;">
                    <form method="GET" action="../menus.php">
                        <input class="img-thumbnail" type="search" name="search" id="search" placeholder="Effectuer une recherche..."> <button class="btn btn-warning" type="submit">Search</button>

                    </form>
                </span>
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">

                    <li class="nav-item dropdown">
                        <?php if(strlen($_SESSION['auth']['lastname']) >= 9): ?>

                            <a style="font-size:13px ; text-transform: capitalize" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $_SESSION['auth']['firstname']. " " . $_SESSION['auth']['lastname']; ?>
                            </a>
                         <?php else: ?>

                            <a style="font-size:15px ; text-transform: capitalize" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $_SESSION['auth']['firstname']. " " . $_SESSION['auth']['lastname']; ?>
                            </a>

                        <?php endif; ?>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <div class="dropdown-header">Fonction: <span class="font-weight-bold"><?= $_SESSION['auth']['Fonction']; ?></span></div>
                            <div class="dropdown-header">Espace Admin</div>
                            <a class="dropdown-item" href="<?php echo 'profile.php?admin='. $_SESSION['auth']['firstname'] . $_SESSION['auth']['lastname'] ?>&role=<?php echo $_SESSION['auth']['Fonction'] ?>"><i class="fa fa-home"></i> Profile Admin</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="setting.php?admin=<?= $_SESSION['auth']['firstname']. $_SESSION['auth']['lastname'] ?>&role=<?= $_SESSION['auth']['Fonction'] ?>"><i class="fa fa-cogs"></i> Paramètres</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="items.php"><i class="fa fa-product-hunt"></i> Gestion des items</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="users.php?admin=<?= $_SESSION['auth']['firstname']. $_SESSION['auth']['lastname'] ?>&role=<?= $_SESSION['auth']['Fonction'] ?>"><i class="fa fa-users"></i> Gestion utilisateurs </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="messenger.php?admin=<?= $_SESSION['auth']['firstname']. $_SESSION['auth']['lastname'] ?>&role=<?= $_SESSION['auth']['Fonction'] ?>"><i class="fa fa-dropbox"></i> Gestion des commandes </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php?session_die=true"><i class="fa fa-sign-out"></i> Se déconnecter </a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a style="color: #757575" class="nav-link" href="#"><i class="fa fa-calendar"></i> </a>
                    </li>

                </ul>
            </div>
        </nav> <br><br>

        <?php if(isset($_SESSION['flash'])):  ?>

            <?php foreach($_SESSION['flash'] as $type => $message):  ?>

                <div style="width: auto !important; margin:auto !important; font-family: sans-serif !important;" class="col-md-7 text-center alert alert-<?= $type; ?> alert-dismissible fade show" role="alert">
                    <?= $message;  ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div> <br>
            <?php endforeach; ?>

            <?php unset($_SESSION['flash']);  ?>

        <?php endif;  ?>

        <div class="container img-thumbnail col-md-6" style="background: #19D6E4 ;color:#3e3e3e !important; padding:15px;">
            <div class="row justify-content-center">
                <h4 class="text-white" style="padding-left:15px;"><i style="padding:10px;color:#19D6E4 !important;" class="text-dark img-thumbnail bg-white text-info fa fa-check"></i> Mise à jour du nom et du prénom</h4>
            </div>

        </div> <br>

        <div class="dropdown-divider"></div><br><br>

        <form method="POST" class="bg-white col-md-8 img-thumbnail" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" style="padding:10px;margin:auto;width:auto;">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstname">Prénom</label>
                        <input type="text" name="firstname" value="<?= $admin->firstname; ?>" class="form-control">
                        <small class="text-danger"><?= $firstnameError; ?></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastname">Nom</label>
                        <input type="text" name="lastname" value="<?= $admin->lastname; ?>" class="form-control">
                        <small class="text-danger"><?= $lastnameError; ?></small>
                    </div>
                </div>
               
            </div>
            <div class="form-actions">
                    <button style="cursor:pointer !important" type="submit" name="submit" class="btn btn-info btn-block font-weight-bold">Soumettre <i class="fa fa-check"></i></button>
                </div>
        </form> 
        
        
        
        


        
                 
                 

        </div>




    <!-- /#page-content-wrapper -->


</div>





<!-- /#wrapper -->

<!--Bootstrap Core Javascript at the end of the page to load page fastly-->

<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/popper.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/tooltip.js"></script>
<script type="text/javascript" src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/main.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.js"></script>
<!--<script type="text/javascript" src="../js/alert.js"></script>-->
<script type="text/javascript" src="../js/owl.carousel.min.js"></script>
<script type="text/javascript" src="../js/popper.min.js"></script>
<script type="text/javascript" src="../js/toast.js"></script>
<!--<script type="text/javascript" src="../js/tooltip.js"></script>-->
<script type="text/javascript" src="../js/util.js"></script>

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>


</body>



</html>





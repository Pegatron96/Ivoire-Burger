<?php


session_start();

require_once "../inc/functions.php";

//Fonction qui restreint l'accès de certaines pages du site aux utilisateurs non authentifiés

logged_only();

require_once "../inc/database.php";

$db = Database::connect();

$req = $db->query("SELECT * FROM users");

$customers = $req->rowCount();

$http = $db->query("SELECT * FROM users WHERE last_login > DATE_SUB(NOW(), INTERVAL 3 DAY)");

$active = $http->rowCount();

$req = $db->query("SELECT * FROM users WHERE confirmed_at IS NOT NULL");

$verified = $req->rowCount();

$req = $db->query("SELECT * FROM items");

$items = $req->rowCount();

$req = $db->query("SELECT * FROM categories");

$category = $req->rowCount();

$req = $db->query("SELECT SUM(price) AS price FROM items");

$prices = $req->fetch(PDO::FETCH_OBJ);

$requesting = $db->query("SELECT * FROM admin");

$req = $db->query("SELECT * FROM users WHERE confirmed_at IS NULL");

$unactive = $req->rowCount();

$super_user = $db->query("SELECT * FROM users WHERE last_login > DATE_SUB(NOW(), INTERVAL 1 DAY)");

$super_cust = $super_user->fetch(PDO::FETCH_OBJ);


?>


<!Doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="../img/tetra.jpg">
    <title>Ivoire Burger | Cpanel du site</title>
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
            <a href="coupons.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-credit-card"></i> Gestion des coupons</a>
            <a href="setting.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-cogs"></i> Paramètres</a>
            <a href="logout.php" class="text-center list-group-item list-group-item-action bg-light"><i class="fa fa-sign-out"></i> Déconnexion</a>

        </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <nav style="position: relative; bottom:5px ;background: #fff !important;" class="navbar navbar-expand-lg navbar-light bg-light border-bottom fixed-top">

            <button class="navbar-toggler-icon img-thumbnail" style="border: 50px !important;font-size: 20px; position: relative; left: 40px;"  id="menu-toggle"></button>



            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <h1 style="margin-left: 63px;text-transform: uppercase" class="text-center text-logo"><a href="<?= $_SERVER['PHP_SELF']; ?>"> Ivoire Burger </a></h1>
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
                <h4 style="padding-left:15px;"><i style="padding:10px" class="text-dark img-thumbnail bg-white fa fa-car"></i> Tableau de bord analytique</h4>
            </div>

        </div> <br>

        <div class="dropdown-divider"></div><br><br>
        <div class="row justify-content-center">
            <h4 style="font-family: 'Comic Sans MS', sans-serif">Quelques chiffres</h4>
        </div> <br>

        <div class="container">
        <div class="row" style="word-wrap: break-word">
            <div class="col-md-4 col-sm-6 text-white">
                <div class="img-thumbnail border" style="background:#3B4E76; padding:10px">
                    <div class="row">
                        <div class="col-md-6 font-weight-bold">
                            Clients total <br>
                            <span style="font-size: 13px; color:rgba(255,255,255,0.56);" class="font-weight-normal">Nombre total de clients</span>
                        </div>
                        <div class="col-md-6 text-right font-weight-bold" style="font-size:30px; vertical-align: middle">
                            <?= $customers ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-4 col-sm-6 text-white">
                <div class="img-thumbnail border" style="padding:10px; background:#2CB382">
                    <div class="row">
                        <div class="col-md-6 font-weight-bold">
                            Clients actifs <br>
                            <span style="font-size: 13px; color:rgba(255,255,255,0.56);">3 derniers jours</span>
                        </div>

                        <div class="col-md-6 text-right font-weight-bold" style="font-size:30px; vertical-align: middle;">
                               <?= $active; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 text-white">
                <div class="img-thumbnail border" style="padding:10px; background: #794C8A; margin-bottom: 7px;">
                    <div class="row">
                        <div class="col-md-6 font-weight-bold">
                            Comptes vérifiés
                            <span style="font-size: 11px; color:rgba(255,255,255,0.56);">Comptes clients vérifiés</span>
                        </div>
                        <div class="col-md-6 text-right font-weight-bold" style="font-size: 30px; vertical-align: middle">
                            <?= $verified; ?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4 col-sm-6">
                <div class="img-thumbnail border bg-warning" style="padding: 10px;">
                    <div class="row">
                        <div class="col-md-6 font-weight-bold">
                            Produits en ventes
                            <span class="font-weight-bold" style="font-size: 12px; color:rgba(0,0,0,0.65)">Produits total en ventes</span>
                        </div>
                        <div class="col-md-6 text-right font-weight-bold" style="font-size: 30px; vertical-align: middle">
                            <?= $items; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 text-white">
                <div class="img-thumbnail border bg-info" style="padding: 10px;">
                    <div class="row">
                        <div class="col-md-6 font-weight-bold">
                            Catégories totales
                            <span style="font-size: 11px; color:rgba(255,255,255,0.56);">Nombre total de catégories</span>
                        </div>
                        <div class="col-md-6 text-right font-weight-bold" style="font-size: 30px; vertical-align: middle">
                            <?= $category; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 text-white">
                <div class="img-thumbnail border bg-danger" style="padding: 10px;">
                    <div class="row">
                        <div class="col-md-6 font-weight-bold">
                            Prix total <br>
                            <span style="font-size: 11px; color:rgba(255,255,255,0.56);">Prix total produits</span>
                        </div>
                        <div class="col-md-6 text-right font-weight-bold" style="font-size: 25px; vertical-align: middle">
                            <?= $prices->price; ?> <span style="font-size: 15px;">F.CFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


        <div class="container">

            <div class="row" style="position:relative; left:430px; top:30px;">
                <div class="col-md-6"></div>
                <div class="col-md-6 text-justify">
                    <a class="text-dark" href="setting.php"><i class="fa fa-cog bg-warning" id="img" style="z-index: 4"></i></a>
                </div>
            </div>
            
            <div class="row" style="margin-top:35px;">
                <div class="col-md-7">
                   <div class="img-thumbnail">
                        <div class="text-center">
                                <h6 class="font-weight-bold">Administrateurs</h6>
                         </div>

                       <div style="margin-left:0px !important;" class="dropdown-divider"></div>
                       <div class="container">
                       <table style="padding:80px !important;" class="table-bordered table-striped">
                           <thead>
                                <tr class="text-center">
                                    <th style="text-transform: none;">Nom</th>
                                    <th style="text-transform: none;">Username</th>
                                    <th style="text-transform: none">E-mail</th>
                                    <th style="text-transform: none;">Fonction</th>
                                    <th style="text-transform: none">Dernière connexion</th>
                                </tr>
                           </thead>

                           <?php while($admin = $requesting->fetch(PDO::FETCH_OBJ)): ?>

                               <?php $newdate = preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#', '$3/$2/$1 à $4:$5', $admin->last_login) ?>
                               <tbody>
                                     <tr>
                                         <td style="font-size: 12px !important;"><?= $admin->lastname . " " . $admin->firstname; ?></td>
                                         <td style="font-size: 12px !important; text-transform: lowercase"><?= $admin->username;  ?></td>
                                         <td style="font-size: 12px !important; text-transform: lowercase"><?= $admin->email;  ?></td>
                                         <td style="font-size: 12px !important;"><?= $admin->Fonction; ?></td>
                                         <td style="font-size: 12px !important; text-transform: lowercase"><?= $newdate; ?></td>
                                    </tr>
                              </tbody>

                           <?php endwhile; ?>

                       </table>
                       </div>
                      

                   </div>  <br>
                   
                   <div class="row">
                        <div class="col-md-12" style="word-wrap:break-word !important">
                            <div class="img-thumbnail" style="word-wrap:break-word !important;">
                            <div class="text-center align-item-center">
                                <h6 class="font-weight-bold" style="text-transform:capitalize">Utilisateurs actifs</h6>
                            </div>
                            <div class="dropdown-divider"></div>
                                <table class="table table-bordered table-striped" style="word-wrap:break-word !important">
                                <thead>
                                    <tr class="text-center">
                    
                                        <th style="font-size:12px; text-transform:none;">Nom</th>
                                        <th style="font-size:12px;text-transform:none;">Email</th>
                                        <th style="font-size:12px;text-transform:none;">Ville</th>
                                        <th style="font-size:12px;text-transform:none;">Dernière commande</th>
                                        <th style="font-size:12px;text-transform:none;">Dernière connexion</th>
                                        <th style="font-size:12px;text-transform:none;">Status</th>
                                    </tr>
                                </thead>

                                <?php while($current_users = $http->fetch(PDO::FETCH_OBJ)):  ?>
                                
                                <?php $newdate2 = preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#', '$3/$2/$1 à $4:$5', $current_users->confirmed_command) ?>
                                <?php $newdate3 = preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#', '$3/$2/$1 à $4:$5', $current_users->last_login) ?>
                                <tbody>
                                    <tr>
                                    

                                        <?php if(strlen($current_users->firstname . " " . $current_users->lastname ) > 12):  ?>

                                        <td style="font-size:8px !important;display:inline-block"><?= $current_users->firstname . " " . $current_users->lastname; ?></td>

                                        <?php else:  ?>
                                        
                                        
                                          <td style="font-size:11px !important;display:inline-block"><?= $current_users->firstname . " " . $current_users->lastname; ?></td>

                                        <?php endif; ?>
                                        <td style="text-transform:lowercase; font-size:11px;"><?= $current_users->email; ?></td>

                                            <?php if(!empty($current_users->ville)): ?>

                                                <td style="text-transform:capitalize; font-size:11px;"><?= $current_users->ville; ?></td>

                                            <?php else: ?>   
                                           
                                            <td class="text-center" style="text-transform:capitalize; font-size:11px;">Non renseigner</td>                  

                                            <?php  endif; ?>

                                         <?php if($current_users->confirmed_command != "0000-00-00 00:00:00.000000"): ?>   

                                        <td style="text-transform:lowercase; font-size:11px;"><?= $newdate2; ?></td>

                                         <?php else: ?>

                                         <td class="text-center" style="text-transform:capitalize; font-size:11px;">Jamais</td>

                                        <?php endif; ?>

                                        <td style="text-transform:lowercase; font-size:11px;"><?= $newdate3; ?></td>

                                        <?php if($super_cust): ?>

                                         <td style="text-transform:lowercase;"><span style="font-size:7px !important; padding:1px !important; font-style:normal !important;" class="btn btn-success btn-xs font-weight-bold;">Super client</span></td>
                                          
                                        <?php else:  ?>

                                        <td style="text-transform:lowercase;"><span style="font-size:12px !important; padding:3px !important; font-style:normal !important;" class="btn btn-danger btn-xs font-weight-bold;">Inactif</span></td>

                                         <?php endif;  ?>
                                    </tr>
                                </tbody>

                                <?php endwhile; ?>


                                </table>

                                <?php if(empty($c)): ?>

                                    <div class="text-center mb-4">
                                        Aucun utilisateurs n'est actif
                                    </div>
                                <?php else: ?>



                                <?php  endif; ?>

                                <div class="justify-content-center text-center">
                                    <a href="<?= "users.php"; ?>" class="btn btn-secondary" data-toggle="tooltip" title="Gestion des utilisateurs">Voir plus..</a>
                                </div>


                                
                            </div>
                        </div>
                   </div>
                   
                   
                   
                    <br> <br>
                </div>

                <div class="col-md-5">
                    <div class="img-thumbnail">
                        <div class="text-center">
                            <h6 class="font-weight-bold">Ressources du serveur</h6>
                        </div>
                        <div style="margin-left: 0px;" class="dropdown-divider"></div>

                        <img style="width:330px; padding-left:70px;" src="../img/band.PNG" alt=""> <br> <br>

                        <?php

                        $connection = $db->query("SELECT * FROM users WHERE join_date > DATE_SUB(NOW(), INTERVAL 3 WEEK )");

                        $trial = $connection->rowCount();

                        $new_users_per = number_format((($trial / $customers) * 100), 0);

                        $activee = number_format((($active / $customers) * 100), 0);

                        $aunactivity = number_format((($unactive / $customers) * 100), 0);
                        
                        ?>

                        <div class="row" style="word-wrap: break-word; padding:15px;">

                            <div class="col-md-6">
                                <div class="row" style="font-size: 13px;">
                                    <div class="col-md-12">
                                        <p style="position:relative;top:15px; color:#6C757D"> <?= $new_users_per ?>% <span class="text-right" style="color:#C0C4C7">Nouveaux utilisateurs</span></p>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div data-toggle="tooltip" data-placement="bottom" title="Utilisateurs inscrit au cours des 3 dernières semaines" class="progress-bar bg-info progress-bar-striped" role="progressbar" style="width:<?= $new_users_per ?>%"></div>
                                </div> <br>
                            </div>

                            <div class="col-md-6">
                                <div class="row" style="font-size: 13px;">
                                    <div class="col-md-12">
                                        <p style="position:relative;top:15px; color:#6C757D"> <?= $activee ?>% <span class="text-right" style="color:#C0C4C7">Utilisateurs actifs</span></p>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div data-toggle="tooltip" data-placement="bottom" title="Utilisateurs dont la dernière connexion remonte à moins de 3 jours" class="progress-bar bg-danger progress-bar-striped" role="progressbar" style="width:<?= $activee; ?>%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="word-wrap: break-word; padding:15px;">
                        <div class="col-md-6">
                            <p style="color:#6C757D; position:relative; top:15px;">60% <span style="color:#C0C4C7">Allocation serveur</span></p>
                            <div class="progress">
                                <div data-toggle="tooltip" title="Configuration par défaut du serveur" class="progress-bar bg-warning progress-bar-striped" role="progressbar" style="width:60%"></div>
                            </div>
                        </div>
                            <div class="col-md-6">
                                <p style="color:#6C757D; position:relative; top:15px;"><?= $aunactivity; ?>% <span style="color:#C0C4C7">Comptes non confirmés</span></p>
                                <div class="progress">
                                    <div data-toggle="tooltip" title="Comptes non confirmés" class="progress-bar bg-secondary progress-bar-striped" role="progressbar" style="width:<?= $aunactivity; ?>%"></div>
                                </div> <br>
                            </div>
                        </div>

                    </div> <br> <br>
                </div>

            </div>
            
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





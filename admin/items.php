<?php


session_start();

require_once "../inc/functions.php";

//Fonction qui restreint l'accès de certaines pages du site aux utilisateurs non authentifiés

logged_only();

require_once "../inc/database.php";



?>


<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta author="Jude Ette">
    <meta content="application/vnd.noblenet-web">
    <title>Ivoire Burger - Admin | Liste des items</title>
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/jpg" href="../img/tetra.jpg">
    <!--Css Head Start-->
    <style>

        .text-logo
        {
            color: #e7480f;
            text-shadow: 2px 2px #ffd301;
            font-size:48px;
            padding:40px 0px;
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
            background: #fff;
            padding: 50px;
            border-radius: 10px;
        }

        .btn-info, .btn-warning, .btn-danger
        {
            font-size:13px;
        }

        .action-bar
        {
            background: rgba(232, 232, 232, 0.7);
            padding:15px;
            padding-top: 5px;
            padding-bottom: 5px;

        }

        .nav-link
        {
            color: #1b1e21;
        }

        .nav-link:hover
        {
            color: #1b1e21;
            background: rgba(134, 141, 148, 0.29);
        }

        input[type=search]
        {
            outline: none;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 300;
            margin-top:5px;
            background: transparent !important;
            border-radius:20px;
            color: #000 !important;
            padding-right: 19px;
            border: 2.4px solid #EDEDED;
            padding-left:15px;
            background: url(../img/search.PNG) no-repeat right !important;
            z-index: 2 ;
            width:330px;
            height:35px;
            transition: width 900ms;
            -webkit-transition: width 900ms;
            -moz-transition: width 900ms;
            -o-transition: width 900ms;
            -ms-transition: width 900ms;
            margin-left: 60px;
        }

        #main:hover
        {
            text-decoration: none;
            width:40px;
        }

        .stdc
        {
            font-size: 15px;
            background: #EFEFEF;
        }

        .stdc > a:hover, .stdc > li > a:hover
        {
            border-left: 4px #59D6E4 solid;
        }





    </style>
    <!--Css Head End-->
</head>
<body>

<a id="main" href="index.php"><h1 style="text-transform: uppercase" class="text-center text-logo"><i class="fa fa-cutlery"></i> Ivoire Burger administration <i class="fa fa-cutlery"></i></h1></a>
<div class="container admin">


    <div style="margin-top: -20px;" class="row">
        <div style="background: transparent; border:0px;" class="text-right action-bar img-thumbnail col-md-4">

        </div>
        <div style="background: transparent; border:0px;" class="text-right action-bar img-thumbnail col-md-4">

        </div>
        <div  class="text-center action-bar img-thumbnail col-md-4">
            <div style="cursor: pointer" class="dropdown-toggle" data-toggle="dropdown" data-placement="right" style="font-size:16px; font-weight:bold; color:#6C7278;"><span style="font-weight: normal">Connected as</span> <?php  echo $_SESSION['auth']['firstname'] . " " . $_SESSION['auth']['lastname']; ?> </div>
            <ul class="text-justify stdc dropdown-menu">
                <li class="dropdown-header">Espace Admin</li>
                <li class="dropdown-divider"></li>
                <li><a href="index.php" class="nav-link" ><i class="fa fa-dashboard"></i> Tableau de bord</a></li>
                <li class="dropdown-divider"></li>
                <li><a href="<?php echo 'profile.php?admin='. $_SESSION['auth']['firstname'] . $_SESSION['auth']['lastname'] ?>&role=<?php echo $_SESSION['auth']['Fonction'] ?>" style="font-weight: normal;" class="nav-link"><i class="fa fa-user-circle"></i> Profile </a></li>
                <li class="dropdown-divider"></li>
                <li><a href="setting.php" class="nav-link" ><i class="fa fa-cogs"></i> Paramètres </a></li>
                <li class="dropdown-divider"></li>
                <li><a class="nav-link" href="<?= 'users.php?admin='. $_SESSION['auth']['firstname'] . $_SESSION['auth']['lastname'] ?>&role=<?php echo $_SESSION['auth']['Fonction'] ?>"><i class="fa fa-users"></i> Gestion utilisateurs</a></li>
                <li class="dropdown-divider"></li>
                <li><a href="messenger.php" class="nav-link"><i class="fa fa-envelope-square"></i> Gestion des commandes</a></li>
                <li><a href="logout.php?session_end=true" class="nav-link"><i class="fa fa-sign-out"></i> Déconnexion </a></li>
            </ul>

            <div><?php echo $_SESSION['auth']['Fonction']; ?></div>
        </div>

    </div> <br> <br>

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






    <div class="row">
        <h2>Liste des items  <a href="insert.php" data-toggle="tooltip" title="Ajouter un item" class="btn btn-success btn-lg"> Ajouter <i class="fa fa-plus"></i> </a> </h2>
        <div style="margin-left:15px;">
            <form method="GET" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <input class="text-justify img-thumbnail" data-toggle="tooltip" title="Recherchez le nom d'un item, d'une catégorie, d'une description.." type="search" name="search" id="search" placeholder="Rechercher un item...">
            </form> <br><br>
        </div>
    </div>
    <?php if(empty($_GET)): ?>


        <table class="col-md-12 col-md-offset-2 table table-striped table-bordered">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Catégorie</th>

                <th>Actions</th>
            </tr>
            </thead>

            <tbody style="font-size:15px;">
            <?php

            $db = Database::connect();

            $req = $db->query("SELECT items.id, items.name, items.description, items.price, categories.name 
                             AS category FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC");

            while($item = $req->fetch(PDO::FETCH_ASSOC))
            {
                echo "<tr>";
                echo "<td>" . $item['name'] . "</td>";
                echo "<td>" . $item['description'] . "</td>";
                echo "<td>" . $item['price'] . "</td>";
                echo "<td>" . $item['category'] . "</td>";
                echo "<td width=300>";
                echo '<a data-toggle="tooltip" title="Cliquez sur ce boutton pour afficher ce produit" class="btn btn-info" href="view.php?id=' . $item['id'] . '">Voir <i class="fa fa-eye"></i></a>';
                echo " ";
                echo '<a data-toggle="tooltip" title="Cliquez sur ce boutton pour modifier ce produit" class="btn btn-warning" href="update.php?id=' . $item['id'] . '">Modifier <i class="fa fa-pencil"></i></a>';
                echo " ";
                echo '<a data-toggle="tooltip" title="Cliquez sur ce boutton pour supprimer ce produit" class="btn btn-danger" href="delete.php?id=' . $item['id'] . '">Supprimer <i class="fa fa-remove"></i></a>';
                echo "</td>";
                echo "</tr>";

            }


            Database::disconnect();

            ?>



            </tbody>

        </table> <br>

        <div class="row">
            <a href="javascript:history.back()"><i aria-disabled="true" style="font-size:22px; font-weight:bold; padding:10px" class="disabled text-white img-thumbnail fa fa-angle-left bg-info"></i></a>
            <a href="<?= $_SERVER['PHP_SELF']; ?>" data-toggle="tooltip" title="Vous vous trouvez sur la page de gestion des items" style="margin:auto; width:auto; font-weight:bold; padding:10px;" class="nav-link text-center bg-info img-thumbnail text-white">1</a>
            <a data-toggle="tooltip" title="Page de gestion des utilisateurs" href="<?= 'users.php?Admin=' . $_SESSION['auth']['firstname'] . $_SESSION['auth']['lastname']; ?>&role=<?= $_SESSION['auth']['Fonction']; ?>"><i style="font-size:22px; font-weight:bold; padding:10px" class="text-white img-thumbnail fa fa-angle-right bg-info"></i></a>
        </div>

    <?php elseif(!empty($_GET)): ?>

    <?php

    $result = preg_replace("#[^a-zA-Z ?0-9]#i", "", $_GET['search']);



    $db = Database::connect();

    $req = $db->prepare("SELECT items.id AS id, items.name AS namee, items.description AS descript, items.price AS price, categories.name AS category FROM items INNER JOIN categories ON items.category = categories.id WHERE items.name LIKE ? OR items.description LIKE ? OR items.price LIKE ? OR category LIKE ? ORDER BY items.id DESC");

    $req->execute(['%'. $result . '%', '%' . $result . '%', '%'. $result . '%', '%' . $result . '%']);

    $count = $req->rowCount();

    ?>

    <?php  if($count >= 1): ?>

        <h4 class="text-center" style="color: rgba(0, 0, 0, 0.66);"><?php echo $count . " " . "résultat(s) trouvé(s) pour" . " " . "<span style='text-transform: capitalize'>" . $result . "</span>"; ?> </h4><br>


        <div class="row">



            <table style="margin:auto !important; width:auto !important;" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Catégorie</th>

                    <th>Actions</th>
                </tr>
                </thead>

                <tbody style="font-size:16px;">
                <?php

                while($item = $req->fetch(PDO::FETCH_ASSOC))
                {
                    echo "<tr>";
                    echo "<td>" . $item['namee'] . "</td>";
                    echo "<td>" . $item['descript'] . "</td>";
                    echo "<td>" . $item['price'] . "</td>";
                    echo "<td>" . $item['category'] . "</td>";
                    echo "<td width=300>";
                    echo '<a data-toggle="tooltip" title="Cliquez sur ce boutton pour afficher ce produit" class="btn btn-info" href="view.php?id=' . $item['id'] . '">Voir <i class="fa fa-eye"></i></a>';
                    echo " ";
                    echo '<a data-toggle="tooltip" title="Cliquez sur ce boutton pour modifier ce produit" class="btn btn-warning" href="update.php?id=' . $item['id'] . '">Modifier <i class="fa fa-pencil"></i></a>';
                    echo " ";
                    echo '<a data-toggle="tooltip" title="Cliquez sur ce boutton pour supprimer ce produit" class="btn btn-danger" href="delete.php?id=' . $item['id'] . '">Supprimer <i class="fa fa-remove"></i></a>';
                    echo "</td>";
                    echo "</tr>";

                }



                ?>

                </tbody>

            </table>








        </div>

    <?php else:  ?>

        <h4 class="text-center" style="color: rgba(0, 0, 0, 0.66);"><?php echo "Oups... désolé aucun résultat ne correspond à <strong style='text-transform:capitalize'>$result</strong>"; ?></h4> <br> <br> <br> <br> <br> <br>





    <?php endif; ?>

    <?php Database::disconnect(); ?>
    <a href="javascript:history.back()">
        <button data-toggle="tooltip" title="Revenir à la page précédente" style="position: relative; top:20px; margin-top: 25px; !important; width:auto !important;" type="button" class="btn btn-success">
            Page précédente
            <i class="fa fa-arrow-circle-o-left"></i>
        </button>
    </a>
</div>
<?php endif; ?>

</div>
</div>  <br> <br> <br>
<?php require_once "../inc/footer.php" ?>

<!--Bootstrap Core Javascript-->

<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" type="text/javascript" src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" type="text/javascript" src="../js/main.js"></script>
<script type="text/javascript" type="text/javascript" src="../js/bootstrap.bundle.js"></script>
</body>



</html>
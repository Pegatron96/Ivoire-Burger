<?php

session_start();
require_once "panier.class.php";
require_once "inc/database.php";

if(isset($_POST['see'])):

    header("Location: cart.php");

endif;

?>


<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" width="device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="img/tetra.jpg">
    <title>Ivoire Burger | Désserts</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/preloader.css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="vendor/animate/animate.css">
    <style>
        .site
        {
            /*@font-face
                src: url("fonts/poppins/Poppins-Black.ttf") format("ttf");*/
            font-family: 'algerian', sans-serif;
        }

        .nav-link
        {
            color:#fff;
            text-shadow: 2px 2px #333;
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
            font-size:48px;
            padding:40px 0px;

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
            background: rgba(255, 193, 7, 0.28);
            border-radius:20px;
            color: #fff !important;
            padding-right: 19px;
            border: 1px solid #fff;
            padding-left:8px;
            background: url(img/searched.PNG) no-repeat right;
            width:33px;
            transition: width 900ms;
            -webkit-transition: width 900ms;
            -moz-transition: width 900ms;
            -o-transition: width 900ms;
            -ms-transition: width 900ms;



        }

        input[type=search]:focus
        {
            width:180px;

        }

        #search
        {
            color:#fff;
        }

        #res
        {
            color: rgba(0, 0, 0, 0.66);
            font-family: sans-serif;
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

        .btn-ordered
        {
            border: 1px solid #e7480f;
            color: #e7480f;
        }

        .btn-ordered:hover
        {
            background: #c13c0d;
            border: 0px;
            color: #fff;
            text-shadow: 2px 2px #333;
        }
    </style>


</head>
<body>

<div id="preloader">

    <!--Title-->

    <h2 class="text-white text-center">Patientez Quelques instant...</h2> <br><br>


    <!--Animation preloader-->

    <div class="loading-spinner"></div>




    <div class="loading-dots"><br><br><br><br>

        <div class="bounce"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>

    </div>



</div>
<div class="container site">
    <h1 style="text-transform: uppercase" class="text-center text-logo"><i class="fa fa-cutlery"></i> Ivoire Burger <i class="fa fa-cutlery"></i></h1>

    <nav style="background:rgba(255, 193, 7, 0.589);" class="img-thumbnail">
        <ul style="margin-left:25px; width:auto; " class="nav nav-pills" id="pills-tab" role="tablist">
            <li role="presentation" class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="menus.php">Menus</a></li>
            <li role="presentation" class="nav-item active"><a class="nav-link" href="burgers.php"> Burgers</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="snacks.php">Snacks</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="salades.php">Salades</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="boissons.php">Boissons</a></li>
            <li role="presentation" class="nav-item"><a style="background: #e7480f;" class="nav-link active" href="desserts.php">Désserts</a></li>
            <li role="presentation" class="nav-item"><a class="cart nav-link" href="cart.php"><i class="fa fa-shopping-cart"></i></a></li>

            <?php if(isset($_SESSION['auth'])): ?>

                <li class="nav-item user nav-link"> <i class="fa fa-users dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></i>
                    <ul style="font-family:sans-serif; text-shadow: none" class="drop text-justify dropdown-menu">
                        <li class="text-center"><?php echo "Bonjour,". " " . $_SESSION['auth']['lastname']; ?></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="users/account.php"><i class="fa fa-user-circle"></i> Mon compte</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="whishlist.php"><i class="fa fa-heart-o"></i> Liste d'envie</a> </li>
                        <li class="dropdown-divider"></li>
                        <li><a href="users/checkout.php"><i class="fa fa-dropbox"></i> Mes commandes</a> </li>
                        <li class="dropdown-divider"></li>
                        <li><a href="users/logout.php"><i class="fa fa-sign-out"></i> Déconnexion</a></li>
                    </ul>
                </li>

            <?php else: ?>

                <li class="nav-item user nav-link"> <i class="fa fa-users dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></i>
                    <ul style="font-family:sans-serif; text-shadow: none" class="drop text-justify dropdown-menu">
                        <li><a href="users/login.php"><i class="fa fa-sign-in"></i> Connexion</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="users/register.php"><i class="fa fa-arrow-circle-right"></i> Inscription</a></li>
                    </ul>
                </li>

            <?php endif; ?>
            <li role="presentation" class="nav-item">
                <form method="GET" action="desserts.php">
                    <input class="img-thumbnail" type="search" name="search" id="search" placeholder="Effectuer une recherche...">
                </form>
            </li>
        </ul>
    </nav> <br><br><br>
    <i class="fa fa-sign-out"></i>

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

    <div style="margin-top:30px;" id="pills-tabContent" class="tab-content">
        <div class="tab-pane fade show active" role="tabpanel" id="6">
            <div class="row">

                <?php if(empty($_GET)): ?>

                <?php

                require_once "inc/database.php";

                $db = Database::connect();

                $req = $db->query("SELECT items.id, items.name, items.description, items.image, items.price
                FROM items WHERE items.category = 6 ORDER BY items.id DESC");

                while($item = $req->fetch()):

                ?>

                    <div class="col-sm-6 col-md-4">
                        <div class="img-thumbnail">
                            <a href="view.php?id=<?= $item['id'] ?>"><img class="col-md-9 col-sm-8" src="<?php echo 'img/'. $item['image']; ?>" alt="untitled"></a>
                            <div class="price"><?php echo $item['price']; ?> F.CFA</div>
                            <div class="caption">
                                <h4><?php echo $item['name']; ?></h4>
                                <p><?php echo $item['description']; ?></p>
                                <a data-toggle="modal" data-target="#monModal" href="addpanier.php?id=<?= $item['id'] ?>" class="addpanier form-control btn btn-order" role="button"><i class="fa fa-shopping-cart"></i> Ajouter au panier</a>
                            </div>
                        </div> <br>
                    </div>



                    <div class="modal fade" id="monModal" style="font-family: sans-serif">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4  class="text-white btn btn-order modal-title"><i style="font-size:20px;" class="fa fa-info"></i> Informations</h4>
                                    <button style="transform: rotate(45deg); font-size: 39px; position:relative; bottom:20px; left:10px;" type="button" class="close" data-dismiss="modal">+</button>
                                </div>
                                <div class="modal-body justify-content-center text-center"></div> <span style="color: #e7480f;font-size: 30px;" class="text-center c"></span>
                                <div class="modal-footer">
                                    <form method="POST">
                                        <input type="submit" class="btn btn-order" value="Voir panier" name="see">
                                        <button id="link" type="button" class="btn btn-ordered" data-dismiss="modal">Continuer mes achats</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>

                <?php Database::disconnect(); ?>

                <?php elseif(!empty($_GET)): ?>


                    <div style="background: #fff; border-radius: 15px; padding:20px; padding-left:25px; margin-top: 45px;" class="container res">

                        <?php

                        $result = preg_replace("#[^a-zA-Z ?0-9]#i","", $_GET['search']);

                        require_once  "inc/database.php";

                        $db = Database::connect();

                        $req = $db->prepare("SELECT items.id, items.name, items.price, items.description, items.image FROM items WHERE items.category LIKE ? OR items.name LIKE ? OR items.description LIKE ? OR items.price LIKE ? ORDER BY items.price");

                        $req->execute(['%'. $result . '%', '%' . $result . '%', '%'. $result . '%', '%' . $result . '%']);

                        $count = $req->rowCount();

                        // if($count >= 1)
                        // {
                        //echo "$count résultat(s) trouvé(s) pour $result";
                        // }else{
                        //  echo "0 résultat trouvé";
                        // }
                        ?>

                        <?php  if($count >= 1): ?>

                            <h1 id="res"><?php echo "$count résultat(s) trouvé(s) pour $result"; ?> </h1><br> <br><br>
                            <div class="row">
                                <?php while($item = $req->fetch()): ?>


                                    <div class="col-md-4 col-sm-6 ">
                                        <div class="img-thumbnail">
                                            <a href="view.php?id=<?= $item['id'] ?>"><img class="col-md-9 col-sm-8" src="<?php echo 'img/'. $item['image']; ?>" alt="untitled"></a>
                                            <div class="price"><?php echo $item['price']; ?> F.CFA</div>
                                            <div class="caption">
                                                <h4><?php echo $item['name']; ?></h4>
                                                <p><?php echo $item['description']; ?></p>
                                                <a data-toggle="modal" data-target="#monModal" href="addpanier.php?id=<?= $item['id'] ?>" class="addpanier form-control btn btn-order" role="button"><i class="fa fa-shopping-cart"></i> Ajouter au panier</a>
                                            </div>
                                        </div> <br>
                                    </div>

                                    <div class="modal fade" id="monModal" style="font-family: sans-serif">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4  class="text-white btn btn-order modal-title"><i style="font-size:20px;" class="fa fa-info"></i> Informations</h4>
                                                    <button style="transform: rotate(45deg); font-size: 39px; position:relative; bottom:20px; left:10px;" type="button" class="close" data-dismiss="modal">+</button>
                                                </div>
                                                <div class="modal-body justify-content-center text-center"></div> <span style="color: #e7480f;font-size: 30px;" class="text-center c"></span>
                                                <div class="modal-footer">
                                                    <form method="POST">
                                                        <input type="submit" class="btn btn-order" value="Voir panier" name="see">
                                                        <button id="link" type="button" class="btn btn-ordered" data-dismiss="modal">Continuer mes achats</button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>







                                <?php endwhile; ?>
                            </div>

                        <?php else:  ?>

                            <h1 style="padding-bottom: 200px;" id="res"><?php echo "Oups... désolé aucun résultat ne correspond à <strong style='text-transform:capitalize'>$result</strong>"; ?></h1> 
                            <div class="text-center col-md-12 col-lg-12">
                                
                                <img style="width:400px" class="img-responsive" src="img/tenor.gif" style="position:absolute; bottom:500px !important;">

                            </div>
                            
                            <br> <br> <br> <br> <br> <br>





                        <?php endif; ?>


                        <?php Database::disconnect(); ?>
                    </div>
                <?php endif; ?>








            </div><br><br><br>

        </div>

    </div>

</div>

<?php require_once  "inc/footer.php";  ?>


    <!--Bootstrap Core Javascript at the end of the code to load page fastly-->

<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="vendor/bootstrap/js/popper.js"></script>
<script type="text/javascript" src="vendor/bootstrap/js/tooltip.js"></script>
<script type="text/javascript" src="vendor/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="js/alert.js"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/toast.js"></script>
<script type="text/javascript" src="js/tooltip.js"></script>
<script type="text/javascript" src="js/util.js"></script>
<script src="js/app.js"></script>
<script>

    //Enable Preloader with JQUERY

    $(document).ready(function (){
        $(".site").hide();
        $(".footer-area").hide();
        $("#preloader").fadeOut(2000, function(){
            $(".site").fadeIn(1000);
            $(".footer-area").fadeIn(1000);
        });
    });
</script>

</body>



</html>
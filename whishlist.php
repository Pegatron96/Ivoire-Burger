<?php

session_start();

require_once "_header.php";
include "inc/functions.php";


if(isset($_GET['del']))
{
    $whish->del($_GET['del']);
}

if(isset($_POST['see']))
{
    header("Location: cart.php");
}

logged_whish_only();



?>

<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="img/tetra.jpg">
    <title>Ivoire Burger | Votre liste d'envies</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/preloader.css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="vendor/animate/animate.css">
    <script>
        $(function (){
            $("#tool").tooltip();
        });
    </script>

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

        .panier
        {
            background: #fff;
            font-family: sans-serif;
            font-weight: bold !important;
            padding: 40px !important;
        }

        .text-order
        {
            color: #e7480f;
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
        <ul style="margin-left:25px; width:auto;" class="nav nav-pills" id="pills-tab">
            <li role="presentation" class="nav-item"><a class="nav-link" id="pills-menus-tab" href="index.php">Accueil</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" id="pills-menus-tab" href="index.php">Menus</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="burgers.php"  id="pills-burgers-tab"> Burgers</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="snacks.php" id="pills-snacks-tab">Snacks</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="salades.php" id="pills-salades-tab">Salades</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="boissons.php" id="pills-boissons-tab">Boissons</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="desserts.php" id="pills-desserts-tab">Désserts</a></li>
            <li role="presentation" class="nav-item"><a class="cart nav-link" href="cart.php" id="pills-desserts-tab"><i class="fa fa-shopping-cart"></i></a></li>
            <?php if(isset($_SESSION['auth'])): ?>

                <li class="nav-item user nav-link"> <i class="fa fa-users dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></i>
                    <ul style="font-family:sans-serif; text-shadow: none" class="drop text-justify dropdown-menu">
                        <li class="text-center" style="text-transform: capitalize"><?php echo "Bonjour,". " " . $_SESSION['auth']['lastname']; ?></li>
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
                <form method="GET" action="menus.php">
                    <input class="img-thumbnail" type="search" name="search" id="search" placeholder="Effectuer une recherche...">
                </form>
            </li>

        </ul>
    </nav> <br><br> <br>

    <?php if(isset($_SESSION['flash'])):  ?>

        <?php foreach($_SESSION['flash'] as $type => $message):  ?>

            <div style="font-family: sans-serif;" class="text-center alert alert-<?= $type; ?> alert-dismissible fade show" role="alert">
                <?= $message;  ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        <?php endforeach; ?>

        <?php unset($_SESSION['flash']);  ?>

    <?php endif;  ?>

    <div style="margin-top:30px;" id="pills-tabContent" class="tab-content">
        <div class="tab-pane fade show active" role="tabpanel" id="5">
            <div class="row">



                <?php if(!empty($_SESSION['whish'])): ?>

                    <div class="img-thumbnail container panier">

                        <?php if($whish->count() == 1): ?>

                            <h2>Mes produits mis de coté <i class="fa fa-heart-o"></i> (<?= $whish->count(); ?> produit)</h2> <br>

                        <?php else: ?>

                        <h2>Mes produits mis de coté <i class="fa fa-heart-o"></i> (<?= $whish->count(); ?> produits)</h2> <br>

                        <?php endif; ?>

                        <table class="table-bordered table-striped col-md-12">
                            <thead style="color: #9D95A6">
                            <tr>
                                <th class="text-center">ARTICLES</th>
                                <th class="text-center">QUANTITE</th>
                                <th class="text-center">PRIX UNITAIRE</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center">ACTIONS</th>
                            </tr>
                            </thead>


                            <tbody>

                            <?php

                            $ids = array_keys($_SESSION['whish']);

                            if(empty($ids))
                            {
                                $products = array();
                            }
                            else{
                                //J'ai galérer pour trouver la bonne syntaxe de cette requête Mdr :D

                                $products = $database->query('SELECT * FROM items WHERE id IN ('.implode(',',$ids).')');

                            }

                            ?>

                            <?php foreach($products as $product): ?>

                                <tr class="img-thumbnail">
                                    <td><div style="padding-left:20px"><img style="width:60px; height:60px;" src="img/<?= $product->image ?>">  <?= $product->name; ?><br> <a class="addpanier" data-toggle="modal" data-target="#monModal" href="addpanier.php?id=<?= $product->id; ?>"><i data-toggle="tooltip" title="Ajouter au panier" style="position: relative; left: 50px; bottom:6px;" class="text-order fa fa-cart-plus"></i></a> </div>
                                    <td class="text-center"><div class="quantity"><?= $_SESSION['whish'][$product->id] ; ?></div></td>
                                    <td class="text-center"><div class="pricee"><?= $product->price ?> F.CFA</div></td>
                                    <td class="text-center" style="color: #e7480f"><div class="total"><?= $product->price * $_SESSION['whish'][$product->id]; ?> F.CFA</div></td>
                                    <td class="text-center"><a style="color: #e7480f; font-size: 18px" href="whishlist.php?del=<?= $product->id; ?>" class="del"><i id="tool" data-toggle="tooltip" title="Retirer de la liste d'envie" class="fa fa-remove"></i></a></td>
                                </tr>
                            <?php endforeach;  ?>

                            <div class="modal fade" id="monModal" style="font-family: sans-serif; font-weight: normal !important;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4  class="text-white btn btn-order modal-title"><i style="font-size:20px;" class="fa fa-info"></i> Informations</h4>
                                            <button style="transform: rotate(45deg); font-size: 39px; position:relative; bottom:20px; left:10px;" type="button" class="close" data-dismiss="modal">+</button>
                                        </div>
                                        <span class="modal-body justify-content-center text-center"></span> <span style="color: #e7480f;font-size: 30px;" class="text-center c"></span>
                                        <div class="modal-footer">
                                            <form method="POST">
                                                <input type="submit" class="btn btn-order" value="Voir panier" name="see">
                                                <button id="link" type="button" class="btn btn-ordered" data-dismiss="modal">Continuer mes achats</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>



                            </tbody>


                        </table><br>
                        <div class="text-right" style="font-weight: bold; font-size: 20px">Total : <span style="color: #e7480f"><?= $whish->total(); ?> F.CFA</span></div> <br>


                        <div class="row img-thumbnail bg-white justify-content-end" style="padding:10px;">
                            <a style="position:relative; right:10px; background: #E2E6EA !important; color: #e7480f" class="btn btn-light img-thumbnail" href="index.php">CONTINUER VOS ACHATS</a>

                            <a class="btn btn-order img-thumbnail" href="cart.php">ACHETER</a>
                        </div>





                    </div>
                <?php else: ?>

                    <div style="background: #F5F5F5 !important;" class="img-thumbnail container panier text-center">
                        <h2 class="text-left">Liste d'envie </h2>
                        <h5 style="color:#3e3e3e;">Vous n'avez aucun produits mis de côté <?= $_SESSION['auth']['lastname'] ?> !</h5> <br>

                        <i style="font-size:250px;" class="fa fa-heartbeat"></i> <br><br>
                        <a href="index.php" class="btn btn-order btn-md">METTRE DES PRODUITS DE COTE</a>

                    </div>

                <?php endif; ?>






            </div> <br> <br> <br>

        </div>

    </div>

</div>

<?php require_once  "inc/footer.php";  ?>


<!--Bootstrap Core Javascript-->

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


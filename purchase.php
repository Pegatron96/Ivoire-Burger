<?php

session_start();

//define(The_Coder, "Jude Ette");

require_once "_header.php";
require_once "inc/database.php";
require_once "inc/functions.php";


users_logged_only();

cart_only();

//Refactorisation => better to use fetch value than session value for a better user experience

$users = $database->query("SELECT * FROM users WHERE id=:id", array('id' => $_SESSION['auth']['id']));

$ids = array_keys($_SESSION['panier']);

if(empty($ids))
{
    $products = array();
}
else{
    //J'ai galérer pour trouver la bonne syntaxe de cette requête Mdr :D

    $products = $database->query('SELECT * FROM items WHERE id IN ('.implode(',',$ids).')');
}

if(isset($_POST['pay']))
{
    $payment = verifyInput($_POST['payment']);

    $db = Database::connect();

    $req = $db->prepare("UPDATE users SET payment_type = ? WHERE id = ?");

    $req->execute([$payment, $_SESSION['auth']['id']]);
}

if(isset($_POST['zulu']))
{
    header("Location: confirm.php");
}

?>


<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="img/tetra.jpg">
    <title>Ivoire Burger | Confirmation de commande</title>
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

        .delivery
        {
            background: #fff;
            padding: 10px !important;

        }

        h8, .addresse, .phone, .dev
        {
            padding-left: 35px;
        }

        .addresse, .phone, .dom
        {
            font-size: 15px;
            color: #5f5c5b;
        }

        .dev
        {
            font-size: 17px;
            color: #2b2b2b;
        }

        .pricee
        {
            color: #e7480f;
            padding-left: 40px;
            position:relative;
            bottom: 15px;
            font-size:13px;
        }

        .quantity
        {
            padding-left: 40px;
            position:relative;
            bottom:15px;
            color: #696b77;
            font-size:14px;
        }

        .total
        {
            font-weight: bold;
        }

        #back
        {
            position:relative;
            left:50px;
            vertical-align: middle;
        }

        .fa-angle-right
        {
            font-size: 19px !important;
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
            <li role="presentation" class="nav-item"><a class="nav-link" href="desserts.php">Désserts</a></li>
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

            <div style="font-family: sans-serif" class="text-center alert alert-<?= $type; ?> alert-dismissible fade show" role="alert">
                <?= $message;  ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        <?php endforeach; ?>

        <?php unset($_SESSION['flash']);  ?>

    <?php endif;  ?>

    <div style="margin-top:25px;" >
        <div id="6">
            <div class="row">

                <?php if(empty($_GET)): ?>

                <?php  foreach($users as $user): ?>

                <div class="container" style="font-family: sans-serif;">
                    <div class="row">
                        <div class="col-md-8">
                            <div style="background: #fff" class="img-thumbnail">
                                <div class="row">
                                    <?php if(!empty($user->payment_type)): ?>
                                        <h8 class="col-md-6 text-dark font-weight-bold"><img src="img/validate.PNG" alt="" class="small_image"> 3. MODE DE PAIEMENT</h8>
                                        <h8 data-toggle="modal" data-target="#buy" style="cursor: pointer; color: #e7480f" class="text-right col-md-6 font-weight-bold">MODIFIER</h8>

                                        <div class="modal fade" id="buy" style="font-family: sans-serif">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title text-center"><i style="font-size:20px;"></i> Choix du mode de paiement <i class="fa fa-money"></i></h3>
                                                        <button style=" position:relative; bottom:20px;transform: rotate(45deg); font-size:40px;" type="button" class="close" data-dismiss="modal">+</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                            <div class="form-group">
                                                                <label for="payment"></label>
                                                                <select name="payment" class="form-control">
                                                                    <?php if(!empty($user->payment_type)): ?>

                                                                        <option value="<?= $user->payment_type; ?>" selected><?= $user->payment_type; ?></option>
                                                                        <option value="Payer cash à la livraison">Payer cash à la livraison</option>
                                                                        <option value="Orange Money">Payer par Orange Money</option>
                                                                        <option value="MTN Mobile Money">Payer par MTN Mobile Money</option>
                                                                        <option value="Paypal">Payer avec Paypal</option>

                                                                    <?php else: ?>

                                                                        <option value="Payer cash à la livraison">Payer cash à la livraison</option>
                                                                        <option value="Orange Money">Payer par Orange Money</option>
                                                                        <option value="MTN Mobile Money">Payer par MTN Mobile Money</option>
                                                                        <option value="Paypal">Payer avec Paypal</option>

                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">

                                                        <button name="pay" type="submit" class="btn btn-order btn-block" >ENREGISTRER</button>
                                                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->

                                                    </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>

                                    <?php elseif(empty($user->payment_type)): ?>

                                        <h8 class="col-md-6 text-dark font-weight-bold"><img src="img/unvalidate.PNG" alt="" class="small_image"> 3. MODE DE PAIEMENT</h8>
                                        <h8 data-toggle="modal" data-target="#pay" style="cursor: pointer; color: #e7480f" class="text-right col-md-6 font-weight-bold">AJOUTER</h8>

                                        <div class="modal fade" id="pay" style="font-family: sans-serif">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title text-center"><i style="font-size:20px;"></i> Choix du mode de paiement <i class="fa fa-money"></i></h3>
                                                        <button style=" position:relative; bottom:20px;transform: rotate(45deg); font-size:40px;" type="button" class="close" data-dismiss="modal">+</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                                            <div class="form-group">
                                                                <label for="payment"></label>
                                                                <select name="payment" class="form-control">
                                                                    <?php if(!empty($user->payment_type)): ?>

                                                                        <option value="<?= $user->payment_type; ?>" selected><?= $user->payment_type; ?></option>
                                                                        <option value="Payer cash à la livraison">Payer cash à la livraison</option>
                                                                        <option value="Orange Money">Payer par Orange Money</option>
                                                                        <option value="MTN Mobile Money">Payer par MTN Mobile Money</option>
                                                                        <option value="Paypal">Payer avec Paypal</option>

                                                                    <?php else: ?>

                                                                        <option value="Payer cash à la livraison">Payer cash à la livraison</option>
                                                                        <option value="Orange Money">Payer par Orange Money</option>
                                                                        <option value="MTN Mobile Money">Payer par MTN Mobile Money</option>
                                                                        <option value="Paypal">Payer avec Paypal</option>

                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">

                                                        <button name="pay" type="submit" class="btn btn-order btn-block" >ENREGISTRER</button>
                                                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->

                                                    </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>


                                    <?php endif; ?>
                                </div>
                                <div class="dropdown-divider"></div>

                                <?php if($user->payment_type == "Payer cash &agrave; la livraison"): ?>

                                    <p class="dev font-weight-bold"><?= $user->payment_type; ?> <i class="fa fa-money"></i></p>

                                <?php elseif($user->payment_type == "Orange Money"): ?>

                                    <p class="dev font-weight-bold"><?= $user->payment_type; ?> <img class="small_image" style="border-radius:2px;" src="img/orange-money.jpg" alt=""></p>

                                <?php elseif($user->payment_type == "MTN Mobile Money"): ?>

                                    <p class="dev font-weight-bold"><?= $user->payment_type; ?> <img class="small_image" style="border-radius:2px;" src="img/mtn-money.jpg" alt=""></p>

                                <?php elseif($user->payment_type == "Paypal"): ?>

                                    <p class="dev font-weight-bold"><?= $user->payment_type; ?> <img class="small_image" style="border-radius:2px;" src="img/mtn-money.jpg" alt=""></p>

                                <?php else: ?>

                                    <p class="dev">Complètez les étapes précédentes avant de continuer</p>

                                <?php endif; ?> <br>

                                <?php if(!empty($user->adress) && !empty($user->phone) && !empty($user->region) && !empty($user->ville) && !empty($user->delivery_mode) && !empty($user->payment_type)):  ?>

                                    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <button type="submit" name="zulu" class="btn btn-order btn-block">ETAPE SUIVANTE <i class="fa fa-arrow-circle-right"></i></button>
                                    </form>

                                <?php else: ?>

                                    <button type="button" class="btn btn-outline-secondary btn-block">Complètez les étapes précédentes avant de continuer</button>

                                <?php endif; ?> <br>


                            </div> <br>





                        </div><br>
                        <div class="col-md-4">
                            <div class="delivery img-thumbnail">
                                <h8 style="color:#B2AEB1; text-transform: uppercase;" class="font-weight-bold">résumé</h8><br>
                                <h8 class="content font-weight-bold">VOTRE COMMANDE (<?= $panier->count(); ?> produits)</h8>
                                <div class="dropdown-divider"></div>

                                <?php

                                $ids = array_keys($_SESSION['panier']);

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

                                    <div class="row">
                                        <img style="width:60px; height:60px;" src="img/<?= $product->image ?>" alt="">  <?= $product->name; ?>
                                    </div>
                                    <div class="pricee">Pu: <?= $product->price ?> F.CFA | Total: <?= $product->price * $_SESSION['panier'][$product->id]; ?> F.CFA</div>
                                    <div class="quantity"> Qté: <?= $_SESSION['panier'][$product->id] ; ?></div>
                                    <div class="dropdown-divider"></div>

                                <?php endforeach; ?>
                                <div class="total row">
                                    <div class="col-md-6">
                                        <h8>Grand Total :</h8>
                                    </div>
                                    <div class="col-md-6">
                                        <h8><?= $panier->total(); ?> F.CFA</h8>
                                    </div>
                                </div>
                            </div> <br>
                            <a id="back" href="javascript:history.back()" class="btn btn-ordered btn-lg"><i class="fa fa-arrow-circle-o-left"></i> Revenir au panier <i class="fa fa-shopping-cart"></i></a>

                        </div>
                    </div>

                </div>

            </div>


            <?php endforeach; ?>



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
                                                <button style="transform: rotate(45deg)" type="button" class="close" data-dismiss="modal">+</button>
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

                            <img class="img-responsive" src="img/tenor.gif" style="width:400px; position:absolute; bottom:500px !important;">

                        </div>

                        <br> <br> <br> <br> <br> <br>





                    <?php endif; ?>


                    <?php Database::disconnect(); ?>
                </div>
            <?php endif; ?>


        </div>
    </div><br><br><br>
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
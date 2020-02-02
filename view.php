<?php


session_start();
require_once "panier.class.php";
require_once "inc/database.php";
require_once "inc/functions.php";
require_once  "inc/functions.class.php";
require_once "_header.php";

use Functions\Functions;

$db = Database::connect();

if(isset($_POST['see'])):

    header("Location: cart.php");

endif;

Functions::login();

$functions = new Functions();

$functions->see();

if(isset($_GET['id']))
{

    $id = verifyInput($_GET['id']);

    $req = $db->prepare("SELECT items.id, items.name, items.username, items.email, items.comment, items.date_posted, items.description, items.last_update, items.image, items.image1, items.image2, items.image3, items.image4, items.price, categories.name 
                             AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?");

    $req->execute([$id]);

    $item = $req->fetch();
   $it = $req->fetch();

}else{

    $_SESSION['flash']['danger'] = "Choisissez un item svp";
   
    header("Location: index.php");
    
    exit();


}
/*
$messageError = $firstnameError = $emailError = $message2Error = "";
$isSuccess = false;
if(isset($_POST['send']))
{
    $firstname = verifyInput($_POST['firstname']);
    $email = verifyInput($_POST['email']);
    $message = verifyInput($_POST['message']);
    $isSuccess = true;

    if(empty($firstname))
    {
        $firstnameError = "Saisissez votre nom";
        $isSuccess = false;
    }

    if(empty($email) || !isEmail($email))
    {
        $emailError = "Saisissez une adresse e-mail valide";
        $isSuccess = false;
    }

    if(empty($message))
    {
        $messageError = "Saisissez un commentaire svp";
        $isSuccess = false;
    }

    if(strlen($message) < 6)
    {
        $message2Error = "Commentaire trop court";
        $isSuccess = false;
    }

    if($isSuccess)
    {

        $req = $db->prepare("INSERT INTO items SET username = ?, email = ?, comment = ?, date_posted = NOW()");

        $req->execute([$firstname, $email, $message]);
    }


}*/

/*$request = $db->prepare("SELECT * FROM items WHERE id = ?");
    $request->execute([$_GET['id']]);

$new_date = preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#', '$3/$2/$1 à $4:$5:$6', $item['date_posted']);
*/
?>

<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-device">
    <link rel="icon" type="image/jpg" href="img/tetra.jpg">
    <title>Ivoire Burger | Items</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/preloader.css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="vendor/animate/animate.css">

    <script type="text/javascript" src="js/comments.js"></script>

    <style>
        .site
        {
            /*@font-face
                src: url("fonts/poppins/Poppins-Black.ttf") format("ttf");*/
            font-family: Algerian, sans-serif;
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
            color: #626262;
            font-weight: bold;
            font-size: 25px;
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

        nav > span > a
        {
            font-size: 18px !important;
            font-family: sans-serif;
            color: rgba(49, 49, 49, 0.89);

        }

        nav > span > a:hover
        {
            text-decoration: none !important;
            color: rgba(49, 49, 49, 0.89);
        }

        .details
        {
            font-weight: bold;
            color: rgba(49, 49, 49, 0.89);
        }

        .desc
        {
            color: #494949;
        }

        .cost
        {
            font-weight:bold;
            font-size: 25px;
        }

        #help-inline
        {
            color:red;
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

        #comment
        {
            background: #F4F4F4;
            padding: 17px;
            display: flex;
            flex-wrap: wrap !important;

        }

        .img
        {
            border-radius: 50px;
            width:50px;
            height:50px;
            border: 3px #fff solid;
        }

        .name > h6
        {
            position:relative;
            top:12%;
            left: 15%;
            text-transform: capitalize;
        }

        .date > small
        {
            position:relative;
            left: 13%;
            top:3%;
            color: #a4a4a4;
            font-size:12px;
        }

        .message
        {
            margin-right:10%;
        }

        @media print
        {
            #hide, #comments
            {
                display: none;
            }
        }

        .thumb
        {
            width:80px;
            height:80px;
            border: 5px lightgray solid !important;
            margin-left:15px;
            justify-content: center;
            -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
            cursor: pointer;
        }

        .thumb:hover
        {
            border: 2px #e7480f solid !important;
            border-radius:50px;
        }

        .thumb:visited
        {
            border: 2px #e7480f solid !important;
        }

        #change
        {
            margin-left:1px;
            justify-content: center !important;
            align-items: center !important;
            display:flex;
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

    <nav id="hide" style="background:rgba(255, 193, 7, 0.589);" class="img-thumbnail mr-auto">
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
    </nav> <br>

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

    <div style="margin-top:30px; font-family:sans-serif;" id="pills-tabContent" class="tab-content">
        <div class="tab-pane fade show active" role="tabpanel" id="5">
            <div class="row">
                <div class="col-md-12 col-lg-12 img-thumbnail" style="margin:auto; width:auto; background:#fff;">
                    <nav id="hide">

                        <span><a href="index.php">Accueil <i  class="fa fa-angle-right"></i> </a></span>
                        <span><a href="<?php echo $item['category']; ?>.php"><?php echo $item['category'];  ?> <i  class="fa fa-angle-right"></i> </a></span>
                        <span><a href="<?php $_SERVER['PHP_SELF'] ?>"><?php echo $item['name'];  ?></a></span>

                    </nav>
                    <div id="hide" style="color:rgba(49, 49, 49, 0.89) !important; margin-top:15px;" class="dropdown-divider"></div>
                <form style="font-family: sans-serif; padding-left:60px !important; padding-right: 60px !important;">
                    <div class="row">
                        <div class="col-md-8">
                            <img class="col-md-9" src="<?php echo 'img/' . $item['image']; ?>" alt="untitled" id="main-img">

                            <div class="thumb-img">
                                <div class="cool justify-content-center mt-5 mb-5" id="change" onclick="changeImage(event)">

                                    <img alt="img" data-toggle="tooltip" title="<?= "Image 1/5" ?>" class="thumb active" src="img/<?= $item['image']; ?>">
                                    <?php if(empty($item['image1'])): ?>
                                    <?php else: ?>
                                        <img alt="img" data-toggle="tooltip" title="<?= "Image 2/5" ?>" class="thumb active" src="img/<?= $item['image1']; ?>">
                                    <?php endif; ?>

                                        <?php if(empty($item['image2']) || $item['image2'] == $item['image1']): ?>

                                        <?php else: ?>

                                        <img alt="img" data-toggle="tooltip" title="<?= "Image 3/5" ?>" class="thumb" src="img/<?= $item['image2']; ?>">

                                         <?php endif; ?>


                                        <?php if(empty($item['image3']) || $item['image3'] == $item['image1']): ?>

                                            <?php else: ?>
                                        <img alt="img" data-toggle="tooltip" title="<?= "Image 4/5" ?>" class="thumb" src="img/<?= $item['image3']; ?>">

                                        <?php endif; ?>

                                    <?php if(empty($item['image4']) || $item['image4'] == $item['image1']): ?>

                                    <?php else: ?>
                                        <img alt="img" data-toggle="tooltip" title="<?= "Image 5/5" ?>" class="thumb" src="img/<?= $item['image4']; ?>">

                                    <?php endif; ?>

                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="caption">
                                <h4><?php  echo $item['name']; ?></h4>
                                <div class="dropdown-divider"></div>
                                <div class="details">Détails du produit</div><br>
                                <p class="desc"> <i class="fa fa-angle-right"></i> Type de produit: <?php echo $item['name']; ?> </p>
                                <p class="desc"> <i class="fa fa-angle-right"></i> Catégorie: <?php echo $item['category']; ?> </p>
                                <p class="desc"> <i class="fa fa-angle-right"></i> Quantité: 1 </p>
                                <p class="desc"> <i class="fa fa-angle-right"></i> Description: <?php echo $item['description']; ?> </p>
                                <div class="dropdown-divider"></div>

                                <div class="cost"><?php echo $item['price']; ?> F.CFA</div> <br>
                                <a id="hide" data-toggle="modal" data-target="#monModal" href="addpanier.php?id=<?= $item['id'] ?>" class="addpanier form-control btn btn-order" role="button"><i class="fa fa-shopping-cart"></i> Ajouter au panier</a> <br><br>
                                <a id="hide" class="btn btn-ordered btn-block mb-2" href="" onclick="window.print()">Imprimer <i class="fa fa-print"></i></a>
                                <div id="hide" class="text-center"><a data-toggle="modal" data-target="#Modal" href="addwishlist.php?id=<?= $item['id']; ?>" class="addwhish"><i class="fa fa-heart-o"></i> Mettre de coté</a></div>


                            </div>


                        </div>
                    </div>

                </form><br><br>

                    <?php if(isset($_SESSION['auth'])): ?>

                    <div class="modal fade" id="monModal" style="font-family: sans-serif">
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

                    <?php else: ?>

                        <div class="modal fade" id="monModal" style="font-family: sans-serif">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4  class="text-white btn btn-order modal-title"><i style="font-size:20px;" class="fa fa-info"></i> Informations</h4>
                                        <button style="transform: rotate(45deg); font-size: 39px; position:relative; bottom:20px; left:10px;" type="button" class="close" data-dismiss="modal">+</button>
                                    </div>
                                    <span class="modal-body justify-content-center text-center">Vous devez être connecté pour ajouter des produits à votre panier</span>
                                    <div class="modal-footer">
                                        <form method="POST">
                                            <button class="btn btn-order" type="submit" name="connect">Se connecter <i class="fa fa-sign-in"></i></button>
                                            <button id="link" type="button" class="btn btn-ordered" data-dismiss="modal">Annuler <i class="fa fa-remove"></i></button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                    <div class="modal fade" id="Modal" style="font-family: sans-serif">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4  class="text-white btn btn-order modal-title"><i style="font-size:20px;" class="fa fa-info"></i> Informations</h4>
                                    <button style="transform: rotate(45deg); font-size: 39px; position:relative; bottom:20px; left:10px;" type="button" class="close" data-dismiss="modal">+</button>
                                </div>
                                <span class="modal-body justify-content-center text-center"></span> <span style="color: #e7480f;font-size: 30px;" class="text-center c"></span>
                                <div class="modal-footer">
                                    <form method="POST">
                                        <button type="submit" class="btn btn-order" name="seew">Voir ma liste <i class="fa fa-heart-o"></i></button>
                                        <button id="link" type="button" class="btn btn-ordered" data-dismiss="modal">Continuer mes achats</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="color:rgba(49, 49, 49, 0.89) !important; margin-top:15px;" class="dropdown-divider"></div>
                    <div class="row">
                        <div class="col-md-4"></div>
                    <div id="hide" class="text-center justify-content-center col-md-4" style="border-left: 1px rgba(49, 49, 49, 0.89) solid; border-right: 1px rgba(49, 49, 49, 0.89) solid !important; border-bottom: 1px solid rgba(49, 49, 49, 0.89)">AVIS DES CONSOMMATEURS</div>
                   <div class="col-md-4"></div>
                    </div>
                    <br>
                    <?php if(isset($_SESSION['auth'])): ?>
                    <div class="row" style="margin-bottom: 30px;">
                        <div id="hide" class="text-center col-md-12">
                            Avez-vous déjà consommer ce produit ? <br> <br>


                        </div>
                    </div>


                        <form id="comments" method="POST" role="form" action="view.php?id=<?= $item['id']; ?>">
                            <div id="errors"></div>
                            <div class="row">
                                <div class="col-md-6">
                            <div class="form-group">
                                <label style="color:#4E555F; text-align: justify !important;" for="firstname">Nom et Prénom</label>
                                <input style="background: #FAFAFA !important; border-top:#CDCDCD solid 2px;" name="firstname" id="firstname" type="text" value="<?= $_SESSION['auth']['firstname'] . " " . $_SESSION['auth']['lastname']; ?>" class="form-control">
                                <small class="text-danger" id="help-inline"><?php //echo $firstnameError; ?></small>
                            </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label style="color: #4E555F" for="email">E-mail</label>
                                        <input style="background: #FAFAFA !important; border-top:#CDCDCD solid 2px;" type="email" id="email" class="form-control" name="email" value="<?= $_SESSION['auth']['email']; ?>">
                                        <small class="text-danger" id="help-inline"><?php  //echo $emailError; ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea style="background: #FAFAFA; border-top: #CDCDCD solid 2px;" class="form-control" id="message" name="message" placeholder="Votre commentaire..."></textarea>
                                <small class="text-danger" id="help-inline"><?php // echo $messageError; ?></small>
                                <small class="text-danger"><?php  //echo $message2Error; ?></small>
                            </div>
                            <div class="form-actions">
                                <input type="submit" id="send"  value="Envoyer" name="send" class="btn btn-order">
                            </div>
                        </form>






                    <?php else: ?>
                        <div class="row" style="margin-bottom:100px;">
                            <div style="color:red; font-weight:bold" class="text-center col-md-12">
                                Vou devez être connecté pour pouvoir voir et laisser un commentaire.
                                <a style="color:red" href="users/login.php">Connexion <i class="fa fa-arrow-circle-o-right"></i></a>
                            </div>
                        </div>

                    <?php endif; ?>



                </div>






            </div> <br> <br> <br>

        </div>

    </div>

</div>

<?php require_once  "inc/footer.php";  ?>


<!--Bootstrap Core Javascript at the end of the code to load page fastly-->
<script>
    function changeImage(event)
    {
        var images = document.getElementById("change").getElementsByTagName("img");

        event = event || window.event;

        var targetElement = event.target || event.srcElement;

        // if (targetElement == "IMG")
        //  {

        // }
        document.getElementById("main-img").src = targetElement.getAttribute("src");
    }
</script>
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
<script type="text/javascript" src="js/util.js"></script>
<script src="js/app.js"></script>
<script src="js/whish.js"></script>
<script>

    //Enable Preloader with JQUERY

   $(document).ready(function (){
        $("#comments").submit(function(){
            if($("#message").val() == "" ){
                $("#message").tooltip().html("title", "ok");
            }
        });

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

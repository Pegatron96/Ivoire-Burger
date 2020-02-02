<?php

session_start();



require_once "../inc/database.php";
require_once "../inc/functions.php";

//Fonction qui restreint l'accès de certaines pages du site aux utilisateurs authentifiés
logged_only();

if(isset($_GET['id']))
{
    $id = verifyInput($_GET['id']);

}

$db = Database::connect();


$req = $db->prepare("SELECT items.id, items.name, items.description, items.image, items.price, categories.name 
                             AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?");

$req->execute([$id]);
$item = $req->fetch();

Database::disconnect();

if(isset($_POST['del']))
{
    $db = Database::connect();

    $req = $db->prepare("DELETE FROM items WHERE id = ?");
    $req->execute([$id]);
    Database::disconnect();
    $_SESSION['flash']['success'] = "L'item a bien été supprimé";
    header("Location: index.php");
    exit();


}

?>

<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <script type="javascript">
        $(function (){
            $('.alert').alert()
        });
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ivoire Burger Admin | Supprimer un item</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css"
    <link rel="stylesheet" href="../vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/jpg" href="../img/tetra.jpg">
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

        form > .form-group > label
        {

            border: 1px rgba(31, 31, 31, 0.42) solid;
            padding:10px;
            width:110px;

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

        .img-thumbnail
        {
            font-family: 'algerian', sans-serif;


        }

    </style>
</head>
<body>

<h1 style="text-transform: uppercase" class="text-center text-logo"><i class="fa fa-cutlery"></i> Ivoire Burger Administration<i class="fa fa-cutlery"></i></h1>
<div class="container admin">
    <h2 class="text-dark">Supprimer un item <i class="fa fa-recycle"></i></h2> <br>
    <div class="text-center alert alert-warning">Voulez vous vraiment supprimer cet item ?</div>


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

    <br>
    <div class="row">
        <div class="col-sm-6">


            <form method="POST" action="<?php echo 'delete.php?id='. $id; ?>">
                <div class="form-action">
                    <button style="color:#fff;" type="submit" name="del" class="btn btn-warning btn-md-4">Oui</button>
                    <a href="index.php"><button style="border: 1px gray solid;" type="button" class="btn btn-light btn-md-4">Non</button></a>
                </div> <br>
                <div class="form-group">
                    <label>Nom: </label> <?= " ". $item['name'];  ?>
                </div>

                <div class="form-group">
                    <label>Prix: </label> <?= " ". $item['price'];  ?> F.CFA
                </div>

                <div class="form-group">
                    <label>Description: </label> <?= " ". $item['description'];  ?>
                </div>

                <div class="form-group">
                    <label>Catégorie: </label> <?= " ". $item['category'];  ?>
                </div>

                <div class="form-group">
                    <label>Image: </label> <?= " ". $item['image'];  ?>
                </div>


            </form> <br>

        </div>
        <div class="col-sm-6" style="margin-top: 40px;">
            <div class="img-thumbnail">
                <img class="col-md-9 col-sm-8" src="<?php echo '../img/' . $item['image']; ?>" alt="untitled">
                <div class="price"><?php echo $item['price']; ?> F.CFA</div>
                <div class="caption">
                    <h4><?php echo $item['name']; ?></h4>
                    <p><?php echo $item['description'];  ?></p>
                    <a href="#" class="form-control btn btn-order" role="button"><i class="fa fa-shopping-cart"></i> Commander</a>
                </div>
            </div> <br>
        </div>
    </div>



</div>

</div>  <br> <br> <br>
<?php require_once "../inc/footer.php" ?>

<!--Bootstrap Core Javascript-->
<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="../js/main.js"></script>
</body>



</html>




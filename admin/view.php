<?php

session_start();



    require_once "../inc/database.php";
    require_once "../inc/functions.php";

    //Fonction qui restreint l'accès de certaines pages du site aux utilisateurs non authentifiés
    logged_only();

if(isset($_GET['id']))
{
    $id = verifyInput($_GET['id']);

}else
{
        $_SESSION['flash']['danger'] = "Choisissez un item svp";
        header("Location: index.php");
        exit();


}

$db = Database::connect();


$req = $db->prepare("SELECT items.id, items.name, items.description, items.last_update, items.image, items.image1, items.image2, items.image3, items.image4, items.price, categories.name 
                             AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?");

$req->execute([$id]);

$item = $req->fetch();

$newdate = preg_replace('#([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})#', ' Le $3/$2/$1 à $4:$5:$6', $item["last_update"]);

$jour = date('d');
$mois = date('M');
$annee = date('Y');
$heure = date('h');
$min = date('i');
$s = date('s');

//$user = get_current_user();


//echo "<span class='text-center'>" . "on est le" ." " . $jour . " " . $mois . " " . $année . " " ."et il est" . " " . $heure . ":" . $min . ":" . $s . "</span>";



Database::disconnect();

?>

<!Doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script type="javascript">
        $(function (){
            $('.alert').alert()
        });
    </script>
    <script>
        $(function (){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ivoire Burger - Admin</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
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
            padding:40px 0;
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
        width:140px;
            text-align: center;

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

        .col-sm-6 > h2
        {
            box-shadow: 7px 7px rgba(48, 48, 48, 0.16);
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

<h1 style="text-transform: uppercase" class="text-center text-logo"><i class="fa fa-cutlery"></i> Ivoire Burger Administration<i class="fa fa-cutlery"></i></h1>
<div class="container admin">

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
        <div class="col-sm-6">
            <h2 class="rounded-circle btn btn-info btn-block">Voir un item <i class="fa fa-creative-commons"></i></h2>
            <br>

            <form>
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

                <div class="form-group">

                    <label>Dernière Mise à jour <i class="fa fa-calendar-times-o"></i> : </label>

                    <?php if(!is_null($item['last_update'])): ?>

                        <?= " ". $newdate;  ?>

                    <?php else: ?>
                      <span>Jamais</span>
                    <?php endif; ?>
                </div>

                <div class="form-action">
                   <a href="items.php"><button type="button" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Retour</button></a>
                </div>
            </form> <br>

        </div>
        <div class="col-sm-6">
            <div class="img-thumbnail">
                <img class="col-md-9 col-sm-8" src="<?php echo '../img/' . $item['image']; ?>" id="main-img" alt="untitled">
                <div class="price"><?php echo $item['price']; ?> F.CFA</div>
                <div class="caption">
                    <h4><?php echo $item['name']; ?></h4>
                    <p><?php echo $item['description'];  ?></p>
                    <a href="#" class="form-control btn btn-order" role="button"><i class="fa fa-shopping-cart"></i> Commander</a>
                </div>
            </div> <br>

            <div class="thumb-img">
                <div class="cool justify-content-center mt-5 mb-5" id="change" onclick="changeImage(event)">

                    <img alt="img" data-toggle="tooltip" title="<?= "Image 1/5" ?>" class="thumb active" src="../img/<?= $item['image']; ?>">
                    <?php if(empty($item['image1'])): ?>
                    <?php else: ?>
                        <img alt="img" data-toggle="tooltip" title="<?= "Image 2/5" ?>" class="thumb active" src="../img/<?= $item['image1']; ?>">
                    <?php endif; ?>

                    <?php if(empty($item['image2']) || $item['image2'] == $item['image1']): ?>

                    <?php else: ?>

                        <img alt="img" data-toggle="tooltip" title="<?= "Image 3/5" ?>" class="thumb" src="../img/<?= $item['image2']; ?>">

                    <?php endif; ?>


                    <?php if(empty($item['image3']) || $item['image3'] == $item['image1']): ?>

                    <?php else: ?>
                        <img alt="img" data-toggle="tooltip" title="<?= "Image 4/5" ?>" class="thumb" src="../img/<?= $item['image3']; ?>">

                    <?php endif; ?>

                    <?php if(empty($item['image4']) || $item['image4'] == $item['image1']): ?>

                    <?php else: ?>
                        <img alt="img" data-toggle="tooltip" title="<?= "Image 5/5" ?>" class="thumb" src="../img/<?= $item['image4']; ?>">

                    <?php endif; ?>

                </div>
            </div>
        </div>
        </div>



    </div>

</div>  <br> <br> <br>
<?php require_once "../inc/footer.php" ?>

<!--Bootstrap Core Javascript-->
<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.js"></script>

<script>
    function changeImage(event)
    {
        let images = document.getElementById("change").getElementsByTagName("img");

        event = event || window.event;

        let targetElement = event.target || event.srcElement;

        // if (targetElement == "IMG")
        //  {

        // }
        document.getElementById("main-img").src = targetElement.getAttribute("src");
    }
</script>
<script type="text/javascript" src="../vendor/jquery/jquery-3.2.1.min.js"></script>
</body>



</html>




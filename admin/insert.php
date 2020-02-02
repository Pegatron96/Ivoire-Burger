<?php
session_start();

require_once "../inc/database.php";
require_once  "../inc/functions.php";

//Fonction qui restreint l'accès de certaines pages du site aux utilisateurs authentifiés
logged_only();


if(!empty($_POST))
{

    $_POST['name'] = verifyInput($_POST['name']);
    $_POST['desc'] = verifyInput($_POST['desc']);
    $_POST['price'] = verifyInput($_POST['price']);
    $_POST['categories'] = verifyInput($_POST['categories']);
    $image = verifyInput($_FILES['image']['name']);
    $image2 = verifyInput($_FILES['image2']['name']);
    $image3 = verifyInput($_FILES['image3']['name']);
    $image4 = verifyInput($_FILES['image4']['name']);
    $image5 = verifyInput($_FILES['image5']['name']);

    $isUploadSuccess = false;


    $errors = array();

    if(empty($_POST['name']))
    {
        $errors['name'] = "Ecrivez le nom de l'item";
    }

    if(empty($_POST['desc']))
    {
        $errors['desc'] = "Ecrivez la description de l'item";
    }

    if(empty($_POST['price']))
    {
        $errors['price'] = "Saisissez le prix de l'item";
    }

    if(empty($_POST['categories']))
    {
        $errors['categories'] = "Sélectionnez une catégorie s'il vous plaît";
    }

    if(empty($image))
    {
        $errors['image'] = "Le champ image principal ne peut être vide";
    }

    if(empty($image2))
    {
        $errors['image2'] = "Le champ image 2 ne peut être vide";
    }

    if(empty($image3))
    {
        $errors['image3'] = "Le champ image 3 ne peut être vide";
    }

    if(empty($image4))
    {
        $errors['image4'] = "Le champ image 4 ne peut être vide";
    }

    if(empty($image5))
    {
        $errors['image5'] = "Le champ image 5 ne peut être vide";
    }


    if(empty($errors))
    {

        if(isset($_FILES['image']))
        {

            $isUploadSuccess = true;

            $imagePath = '../img/'.$image;
            $image2Path = '../img/'.$image2;
            $image3Path = '../img/'.$image3;
            $image4Path = '../img/'.$image4;
            $image5Path = '../img/'.$image5;


            $imageExtension = strrchr($image, ".");

            $image2Extension  = strrchr($image2, ".");

            $image3Extension  = strrchr($image3, ".");

            $image4Extension  = strrchr($image4, ".");

            $image5Extension  = strrchr($image5, ".");


            $ext_autorisees = array('.jpg', '.JPG', '.jpeg', '.JPEG','.png', '.PNG');

            if(!in_array($imageExtension, $ext_autorisees))
            {
                $errors['image'] = "Les images autorisées sont PNG, JPG, JPEG";
                $isUploadSuccess = false;
            }

            if(!in_array($image2Extension, $ext_autorisees))
            {
                $errors['image2'] = "Les images autorisées sont PNG, JPG, JPEG";
                $isUploadSuccess = false;
            }

            if(!in_array($image3Extension, $ext_autorisees))
            {
                $errors['image3'] = "Les images autorisées sont PNG, JPG, JPEG";
                $isUploadSuccess = false;
            }

            if(!in_array($image4Extension, $ext_autorisees))
            {
                $errors['image4'] = "Les images autorisées sont PNG, JPG, JPEG";
                $isUploadSuccess = false;
            }

            if(!in_array($image5Extension, $ext_autorisees))
            {
                $errors['image5'] = "Les images autorisées sont PNG, JPG, JPEG";
                $isUploadSuccess = false;
            }


            if(file_exists($imagePath))
            {
                $errors['image'] = "l'image existe déjà dans le répertoire";
                $isUploadSuccess = false;
            }


            if(file_exists($image5Path))
            {
                $errors['image5'] = "l'image 5 existe déjà dans le répertoire";
                $isUploadSuccess = false;
            }

            if($_FILES['image']['size'] > 512000)
            {
                $errors['image'] = "Le fichier ne doit pas dépasser les 500 KB !";
                $isUploadSuccess = false;
            }

            if($_FILES['image2']['size'] > 512000)
            {
                $errors['image2'] = "Le fichier ne doit pas dépasser les 500 KB !";
                $isUploadSuccess = false;
            }

            if($_FILES['image3']['size'] > 512000)
            {
                $errors['image3'] = "Le fichier ne doit pas dépasser les 500 KB !";
                $isUploadSuccess = false;
            }

            if($_FILES['image4']['size'] > 512000)
            {
                $errors['image4'] = "Le fichier ne doit pas dépasser les 500 KB !";
                $isUploadSuccess = false;
            }

            if($_FILES['image5']['size'] > 512000)
            {
                $errors['image5'] = "Le fichier ne doit pas dépasser les 500 KB !";
                $isUploadSuccess = false;
            }



            if($isUploadSuccess)
            {
                if(!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath))
                {
                    $errors['image'] = "Il y a eu une erreur lors du chargement, le fichier n'as pas été charger !";
                    $isUploadSuccess = false;
                }

                if(!move_uploaded_file($_FILES['image2']['tmp_name'], $image2Path))
                {
                    $errors['image2'] = "Il y a eu une erreur lors du chargement, le fichier n'as pas été charger !";
                    $isUploadSuccess = false;
                }

                if(!move_uploaded_file($_FILES['image3']['tmp_name'], $image3Path))
                {
                    $errors['image3'] = "Il y a eu une erreur lors du chargement, le fichier n'as pas été charger !";
                    $isUploadSuccess = false;
                }

                if(!move_uploaded_file($_FILES['image4']['tmp_name'], $image4Path))
                {
                    $errors['image4'] = "Il y a eu une erreur lors du chargement, le fichier n'as pas été charger !";
                    $isUploadSuccess = false;
                }

                if(!move_uploaded_file($_FILES['image5']['tmp_name'], $image5Path))
                {
                    $errors['image5'] = "Il y a eu une erreur lors du chargement, le fichier n'as pas été charger !";
                    $isUploadSuccess = false;
                }
            }

            if($isUploadSuccess)
            {
                $db = Database::connect();

                $req = $db->prepare("INSERT INTO items SET name = ?, description = ?, price = ?, category = ?, image = ?, image1 = ?, image2 = ?, image3 = ?, image4 = ?");

                $req->execute([$_POST['name'], $_POST['desc'], $_POST['price'], $_POST['categories'], $image, $image2, $image3, $image4, $image5]);

                Database::disconnect();

                $_SESSION['flash']['success'] = "L'item a bien été ajouté";

                header("Location: items.php");

                exit();

            }


        }

    }
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
    <title>Ivoire Burger - Admin</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css"
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/animate.css"
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

        .admin > h2
        {
            margin-bottom: 55px;
        }

        .form-group > label
        {

            font-size: 18.5px;
        }

        .form-group > i
        {
            position: relative;
            right:25px;
            top:3px;

        }

        .form-actions
        {
            word-spacing: 20px;
            padding: 8px;
            border: 1px solid #D9D9D9;
            width:317px;
        }

        #img-label
        {
            font-size: 15px;
        }

        .img-group
        {
            display:flex;
            flex-wrap: wrap;
            justify-content: space-between;
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

    <?php if(!empty($errors)): ?>

    <div class="alert alert-danger">
        <p class="danger">Ces champs ne peuvent être vides</p>

        <ul>
            <?php foreach($errors as $error): ?>

                <li><?php echo $error;  ?></li>

            <?php endforeach; ?>

        </ul>


    </div>

    <?php endif; ?>




    <h2 data-toggle="tooltip" title="Ajoutez un nouveau produit via le formulaire ci-dessous" data-placement="left">Ajouter un item</h2>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nom: </label>
            <input type="text" class="form-control" placeholder="Ecrivez le nom de l'item" name="name">
        </div>

        <div class="form-group">
            <label for="desc">Description: </label>
            <input type="text" class="form-control" placeholder="Rédigez la description de l'item" name="desc">
        </div>

        <div class="form-group">
            <label for="price">Prix (en F.CFA): </label>
            <input type="number" step="100" class="form-control" placeholder="Prix de l'item" name="price">

        </div>

        <div class="form-group">
            <label for="category">Catégorie : </label>
            <select class="form-control" name="categories">
                <?php

                    $db = Database::connect();

                    foreach($db->query("SELECT * FROM categories") as $row)
                    {
                        echo '<option selected value="'. $row['id'] . '">' . $row['name'] . '</option>';
                    }

                    Database::Disconnect();



                ?>
            </select>
            <i class="fa fa-loc"></i>
        </div>

        <div class="form-group">
            <label for="before-image">Sélectionner des images </label><br>
        </div>


        <div class="img-group">
            <div class="form-group">
                <label id="img-label" for="image">Image principale :</label><br>
                <input type="file" name="image" class="form-control-file btn btn-secondary" style="font-size: 13px;">
            </div>

            <div class="form-group">
                <label id="img-label" for="image2">Image 2 :</label><br>
                <input type="file" name="image2" class="form-control-file btn btn-secondary" style="font-size: 13px;">
            </div>

            <div class="form-group">
                <label id="img-label" for="image3">Image 3 :</label><br>
                <input data-toggle="tooltip" title="Vous pouvez choisir la même image que l'image 2, si vous n'avez pas d'autres images. Mais ce champs ne peut être vide" type="file" name="image3" class="form-control-file btn btn-secondary" style="font-size: 13px;">
            </div>

            <div class="form-group">
                <label id="img-label" for="image4">Image 4 :</label><br>
                <input data-toggle="tooltip" title="Vous pouvez choisir la même image que l'image 2, si vous n'avez pas d'autres images. Mais ce champs ne peut être vide" type="file" name="image4" class="form-control-file btn btn-secondary" style="font-size: 13px;">
            </div>

            <div class="form-group">
                <label id="img-label" for="image5">Image 5 :</label><br>
                <input data-toggle="tooltip" title="Vous pouvez choisir la même image que l'image 2, si vous n'avez pas d'autres images. Mais ce champs ne peut être vide" type="file" name="image5" class="form-control-file btn btn-secondary" style="font-size: 13px;">
            </div>

        </div>



        <div class="form-actions mt-5 justify-content-center align-items-center">
            <button type="submit" class="btn btn-success btn-lg">Ajouter <i class="fa fa-pencil"></i></button>
            <a href="index.php"><button type="button" class="btn btn-info btn-lg">Retour <i class="fa fa-arrow-circle-left"></i></button></a>
        </div>
    </form>







</div>  <br> <br> <br>
<?php require_once "../inc/footer.php" ?>

<!--Bootstrap Core Javascript-->
<script>
    $(function (){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/tooltip.js"></script>
<script type="text/javascript" src="../js/alert.js"></script>
<script type="text/javascript" src="../js/toast.js"></script>
<script type="text/javascript" src="../js/util.js"></script>
<script type="text/javascript" src="../js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="../js/tilt.jquery.min.js"></script>
<script type="text/javascript" src="../js/maps.active.js"></script>
<script type="text/javascript" src="../js/owl.carousel.min.js"></script>
<script type="text/javascript" src="../js/popper.min.js"></script>
<script type="text/javascript" src="../js/stellar.js"></script>
<script type="text/javascript" src="../js/stellarnav.min.js"></script>
<script type="text/javascript" src="../js/wow.min.js"></script>
<script type="text/javascript" src="../js/main.js"></script>
<script type="text/javascript" src="../js/bootstrap.bundle.js"></script>



</body>



</html>




<?php
session_start();

require_once "../inc/database.php";
require_once  "../inc/functions.php";

//Fonction qui restreint l'accès de certaines pages du site aux utilisateurs non authentifiés
logged_only();

if(!empty($_GET['id']))
{
    $id = verifyInput($_GET['id']);
}

$nameError = $descriptionError = $priceError = $imageError = $image2Error = $image3Error = $image4Error = $image5Error = $imageSizeError = $image2SizeError = $image3SizeError = $image4SizeError = $image5SizeError = $name = $description = $price = $image = $category = "";

if(isset($_POST['sub']))
{

    $name = verifyInput($_POST['name']);
    $description = verifyInput($_POST['desc']);
    $price = verifyInput($_POST['price']);
    $category = verifyInput($_POST['categories']);
    $image = $_FILES['image']['name'];


    $imagePath = '../img/' . $image;


    $imageExtension = strrchr($image, ".");


    $isSuccess = true;

    if(empty($name))
    {
        $nameError = "Ecrivez le nom de l'item";
        $isSuccess = false;
    }

    if(empty($description))
    {
        $descriptionError = "Ecrivez la description de l'item";
        $isSuccess = false;
    }

    if(empty($price))
    {
        $priceError = "Saisissez le prix de l'item";
        $isSuccess = false;
    }


    if(empty($image))
    {
        $isImageUpdated = false;
    }else{
        $isImageUpdated = true;
        $isUploadSuccess = true;
        if($imageExtension != ".jpg" && $imageExtension != ".png" && $imageExtension != ".gif" && $imageExtension != ".jpeg")
        {
            $imageError = "Les fichiers autorisés sont: jpg, jpeg, png, gif";
           $isUploadSuccess = false;

        }

        if($_FILES['image']['size'] > 512000)
        {
            $imageSizeError = "Le fichier ne doit pas dépasser 500 KB !";
            $isUploadSuccess = false;
        }


        if($isUploadSuccess)
        {
            if(!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath))
            {
                $imageError = "Il y a eu une erreur lors du chargement de l'image !";
                $isUploadSuccess = false;
            }

        }


    }
    if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
    {
        $db = Database::connect();
        if($isImageUpdated)
        {
            $req = $db->prepare("UPDATE items SET name = ?, description = ?, price = ?, category = ?, image = ?, last_update = NOW() WHERE id = ?");
            $req->execute([$name, $description, $price, $category, $image, $id]);

        }
        else
        {
            $req = $db->prepare("UPDATE items SET name = ?, description = ?, price = ?, category = ?, last_update = NOW() WHERE id = ?");
            $req->execute([$name, $description, $price, $category, $id]);
        }
        Database::disconnect();
        $_SESSION['flash']['success'] = "L'item a bien été mis à jour";
        header("Location: items.php");
        exit();
    }
    elseif($isImageUpdated && !$isUploadSuccess)
    {
        $db = Database::connect();
        $req = $db->prepare("SELECT image, image1, image2, image3, image4 FROM items WHERE id = ?");
        $req->execute([$id]);
        $item = $req->fetch();
        $image = $item['image'];
        Database::disconnect();


    }
}else{
    $db = Database::connect();
    $req = $db->prepare("SELECT * FROM items WHERE id = ?");
    $req->execute([$id]);
    $item = $req->fetch();
    $name = $item['name'];
    $description = $item['description'];
    $price = $item['price'];
    $category = $item['category'];
    $image = $item['image'];
    Database::disconnect();
}

$image2 = "";

if(isset($_POST['img2']))
{
    $image2 = $_FILES['image2']['name'];
    $image2Path = '../img/' . $image2;
    $image2Extension = strrchr($image2, ".");
    $isSuccessed = true;

    if(empty($image2))
    {
        $image2Error = "Chargez une image valide";
        echo "<script>" . 'alert("Chargez une image valide")' . "</script>";
        $isSuccessed = false;
    }

    if($image2Extension != ".jpg" && $image2Extension != ".png" && $image2Extension != ".gif" && $image2Extension != ".jpeg")
    {
        $image2Error = "Les fichiers autorisés sont: jpg, jpeg, png, gif";
        echo "<script>" . 'alert("Les fichiers autorisés sont: jpg, jpeg, png, gif")' . "</script>";
        $isSuccessed = false;

    }

    if($_FILES['image2']['size'] > 512000)
    {
        $image2SizeError = "Le fichier ne doit pas dépasser 500 KB !";
        echo "<script>" . 'alert("Le fichier ne doit pas dépasser 500 KB !")' . "</script>";
        $isSuccessed = false;
    }

    if($isSuccessed)
    {
       move_uploaded_file($_FILES['image2']['tmp_name'], $image2Path);

        $db = Database::connect();

        $req = $db->prepare("UPDATE items SET image1 = ?, last_update = NOW() WHERE id = ?");
        $req->execute([$image2, $id]);

        echo "<script>" . "alert('Image 2 mise à jour !')" . "</script>";



    }else{
        $image2Error = "Il y a eu une erreur lors du chargement de l'image !";

       echo "<script>" . 'alert("Il y a eu une erreur lors du chargement de votre image !")' . "</script>";
    }
}


if(isset($_POST['img3']))
{
    $image3 = $_FILES['image3']['name'];
    $image3Path = '../img/' . $image3;
    $image3Extension = strrchr($image3, ".");
    $isSuccessed = true;

    if(empty($image3))
    {
        $image3Error = "Chargez une image valide";
        echo "<script>" . 'alert("Chargez une image valide")' . "</script>";
        $isSuccessed = false;
    }

    if($image3Extension != ".jpg" && $image3Extension != ".png" && $image3Extension != ".gif" && $image3Extension != ".jpeg")
    {
        $image3Error = "Les fichiers autorisés sont: jpg, jpeg, png, gif";
        echo "<script>" . 'alert("Les fichiers autorisés sont: jpg, jpeg, png, gif")' . "</script>";
        $isSuccessed = false;

    }

    if($_FILES['image3']['size'] > 512000)
    {
        $image3SizeError = "Le fichier ne doit pas dépasser 500 KB !";
        echo "<script>" . 'alert("Le fichier ne doit pas dépasser 500 KB !")' . "</script>";
        $isSuccessed = false;
    }

    if($isSuccessed)
    {
       move_uploaded_file($_FILES['image3']['tmp_name'], $image3Path);

        $db = Database::connect();

        $req = $db->prepare("UPDATE items SET image2 = ?, last_update = NOW() WHERE id = ?");
        $req->execute([$image3, $id]);

        echo "<script>" . "alert('Image 3 mise à jour !')" . "</script>";



    }else{
        $image3Error = "Il y a eu une erreur lors du chargement de l'image !";

       echo "<script>" . 'alert("Il y a eu une erreur lors du chargement de votre image !")' . "</script>";
    }
}

if(isset($_POST['img4']))
{
    $image4 = $_FILES['image4']['name'];
    $image4Path = '../img/' . $image4;
    $image4Extension = strrchr($image4, ".");
    $isSuccessed = true;

    if(empty($image4))
    {
        $image4Error = "Chargez une image valide";
        echo "<script>" . 'alert("Chargez une image valide")' . "</script>";
        $isSuccessed = false;
    }

    if($image4Extension != ".jpg" && $image4Extension != ".png" && $image4Extension != ".gif" && $image4Extension != ".jpeg")
    {
        $image4Error = "Les fichiers autorisés sont: jpg, jpeg, png, gif";
        echo "<script>" . 'alert("Les fichiers autorisés sont: jpg, jpeg, png, gif")' . "</script>";
        $isSuccessed = false;

    }

    if($_FILES['image4']['size'] > 512000)
    {
        $image4SizeError = "Le fichier ne doit pas dépasser 500 KB !";
        echo "<script>" . 'alert("Le fichier ne doit pas dépasser 500 KB !")' . "</script>";
        $isSuccessed = false;
    }

    if($isSuccessed)
    {
       move_uploaded_file($_FILES['image4']['tmp_name'], $image4Path);

        $db = Database::connect();

        $req = $db->prepare("UPDATE items SET image3 = ?, last_update = NOW() WHERE id = ?");
        $req->execute([$image4, $id]);

        echo "<script>" . "alert('Image 4 mise à jour !')" . "</script>";



    }else{
        $image4Error = "Il y a eu une erreur lors du chargement de l'image !";

       echo "<script>" . 'alert("Il y a eu une erreur lors du chargement de votre image !")' . "</script>";
    }
}

if(isset($_POST['img5']))
{
    $image5 = $_FILES['image5']['name'];
    $image5Path = '../img/' . $image5;
    $image5Extension = strrchr($image5, ".");
    $isSuccessed = true;

    if(empty($image5))
    {
        $image5Error = "Chargez une image valide";
        echo "<script>" . 'alert("Chargez une image valide")' . "</script>";
        $isSuccessed = false;
    }

    if($image5Extension != ".jpg" && $image5Extension != ".png" && $image5Extension != ".gif" && $image5Extension != ".jpeg")
    {
        $image5Error = "Les fichiers autorisés sont: jpg, jpeg, png, gif";
        echo "<script>" . 'alert("Les fichiers autorisés sont: jpg, jpeg, png, gif")' . "</script>";
        $isSuccessed = false;

    }

    if($_FILES['image5']['size'] > 512000)
    {
        $image5SizeError = "Le fichier ne doit pas dépasser 500 KB !";
        echo "<script>" . 'alert("Le fichier ne doit pas dépasser 500 KB !")' . "</script>";
        $isSuccessed = false;
    }

    if($isSuccessed)
    {
       move_uploaded_file($_FILES['image5']['tmp_name'], $image5Path);

        $db = Database::connect();

        $req = $db->prepare("UPDATE items SET image4 = ?, last_update = NOW() WHERE id = ?");
        $req->execute([$image5, $id]);

        echo "<script>" . "alert('Image 5 mise à jour !')" . "</script>";



    }else{
        $image5Error = "Il y a eu une erreur lors du chargement de l'image !";

       echo "<script>" . 'alert("Il y a eu une erreur lors du chargement de votre image !")' . "</script>";
    }
}

?>



<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <script type="javascript" async>
        $(function (){
            $('.alert').alert()
        });


    </script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ivoire Burger - Admin</title>
    <link rel="stylesheet" type="text/css" media="all" href="../css/main.css">
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

        .admin > h2
        {
            margin-bottom: 55px;
        }

        .form-group > label
        {

            font-size: 17px;
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

        .help-inline
        {
            color:red;
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

        .col-md-3
        {
            font-family: sans-serif !important;
        }

        .caption h4
        {
            color: #e7480f;
            font-size: 18px;
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



<?php if(!empty($_GET)): ?>

    <div class="row">
        <div class="col-sm-6">
            <h2 data-toggle="tooltip" class="rounded-circle btn btn-info btn-block" title="Vous pouvez modifier cet item via ce formulaire" data-placement="left">Modifier un item <i class="fa fa-pencil-square-o"></i> </h2>

            <form method="POST" action="<?php echo 'update.php?id='. $id; ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nom: </label>
            <input type="text" class="form-control" value="<?php echo $name; ?>" name="name">
            <p class="help-inline"><?php echo $nameError; ?></p>
        </div>

        <div class="form-group">
            <label for="desc">Description: </label>
            <input type="text" class="form-control" value="<?php echo $description; ?>" name="desc">
            <p class="help-inline"><?php echo $descriptionError; ?></p>
        </div>

        <div class="form-group">
            <label for="price">Prix (en F.CFA): </label>
            <input type="number" step="100" class="form-control" value="<?php echo $price; ?>" name="price">
            <p class="help-inline"><?php echo $priceError; ?></p>
        </div>

        <div class="form-group">
            <label for="categories">Catégorie : </label>
            <select class="form-control" name="categories">
                <?php

                $db = Database::connect();

                foreach($db->query("SELECT * FROM categories") as $row)
                {
                    if($row['id'] == $category)

                        echo '<option selected="selected" value="'. $row['id'] . '">' . $row['name'] . '</option>';
                    else
                        echo '<option value="'. $row['id'] . '">' . $row['name'] . '</option>';

                }

                Database::Disconnect();

                ?>
            </select>
        </div>

        <div class="form-group">
            <div class="img">
                <div>
                    <label>Image principale : </label>
                    <p class="img-thumbnail col-md-3" style="border: #D9D9D9 solid 1px;"><?php echo $image;  ?></p>
                </div>

                <label for="image">Modifier l'image principale : </label><br>
                <input type="file" name="image" class="form-control-file btn btn-outline-info">
                <p class="help-inline"><?php echo $imageError; ?></p>
                <p class="help-inline"><?php echo $imageSizeError; ?></p>

                <div>
                    <label>Image 2 : </label>

                    <?php if(!empty($item['image1'])): ?>
                    
                    <p class="img-thumbnail col-md-3" style="border: #D9D9D9 solid 1px;"><?php echo $item['image1'];  ?></p>

                    <?php else: ?>

                        <p class="img-thumbnail col-md-3 text-center" style="border: #D9D9D9 solid 1px;">Vide</p>

                    <?php endif; ?>
                    <button data-target="#monModal" data-toggle="modal" type="button" class="btn btn-secondary">Modifier l'image 2</button>
                </div>





                <div>
                    <label>Image 3 : </label>

                    <?php if(!empty($item['image2'])): ?>

                     <p class="img-thumbnail col-md-3" style="border: #D9D9D9 solid 1px;"><?php echo $item['image2'];  ?></p>

                    <?php else: ?>

                        <p class="img-thumbnail col-md-3 text-center" style="border: #D9D9D9 solid 1px;">Vide</p>

                    <?php endif; ?>
                    <button data-target="#monModal3" data-toggle="modal" type="button" class="btn btn-secondary">Modifier l'image 3</button>
                </div>





                <div>
                    <label>Image 4 : </label>

                    <?php if(!empty($item['image3'])): ?>
                    <p class="img-thumbnail col-md-3" style="border: #D9D9D9 solid 1px;"><?php echo $item['image3'];  ?></p>

                    <?php else: ?>

                        <p class="img-thumbnail col-md-3 text-center" style="border: #D9D9D9 solid 1px;">Vide</p>

                    <?php endif; ?>

                    <button data-target="#monModal4" data-toggle="modal" type="button" class="btn btn-secondary">Modifier l'image 4</button>
                </div>


                <div>
                    <label>Image 5 : </label>

                    <?php if(!empty($item['image4'])): ?>
                    <p class="img-thumbnail col-md-3" style="border: #D9D9D9 solid 1px;"><?php echo $item['image4'];  ?></p>

                    <?php else: ?>
                        <p class="img-thumbnail col-md-3 text-center" style="border: #D9D9D9 solid 1px;">Vide</p>
                    <?php endif; ?>

                    <button data-target="#monModal5" data-toggle="modal" type="button" class="btn btn-secondary">Modifier l'image 5</button>
                </div>

            </div>


        </div>

        <div class="form-actions">
            <button type="submit" name="sub" class="btn btn-success btn-md">Modifier <i class="fa fa-pencil"></i></button>
            <a href="index.php"><button type="button" class="btn btn-info btn-md">Retour <i class="fa fa-arrow-circle-left"></i></button></a>
        </div>
    </form>

            <!--Tooltips pour la mise à jour des images 2 à 5-->

            <div class="modal fade" id="monModal" style="font-family: sans-serif">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4  class="modal-title">Modification de l'image 2 <i class="fa fa-image"></i></h4>
                            <button style="position:relative;bottom:10px; font-size:35px; transform: rotate(45deg)" type="button" class="close" data-dismiss="modal">+</button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?php echo htmlspecialchars('update.php?id='. $id); ?>" enctype="multipart/form-data">
                                <label for="image">Modifier l'image 2 : </label><br>
                                <input type="file" name="image2" class="form-control-file btn btn-outline-info">
                                <p class="help-inline"><?php echo $image2Error; ?></p>
                                <p class="help-inline"><?php echo $image2SizeError; ?></p>

                                <button type="submit" name="img2" class="btn btn-info">Valider</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="monModal3" style="font-family: sans-serif">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4  class="modal-title">Modification de l'image 3 <i class="fa fa-image"></i></h4>
                            <button style="position:relative;bottom:10px; font-size:35px; transform: rotate(45deg)" type="button" class="close" data-dismiss="modal">+</button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?php echo htmlspecialchars('update.php?id='. $id); ?>" enctype="multipart/form-data">
                                <label for="image3">Modifier l'image 3 : </label><br>
                                <input type="file" name="image3" class="form-control-file btn btn-outline-info">
                                <p class="help-inline"><?php echo $image3Error; ?></p>
                                <p class="help-inline"><?php echo $image3SizeError; ?></p>
                                <button type="submit" name="img3" class="btn btn-info">Valider</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="monModal4" style="font-family: sans-serif">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4  class="modal-title">Modification de l'image 4 <i class="fa fa-image"></i></h4>
                            <button style="position:relative;bottom:10px; font-size:35px; transform: rotate(45deg)" type="button" class="close" data-dismiss="modal">+</button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?php echo htmlspecialchars('update.php?id='. $id); ?>" enctype="multipart/form-data">
                                <label for="image4">Modifier l'image 4 : </label><br>
                                <input type="file" name="image4" class="form-control-file btn btn-outline-info">
                                <p class="help-inline"><?php echo $image4Error; ?></p>
                                <p class="help-inline"><?php echo $image4SizeError; ?></p>
                                <button type="submit" name="img4" class="btn btn-info">Valider</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="monModal5" style="font-family: sans-serif">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4  class="modal-title">Modification de l'image 5 <i class="fa fa-image"></i></h4>
                            <button style="position:relative;bottom:10px; font-size:35px; transform: rotate(45deg)" type="button" class="close" data-dismiss="modal">+</button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?php echo htmlspecialchars('update.php?id='. $id); ?>" enctype="multipart/form-data">
                                <label for="image5">Modifier l'image 5 : </label><br>
                                <input type="file" name="image5" class="form-control-file btn btn-outline-info">
                                <p class="help-inline"><?php echo $image5Error; ?></p>
                                <p class="help-inline"><?php echo $image5SizeError; ?></p>
                                <button type="submit" name="img5" class="btn btn-info">Valider</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--Fin Tooltip-->

        </div>

        <div class="col-sm-6">
            <div class="img-thumbnail">
                <img class="col-md-9 col-sm-8" src="<?php echo '../img/' . $image; ?>" alt="untitled">
                <div class="price"><?php echo $price; ?> F.CFA</div>
                <div class="caption">
                    <h4><?php echo $name; ?></h4>
                    <p><?php echo $description;  ?></p>
                    <a href="#" class="form-control btn btn-order" role="button"><i class="fa fa-shopping-cart"></i> Commander</a>
                </div>
            </div> <br>
        </div>

    </div>

    <?php endif; ?>


</div>  <br> <br> <br>
<?php require_once "../inc/footer.php" ?>

<!--Bootstrap Core Javascript-->
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




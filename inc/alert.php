<?php

if(session_status() == NULL)
{
    session_start();
}

?>


<!Doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" width="device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" href="../img/tetra.jpg">
    <title>Ivoire Burger By Tetratech INC</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="container">



    <?php if(isset($_SESSION['flash'])):  ?>

        <?php foreach($_SESSION['flash'] as $type => $message):   ?>

            <div class="alert alert-<?= $type; ?>">
                <?= $message;  ?>

            </div>
        <?php endforeach; ?>

        <?php unset($_SESSION['flash']);  ?>

    <?php endif;  ?>



</div>




<!--Bootstrap Core Javascript at the end of the code to load page fastly-->

<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/popper.js"></script>
<script type="text/javascript" src="../vendor/bootstrap/js/tooltip.js"></script>
<script type="text/javascript" src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="../js/main.js"></script>
<script src="../js/bootstrap.bundle.js"></script>

</body>



</html>
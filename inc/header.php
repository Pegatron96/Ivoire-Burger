<nav style="background:rgba(255, 193, 7, 0.589);" class="img-thumbnail">
        <ul style="margin-left:25px; width:auto;" class="nav nav-pills" id="pills-tab">
            <li role="presentation" class="nav-item"><a class="nav-link" id="pills-menus-tab" href="index.php">Accueil</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" id="pills-menus-tab" href="index.php">Menus</a></li>
            <li role="presentation" class="nav-item active"><a class="nav-link" href="burgers.php"  id="pills-burgers-tab"> Burgers</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="snacks.php" id="pills-snacks-tab">Snacks</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="salades.php" id="pills-salades-tab">Salades</a></li>
            <li role="presentation" class="nav-item"><a style="background: #e7480f;" class="nav-link active" href="boissons.php" id="pills-boissons-tab">Boissons</a></li>
            <li role="presentation" class="nav-item"><a class="nav-link" href="desserts.php" id="pills-desserts-tab">Désserts</a></li>
            <li role="presentation" class="nav-item"><a class="cart nav-link" href="cart.php" id="pills-desserts-tab" data-toggle="pill"><i class="fa fa-shopping-cart"></i></a></li>
            <?php if(isset($_SESSION['auth'])): ?>

                <li class="nav-item user nav-link"> <i class="fa fa-users dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></i>
                    <ul style="font-family:sans-serif; text-shadow: none" class="drop text-justify dropdown-menu">
                        <li class="text-center" style="text-transform: capitalize"><?php echo "Bonjour,". " " . $_SESSION['auth']['lastname']; ?></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="users/account.php"><i class="fa fa-user-circle"></i> Mon compte</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="users/whishlist.php"><i class="fa fa-heart-o"></i> Liste d'envie</a> </li>
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
                <form method="GET" action="boissons.php">
                    <input class="img-thumbnail" type="search" name="search" id="search" placeholder="Effectuer une recherche...">
                </form>
            </li>

        </ul>
    </nav> <br><br> <br>
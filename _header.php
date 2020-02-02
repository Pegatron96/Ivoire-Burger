<?php

require_once "inc/db.php";
require_once "panier.class.php";
require_once "whish.class.php";

$database = new DB();
$panier = new panier($database);
$whish = new whish($database);
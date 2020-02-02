<?php

session_start();

if(!isset($_SESSION['auth']))
{
    $_SESSION['flash']['danger'] = "Vous devez être connecté pour ajouter des produits au panier";
    header("Location: users/login.php");
    exit();
}

require_once "_header.php";

$json = array('error' => true);

if(isset($_GET['id']))
{
   $product = $database->query("SELECT * FROM items WHERE id=:id", array('id' => $_GET['id']));

  if(empty($product))
  {
      $json['message'] =  "Ce produit n'existe pas";
  }

$panier->add($product[0]->id);
  $json['error'] = false;

  $json['message'] = "Le produit a bien été ajouté à votre panier";
}else{
    $json['message'] = "Vous n'avez pas ajouter de produit";
}

echo json_encode($json);

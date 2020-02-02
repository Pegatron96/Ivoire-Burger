<?php


require "database.php";
require "alert.php";


if(!empty($_POST))
{
    $result = preg_replace("[^a-zA-Z ?0-9]", "", $_POST['search']);

    $db = Database::connect();

    $req = $db->prepare("SELECT * FROM items WHERE name LIKE ?
                            OR category LIKE ? OR description LIKE ? ORDER BY price DESC");

    $req->execute(['%'. $result . '%', '%'. $result . '%']);

    $count = $req->rowCount();

    //if($count >= 1)
   // {
        //$one = "$count résultat(s) trouvé(s) pour $result";
   // }




   //header("Location: search.php?q=". $_POST['search']);


}



?>
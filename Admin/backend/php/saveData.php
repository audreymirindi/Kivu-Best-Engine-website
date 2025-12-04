<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
require_once("./connection.php");

class saveData
{
    function InsertData($uniqueID, $marque, $description, $image_file, $seo_url)
    {
        global $pdo;
        $sql = "INSERT INTO produits(`unique_id`,`marque`,`description`,`img`, `seo_url`) VALUES(?, ?, ?, ?, ?)";
        $query = $pdo->prepare($sql);
        if ($query->execute(["{$uniqueID}", "{$marque}", "{$description}", "{$image_file}", "{$seo_url}"])) {
            echo "saved";
        } else {
            echo "There was an error during the operation";
        }
    }
}

<?php
require_once("./connection.php");

$id = $_GET['id'];


$sql = "SELECT * FROM produits WHERE id = ?";
$query = $pdo->prepare($sql);
$query->execute([$id]);
$res = $query->fetch();

if (unlink("../../uploads/" . $res['img'])) {
    $sql2 = "DELETE FROM produits WHERE id = ?";
    $query2 = $pdo->prepare($sql2);
    if ($query2->execute([$id])) {
        header("Location: ../../");
    } else {
        echo "An Error was accured while deleting from database";
    }
} else {
    echo "An Error was occured while deleting the file";
}

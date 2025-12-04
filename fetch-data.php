<?php
require_once("./Admin/backend/php/connection.php");

$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
$limit  = isset($_POST['limit']) ? intval($_POST['limit']) : 4;

$sql = "SELECT * FROM produits ORDER BY id DESC LIMIT :limit OFFSET :offset";
$query = $pdo->prepare($sql);
$query->bindParam(":limit", $limit, PDO::PARAM_INT);
$query->bindParam(":offset", $offset, PDO::PARAM_INT);
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($res) == 0) {
    echo "no_more";
    exit;
}

if (count($res) > 0) {
    foreach ($res as $row) {
        $desc = (strlen($row['description']) > 50)
            ? substr($row['description'], 0, 50) . '...'
            : $row['description'];

        echo "
        <div class='card'>
                <img src='./Admin/uploads/$row[img]' alt=''>
                <div class='texts'>
                    <h4>$row[marque]</h4>
                    <p>$desc</p>
                    <a href='$row[seo_url]'><button type='button' class='btn btn-primary mt-4'>Ouvir</button></a>
                </div>
            </div>
    ";
    }
} else {
    echo "Pas de produits disponible";
}

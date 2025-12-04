<?php
require_once("./connection.php");

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

foreach ($res as $row) {
    $desc = (strlen($row['description']) > 50)
        ? substr($row['description'], 0, 50) . '...'
        : $row['description'];

    echo "
        <div class='item-card'>
            <img src='uploads/{$row['img']}' alt='Image' />
            <h3>{$row['marque']}</h3>
            <p>{$desc}</p>
            <div class='card-actions'>
                <!-- <button class='action-btn edit-btn'>Edit</button> -->
                <a href='./backend/php/delete-data.php?id={$row['id']}'><button class='action-btn delete-btn'>Delete</button></a>
            </div>
        </div>
    ";
}

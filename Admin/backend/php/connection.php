<?php
////////////////////////////////////////////////////////////////////////////////
//Connection to the database

$database = "kivubestengine_db";
$user_name = "root";
$user_password = "";
$host = "localhost";

$pdo = new PDO("mysql:host={$host};dbname={$database}", "{$user_name}", "{$user_password}");
if ($pdo) {
    /* echo "connected"; */
} else {
    echo "Error was occured during the connection";
}

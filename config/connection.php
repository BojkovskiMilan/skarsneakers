<?php

$server = "localhost";
$database = "skarsneakers";
$username = "root";
$password = "";

try {

    $conn = new PDO(
        "mysql:host=$server;dbname=$database;charset=utf8mb4",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo $e->getMessage();
}
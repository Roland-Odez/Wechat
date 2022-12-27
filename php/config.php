<?php

$dsn = "mysql:host=localhost;dbname=ChatApp;charset=UTF8";

try {
    $pdo = new PDO($dsn, "Roland", "database0000");

    if (!$pdo) {
        echo "Connection to database unsuccessfully!";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
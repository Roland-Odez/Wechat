<?php
include "./config.php";
include "../functions/update_status.php";
session_start();
$result = update_status(0, $pdo);

if ($result) {
    session_destroy();
    $_SESSION = array();
    header("location: ../index.php");
}
<?php
session_start();
include_once "./config.php";
include "../functions/upload_img.php";
include "../functions/update_user.php";
include "../functions/form-validation.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$name = explode(" ", validate($_POST["name"]));
$fName = $name[0];
$lName = $name[1];
$about = validate($_POST["about"]);
$file_name = "";

$stm = $pdo->prepare("SELECT * FROM users WHERE unique_id = :unique_id");
$stm->execute([":unique_id" => $_SESSION["unique_id"]]);
$res = $stm->fetch(PDO::FETCH_ASSOC);

if (!empty($fName) && !empty($lName)) {
        if ($fName !== $res["fName"]) {
                update_user("fName", $fName, $pdo);
        }

        if ($lName !== $res["lName"]) {
                update_user("lName", $lName, $pdo);
        }
} else {
        http_response_code(400);
        echo json_encode(["result" => "name is required"]);
}

if (!empty($about)) {
        if ($about !== $res["about"]) {
                update_user("about", $about, $pdo);
        }
} else {
        http_response_code(400);
        echo json_encode(["result" => "about user is required"]);
}

if (!empty($_FILES['profile_pic']["name"])) {
        if (upload_img($_FILES["profile_pic"])) {
                unlink("{$_SERVER['DOCUMENT_ROOT']}/projects/Wechat/upload/{$res["profile_pic"]}");
                update_user("profile_pic", $file_name, $pdo);
        }
}
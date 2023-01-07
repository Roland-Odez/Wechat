<?php
session_start();
include_once "./config.php";
include "../functions/upload_img.php";
include "../functions/update_user.php";
include "../functions/form-validation.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$name = explode(" ", validate($_POST["name"])); // seperate fullname into firstname and lastname form name inputs
$fName = $name[0];
$lName = $name[1];
$about = validate($_POST["about"]); //about datas
$file_name = "";

// get user
$stm = $pdo->prepare("SELECT * FROM users WHERE unique_id = :unique_id");
$stm->execute([":unique_id" => $_SESSION["unique_id"]]);
$res = $stm->fetch(PDO::FETCH_ASSOC);

// send error message if name is empty
if (!empty($fName) && !empty($lName)) {
        // update user fName if not same as previous name
        if ($fName !== $res["fName"]) {
                update_user("fName", $fName, $pdo);
        }
        // update user lName if not same as previous name
        if ($lName !== $res["lName"]) {
                update_user("lName", $lName, $pdo);
        }
} else {
        http_response_code(400);
        echo json_encode(["result" => "name is required"]);
}

// return error if about is empty
if (!empty($about)) {
        // update user about if not same as previous about
        if ($about !== $res["about"]) {
                update_user("about", $about, $pdo);
        }
} else {
        http_response_code(400);
        echo json_encode(["result" => "about user is required"]);
}

// set update profile picture
if (!empty($_FILES['profile_pic']["name"])) {
        if (upload_img($_FILES["profile_pic"])) {
                unlink("{$_SERVER['DOCUMENT_ROOT']}/projects/Wechat/upload/{$res["profile_pic"]}");
                update_user("profile_pic", $file_name, $pdo);
        }
}
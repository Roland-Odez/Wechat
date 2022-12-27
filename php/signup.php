<?php
session_start();
include_once "./config.php";
include "../functions/form-validation.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


if (!empty($_POST["fName"]) && !empty($_POST["lName"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
    $fName = validate($_POST["fName"]);
    $lName = validate($_POST["lName"]);
    $email = validate($_POST["email"]);
    $password = validate($_POST["password"]);
    $file_name = "";
    // validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (valid_pass($password)) {
            if (isset($_FILES['profile_pic'])) {
                $targetDir = '../upload/';
                $imageFileType = strtolower(pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION));
                $file_name = time() . '.' . $imageFileType;
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
                if ($check === false) {
                    http_response_code(400);
                    echo json_encode(["message" => "File is not an image"]);
                } else {
                    $val_type = ["jpg", "jpeg", "png", "gif"];
                    if (in_array($imageFileType, $val_type)) {
                        if (!move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetDir . $file_name)) {
                            http_response_code(400);
                            echo json_encode(["message" => "Sorry there was an error uploading your file"]);
                        }
                    } else {
                        http_response_code(400);
                        echo json_encode(["message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."]);
                    }
                }
            }
            $unique_id = uniqid();
            $sql = 'INSERT INTO users(fName, lName, email, password, profile_pic, unique_id) VALUES(:fName, :lName, :email, :password, :profile_pic, :unique_id)';

            $statement = $pdo->prepare($sql);

            if (empty($file_name)) {
                $file_name = "unknown.png";
            }
            $result = $statement->execute([
                ':fName' => strtolower($fName),
                ':lName' => strtolower($lName),
                ':email' => strtolower($email),
                ':password' => $password,
                ':profile_pic' => $file_name,
                ':unique_id' => $unique_id
            ]);

            if ($result) {
                $_SESSION["unique_id"] = $unique_id;
                http_response_code(200);
                echo json_encode(["result" => "success"]);
            } else {
                http_response_code(401);
                echo json_encode(["result" => "sever unable to signup"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["result" => "weak password"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["result" => "invalid email address"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["result" => "All input is required"]);
}
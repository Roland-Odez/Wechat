<?php
session_start();
include_once "./config.php";
include "../functions/form-validation.php";
include "../functions/update_status.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// check of email and password input is empty
if (!empty($_POST["email"]) && !empty($_POST["password"])) {

    $email = validate($_POST["email"]);
    $password = validate($_POST["password"]);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $sql = "SELECT unique_id FROM users WHERE email = :email AND password = :password";

        $statement = $pdo->prepare($sql);

        $statement->execute([
            ':email' => $email,
            ':password' => $password
        ]);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $_SESSION["unique_id"] = $result["unique_id"];
            update_status(1, $pdo);
            http_response_code(200);
            echo json_encode(["result" => "success"]);
        } else {
            http_response_code(401);
            echo json_encode(["result" => "wrong email or password"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["result" => "invalid email address"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["result" => "All input is required"]);
}
<?php
session_start();
include_once "./config.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if (!empty($_POST['message'])) {
    $sql = "INSERT INTO messages(incoming_id, outgoing_id, message) VALUES(:incoming_id, :outgoing_id, :message)";
    $statement = $pdo->prepare($sql);
    $result = $statement->execute([
        ':incoming_id' => $_POST['incoming_id'],
        ':outgoing_id' => $_POST['outgoing_id'],
        ':message' => $_POST['message']
    ]);

    if ($result) {
        http_response_code(200);
        echo json_encode(["result" => "message sent"]);
    } else {
        http_response_code(400);
        echo json_encode(["result" => "message not sent"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["result" => "no message input"]);
}
<?php
session_start();
include_once "./config.php";
include "../functions/read_all_msg.php";
include "../functions/get_user_status.php";
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
// takes raw data from the request 
$json = file_get_contents('php://input');
// Converts it into a PHP object 
$data = json_decode($json, true);

$unique_id = $_SESSION["unique_id"];
// $unique_id = "63a0a5a785fae";


$sql = "SELECT * FROM messages 
        LEFT JOIN users  ON users.unique_id = messages.outgoing_id
        WHERE (incoming_id = :incoming_id AND outgoing_id = :outgoing_id) 
        OR (incoming_id = :outgoing_id AND outgoing_id = :incoming_id)
        ORDER BY msg_id";

$statement = $pdo->prepare($sql);

$statement->execute([':incoming_id' => $data['incoming_id'], ':outgoing_id' => $data['outgoing_id']]);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

$output = " ";

foreach ($result as $user) {

    if ($user["outgoing_id"] === $unique_id) {

        $output .= "
        
                <div class='chat outgoing'>
                    <div class='details'>
                        <p>{$user["message"]}</p>
                    </div>
                </div>

                    ";
    } else {
        $output .= "
            
                <div class='chat incoming'>
                    <img src='./upload/{$user["profile_pic"]}' alt='{$user["fName"]}'>
                    <div class='details'>
                        <p>{$user["message"]}</p>
                    </div>
                </div>
            
                    ";
    }
}

read_all_msg($data["outgoing_id"], $pdo);
$status = get_user_status($data['incoming_id'], $pdo) ? "online" : "offline";
echo json_encode(["result" => $output, "status" => $status]);
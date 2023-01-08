<?php
session_start();
include_once "./config.php";
include "../functions/read_all_msg.php";
include "../functions/get_user_status.php";
include "../functions/get_messages.php";
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
// takes raw data from the request 
$json = file_get_contents('php://input');
// Converts it into a PHP object 
$data = json_decode($json, true);

$unique_id = $_SESSION["unique_id"];

$result = get_messages($pdo, $data['incoming_id'], $data['outgoing_id']);

$output = " ";

// making first previous user message to outgoing sender to avoid error on first check of previous user message
$previousUserMessage["outgoing_id"] = $_SESSION["unique_id"];

foreach ($result as $user) {

    // check if user is reciever or sender
    if ($user["outgoing_id"] === $unique_id) {

        $output .= "
        
        <div class='chat outgoing'>
            <div class='details'>
                <p>{$user["message"]}</p>
            </div>
        </div>
        
        ";
    } else if ($previousUserMessage["outgoing_id"] !== $unique_id
    ) {
        $output .= "
        
        <div class='chat incoming'>
            <img style='visibility: hidden;' src='./upload/{$user["profile_pic"]}' alt='{$user["fName"]}'>
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
    // set previous user message
    $previousUserMessage["outgoing_id"] = $user["outgoing_id"];
}

// reciever read's all unread sender messages
read_all_msg($data["outgoing_id"], $pdo);

// get the status of the reciever 
$status = get_user_status($data['incoming_id'], $pdo) ? "online" : "offline";

echo json_encode(["result" => $output, "status" => $status]);
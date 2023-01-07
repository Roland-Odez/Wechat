<?php
session_start();
include_once "./config.php";
include "../functions/search_users.php";

header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');

// takes raw data from the request 
$json = file_get_contents('php://input');
// Converts it into a PHP object 
$data = json_decode($json, true);

$output = "";

if (!empty($data)) { // check if incoming data from from search bar is empty

    $unique_id = $_SESSION["unique_id"]; // user unique_id

    $pattern = '%' . $data['searchBar'] . '%'; // user search pattern

    $result = search_users($pattern, $unique_id, $pdo); // search's for users that match the pattern

    foreach ($result as $user) {

        if ($user["status"]) { // check if searched user is online

            $fName = ucfirst($user["fName"]);
            $lName = ucfirst($user["lName"]);

            // add online notification
            $output .= "
    
                    <a href='./chat.php?unique_id={$user["unique_id"]}'>
                        <div class='content'>
                            <img src='./upload/{$user["profile_pic"]}' alt='{$user["fName"]}'>
                            <i class='fas fa-circle'></i>
                            <div class='details'>
                                <span>{$fName} {$lName}</span>
                            </div>
                        </div>
                    </a>
            
                    ";
        } else {
            // remove online notification
            $output .= "
    
                    <a href='./chat.php?unique_id={$user["unique_id"]}'>
                        <div class='content'>
                            <img src='./upload/{$user["profile_pic"]}' alt='{$user["fName"]}'>
                            <div class='details'>
                                <span>{$user["fName"]} {$user["lName"]}</span>
                            </div>
                        </div>
                    </a>
            
                    ";
        }
    }

    echo json_encode(["result" => $output]);
}
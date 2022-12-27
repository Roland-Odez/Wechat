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

if (!empty($data)) {

    $unique_id = $_SESSION["unique_id"];

    $pattern = '%' . $data['searchBar'] . '%';

    $result = search_users($pattern, $unique_id, $pdo);

    foreach ($result as $user) {

        if ($user["status"]) {

            $fName = ucfirst($user["fName"]);
            $lName = ucfirst($user["lName"]);

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

// print_r($data["searchBar"]);
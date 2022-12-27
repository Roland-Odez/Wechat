<?php
session_start();
include_once "./config.php";
include_once "../functions/get_unread_nums.php";
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$unique_id = $_SESSION["unique_id"];
// $unique_id = "63a1b35716ab1";

$sql = "SELECT * FROM users WHERE unique_id <> :unique_id";

$stm = $pdo->prepare($sql);

$stm->execute([':unique_id' => $unique_id]);

$result1 = $stm->fetchAll(PDO::FETCH_ASSOC);

$output = "";

for ($i = 0; $i < count($result1); $i++) {

    $sql2 = "SELECT * FROM messages
             WHERE (incoming_id = :incoming_id  OR outgoing_id = :incoming_id) 
             AND (outgoing_id = :outgoing_id OR incoming_id = :outgoing_id)
             ORDER BY msg_id DESC 
             LIMIT 1
            ";
    $statement = $pdo->prepare($sql2);

    $statement->execute([':incoming_id' => $result1[$i]["unique_id"], ':outgoing_id' => $unique_id]);

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $message = "";

    $unread_msg = get_unread_nums($result1[$i]["unique_id"], $unique_id, $pdo);

    if (!empty($result)) {

        if ($result[0]["incoming_id"] === $unique_id) {
            $message = $result[0]["message"];
        } else {
            $message = "you: {$result[0]["message"]}";
        }

        $read = ($result[0]["is_read"]) ? "read" : "offline";
        $read = ($result[0]["outgoing_id"] === $unique_id) ? "read" : $read;

        if ($result1[$i]["status"]) {
            $fName = ucfirst($result1[$i]["fName"]);
            $lName = ucfirst($result1[$i]["lName"]);
            $output .= "

                    <a href='./chat.php?unique_id={$result1[$i]["unique_id"]}'>
                        <div class='content'>
                            <img src='./upload/{$result1[$i]["profile_pic"]}' alt='{$result1[$i]["fName"]}'>
                            <i class='fas fa-circle'></i>
                            <div class='details'>
                                <span>{$fName} {$lName}</span>
                                <p>{$message}</p>
                            </div>
                        </div>
                        <div class='status-dot {$read}'><span>{$unread_msg}</span></div>
                    </a>

                    ";
        } else {
            $output .= "

                    <a href='./chat.php?unique_id={$result1[$i]["unique_id"]}'>
                        <div class='content'>
                            <img src='./upload/{$result1[$i]["profile_pic"]}' alt='{$result1[$i]["fName"]}'>
                            <div class='details'>
                                <span>{$result1[$i]["fName"]} {$result1[$i]["lName"]}</span>
                                <p>{$message}</p>
                            </div>
                        </div>
                        <div class='status-dot {$read}'><i class='fas fa-circle'></i></div>
                    </a>

                    ";
        }
    }
}
echo json_encode(["result" => $output]);
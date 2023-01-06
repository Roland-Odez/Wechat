<?php
function update_user(String $update, $value, PDO $pdo)
{

    try {
        $sql = "UPDATE users
            SET {$update} = :value
            WHERE unique_id = :unique_id";

        // prepare statement
        $statement = $pdo->prepare($sql);

        // exection statement
        return $statement->execute([":value" => $value, ":unique_id" => "63a0a5a785fae"]);

        // if ($result) {
        //     http_response_code(200);
        //     echo json_encode(["result" => "updated $update!"]);
        // } else {
        //     http_response_code(400);
        //     echo json_encode(["result" => "unable to update {$update}"]);
        // }
    } catch (\PDOException $th) {
        echo $th;
    }
}
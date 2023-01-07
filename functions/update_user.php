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

    } catch (\PDOException $th) {
        echo $th;
    }
}
<?php

function update_status(int $status, PDO $pdo)
{
    $sql = 'UPDATE users
            SET status = :status
            WHERE unique_id = :unique_id';

    // prepare statement
    $statement = $pdo->prepare($sql);

    // exection statement
    $result = $statement->execute([':unique_id' => $_SESSION['unique_id'], ":status" => $status]);

    return $result;
}
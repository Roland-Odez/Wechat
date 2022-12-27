<?php

include "../php/config.php";
function get_unread_nums(String $incoming, String $outgoing, PDO $pdo)
{
    $sql = 'SELECT is_read
            FROM messages
            WHERE (is_read = 0) AND (outgoing_id = :incoming_id AND incoming_id = :outgoing_id)
           ';

    // prepare statement
    $statement = $pdo->prepare($sql);

    // exection statement
    $statement->execute([':incoming_id' => $incoming, ':outgoing_id' => $outgoing]);

    return $statement->rowCount();
}
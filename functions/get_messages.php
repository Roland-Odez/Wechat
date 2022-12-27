<?php
include "../php/config.php";

function get_messages(PDO $pdo = $pdo, String $incoming, String $outgoing)
{
    $sql = "SELECT * FROM messages 
            LEFT JOIN users  ON users.unique_id = messages.outgoing_id
            WHERE (incoming_id = :incoming_id AND outgoing_id = :outgoing_id) 
            OR (incoming_id = :outgoing_id AND outgoing_id = :incoming_id)
            ORDER BY msg_id";

    $statement = $pdo->prepare($sql);

    $statement->execute([':incoming_id' => $incoming, ':outgoing_id' => $outgoing]);

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
};
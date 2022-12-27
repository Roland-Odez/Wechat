<?php
function read_all_msg(String $outgoing, PDO $pdo)
{

        $sql2 = "UPDATE messages
                 SET is_read = 1
                 WHERE (is_read = 0) AND (incoming_id = :outgoing_id)
                ";
        $statement2 = $pdo->prepare($sql2);
        $statement2->execute([":outgoing_id" => $outgoing]);
}
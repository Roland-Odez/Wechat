<?php
function get_user_status(String $user, PDO $pdo)
{
    $sql =
        "SELECT status
            FROM users
            WHERE unique_id = :unique_id";
    $stm = $pdo->prepare($sql);

    $stm->execute(['unique_id' => $user]);

    $user =  $stm->fetch(PDO::FETCH_ASSOC);
    
    return $user["status"];
}
<?php
function search_users(String $pattern, $unique_id, $pdo)
{
    $sql = "SELECT * FROM users 
            WHERE (fName LIKE :pattern OR lName LIKE :pattern) AND NOT unique_id = :unique_id";
    $statement = $pdo->prepare($sql);
    $statement->execute([':unique_id' => $unique_id, ':pattern' => $pattern]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
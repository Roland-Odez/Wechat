<?php
function validate($data)
{

    $data = trim($data);

    $data = stripslashes($data);

    $data = htmlspecialchars($data);

    return $data;
}

function valid_pass(String $password)
{
    $r1 = '/[A-Z]/';  //Uppercase
    $r2 = '/[a-z]/';  //lowercase
    $r3 = '/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
    $r4 = '/[0-9]/';  //numbers

    if (preg_match_all($r1, $password, $o) < 1) return FALSE;

    if (preg_match_all($r2, $password, $o) < 1) return FALSE;

    if (preg_match_all($r3, $password, $o) < 1) return FALSE;

    if (preg_match_all($r4, $password, $o) < 1) return FALSE;

    if (strlen($password) < 8) return FALSE;

    return TRUE;
}
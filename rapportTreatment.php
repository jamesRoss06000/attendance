<?php
require_once("connection.php");

$result = $connect->query("SELECT id, classe FROM classes");
$result3 = $connect->query("SELECT id, nom FROM users WHERE role = 'etudiant'");

function verifyFields($field)
{
    $classe = filter_input(INPUT_POST, "classe");
    $etudiant = filter_input(INPUT_POST, "etudiant");

    $msgReturn = "";

    switch ($field) {
        case "classe":
            if ($classe == "") {
                $msgReturn .= "Please select a class<br>";
            }
            break;
        case "etudiant":
            if ($etudiant == "") {
                $msgReturn .= "Please select the student<br>";
            }
            break;
    }
    return $msgReturn;
}

function checkError($post)
{
    $Error = [];
    foreach ($post as $key => $value) {
        $err = verifyFields($key);
        if (strlen($err) > 0)
            $Error[] = $err;
    }
    return $Error;
}

<?php
require_once("connection.php");

function verifyFields($field)
{
    // $fieldInput = $_POST[$field];
    $justificatif = filter_input(INPUT_POST, "justificatif");

    $msgReturn = "";

    switch ($field) {
        case "justificatif":
            if (strlen($justificatif) < 5) {
                $msgReturn .= "Please add a valid reason for absence<br>";
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

if (isset($_POST["justificatif"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $justificatif = filter_input(INPUT_POST, "justificatif");
        $conn = new PDO('mysql:host=localhost;dbname=attendance', $dbUserName, $dbPassword);
        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {
            $sql = "INSERT INTO `justificatifs`(`id_justificatif`, `justificatif`) VALUES (NULL,'" . $justificatif . "')";
            $add = $conn->prepare($sql);
            $add->execute();
            header('Location: addJustificatif.php?id=database_updated');
        }
        mysqli_close($conn);
    }
}

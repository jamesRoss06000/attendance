<?php
require_once("connection.php");

function verifyFields2($field)
{
    // $fieldInput = $_POST[$field];
    $classe = filter_input(INPUT_POST, "classe");
    $debut = filter_input(INPUT_POST, "debut");
    $fin = filter_input(INPUT_POST, "fin");

    $msgReturn = "";

    switch ($field) {
        case "classe":
            if (strlen($classe) < 5) {
                $msgReturn .= "Please add a valid classe name, 5 letters minimum<br>";
            }
            break;
        case "debut":
            if ($debut == "") {
                $msgReturn .= "Please enter a start date<br>";
            }
            break;
        case "fin":
            if ($fin == "") {
                $msgReturn .= "Please enter a end date<br>";
            }
            break;
    }
    return $msgReturn;
}

function checkError($post)
{
    $Error = [];
    foreach ($post as $key => $value) {
        $err = verifyFields2($key);
        if (strlen($err) > 0)
            $Error[] = $err;
    }
    return $Error;
}

if (isset($_POST["classe"], $_POST["debut"], $_POST["fin"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $classe = filter_input(INPUT_POST, "classe");
        $debut = filter_input(INPUT_POST, "debut");
        $fin = filter_input(INPUT_POST, "fin");
        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {
            $sql = "INSERT INTO `classes`(`id`, `classe`, `debut_cours`, `fin_cours`) VALUES (NULL,'" . $classe . "','" . $debut . "','" . $fin . "')";
            $add = $conn->prepare($sql);
            $add->execute();
            header('Location: addClasse.php?id=database_updated');
        }
        mysqli_close($conn);
    }
}

<?php
require_once("connection.php");

function verifyFields($field)
{
    $fieldInput = $_POST[$field];
    $campus = filter_input(INPUT_POST, "campus");
    $adresse = filter_input(INPUT_POST, "adresse");
    $telephone = filter_input(INPUT_POST, "telephone");
    $RegExpTelephone = "/^([0-9])+$/";
    $RegExpEmail = "/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/";

    $msgReturn = "";

    switch ($field) {
        case "campus":
            if (strlen($campus) < 4) {
                $msgReturn .= "Please add a valid campus name<br>";
            }
            break;
        case "adresse":
            if (strlen($adresse) < 10) {
                $msgReturn .= "Please enter a valid address<br>";
            }
            break;
        case "telephone":
            if (!preg_match($RegExpTelephone, $fieldInput) || strlen($telephone) < 10 || strlen($telephone) > 10) {
                $msgReturn .= "Please enter a 10 digit, French telephone number<br>";
            }
            break;
        case "email":
            if (!preg_match($RegExpEmail, $fieldInput)){
                $msgReturn .= "Valid email address needed<br>";
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

if (isset($_POST["campus"], $_POST["adresse"], $_POST["telephone"], $_POST["email"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $campus = filter_input(INPUT_POST, "campus");
        $adresse = filter_input(INPUT_POST, "adresse");
        $telephone = filter_input(INPUT_POST, "telephone");
        $email = filter_input(INPUT_POST, "email");
        $conn = new PDO('mysql:host=localhost;dbname=attendance', $dbUserName, $dbPassword);
        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {
            $sql = "INSERT INTO `lieux`(`id`, `campus`, `adresse`, `telephone`, `email`) VALUES (NULL,'" . $campus . "','" . $adresse . "','" . $telephone . "','" . $email . "')";
            $add = $conn->prepare($sql);
            $add->execute();
            header('Location: addCampus.php?id=');
        }
        mysqli_close($conn);
    }
}

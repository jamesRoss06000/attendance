<?php
require_once("connection.php");

$result = $connect->query("SELECT * FROM users");

function verifyFields($field)
{
    $nom = filter_input(INPUT_POST, "nom");
    $telephone = filter_input(INPUT_POST, "telephone");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $classe = filter_input(INPUT_POST, "classe");
    $role = filter_input(INPUT_POST, "role");

    $msgReturn = "";

    switch ($field) {
        case "classe":
            if ($classe == "") {
                $msgReturn .= "Please select a class<br>";
            }
            break;
        case "nom":
            if ($nom == "") {
                $msgReturn .= "Please select the student<br>";
            }
            break;
        case "telephone":
            if ($telephone == "") {
                $msgReturn .= "Please add a telephone number<br>";
            }
            break;
        case "email":
            if ($email == "" && $telephone = "oui") {
                $msgReturn .= "Please add email address<br>";
            }
            break;
        case "password":
            if ($password == "") {
                $msgReturn .= "Please add password<br>";
            }
            break;
        case "role":
            if ($role == "") {
                $msgReturn .= "Please add role<br>";
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

if (isset($_POST["classe"], $_POST["nom"], $_POST["telephone"], $_POST["email"], $_POST["password"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $id = $_GET['id'];
        $nom = filter_input(INPUT_POST, "nom");
        $telephone = filter_input(INPUT_POST, "telephone");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $classe = filter_input(INPUT_POST, "classe");
        $role = filter_input(INPUT_POST, "role");

        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {
            $sql = $conn->prepare("UPDATE `users` SET `nom`=:nom, `telephone`=:telephone, `email`=:email, `password`=:password, `role`=:role, `classe`=:classe where `id`=:id");
            $sql->bindParam(':nom', $nom);
            $sql->bindParam(':telephone', $telephone);
            $sql->bindParam(':email', $email);
            $sql->bindParam(':password', $password);
            $sql->bindParam(':role', $role);
            $sql->bindParam(':classe', $classe);
            $sql->bindParam(':id', $id);
            $sql->execute();
            header('Location: mainMenu.php?id=Database_updated');
        }
    }
}

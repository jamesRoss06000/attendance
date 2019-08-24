<?php
require_once("connection.php");

$result = $connect->query("SELECT id, classe FROM classes");
$result2 = $connect->query("SELECT password FROM password");
$result3 = $connect->query("SELECT email FROM emails");
$result4 = $connect->query("SELECT email FROM emails");

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
                // $msgReturn .= "Please select an option<br>";
            }
            break;
        case "email":
            if ($email == "" && $telephone = "oui") {
                $msgReturn .= "Please select justification for absence<br>";
            }
            break;
        case "password":
            if ($password == "") {
                $msgReturn .= "Please select password ID<br>";
            }
            break;
        case "role":
            if ($role == "") {
                $msgReturn .= "Please select role<br>";
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
            $sql= $conn->prepare = "INSERT INTO `users`(`id`, `nom`, `telephone`, `email`, `password`, `role`, `classe`) VALUES (NULL, :nom, :telephone, :email, :password, :role, :classe)";
            $sql->execute([':id' => $id, ':nom' => $nom, ':telephone' => $telephone, ':email' => $email, ':password' => $password, ':role' => $role, ':classe' => $classe]);
            // sleep(2);
            header('Location: modifyUserHome.php?id=Database_updated');
        }
        // mysqli_close($conn);
    }
}

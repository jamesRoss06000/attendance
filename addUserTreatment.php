<?php
require_once("connection.php");

$result = $connect->query("SELECT classe FROM classes");

function verifyFields($field)
{
    $RegExpEmail = "/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/";
    $fieldInput = $_POST[$field];
    $password = filter_input(INPUT_POST, "password");
    $confirmPassword = filter_input(INPUT_POST, "confirmPassword");
    $role = filter_input(INPUT_POST, "role");
    $classe = filter_input(INPUT_POST, "classe");

    $msgReturn = "";

    switch ($field) {
        case "email":
            if (!preg_match($RegExpEmail, $fieldInput)) {
                $msgReturn .= "Valid email address needed<br>";
            }
            break;
        case "password":
            if (strlen($fieldInput) < 5) {
                $msgReturn .= "Password needs at least 5 characters<br>";
            }
            break;
        case "confirmPassword":
            if ($confirmPassword !== $password) {
                $msgReturn .= "The two passwords need to match<br>";
            }
            break;
        case "role":
            if ($role == "") {
                $msgReturn .= "Please select the new user's role<br>";
            }
            break;
        case "classe":
            if ($classe == "") {
                $msgReturn .= "Please select the new user's role<br>";
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

if (isset($_POST["name"], $_POST["email"], $_POST["password"], $_POST["role"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $name = filter_input(INPUT_POST, "name");
        $telephone = filter_input(INPUT_POST, "telephone");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $role = filter_input(INPUT_POST, "role");
        $classe = filter_input(INPUT_POST, "classe");
        $conn = new PDO('mysql:host=localhost;dbname=attendance', $dbUserName, $dbPassword);
        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {
            $sql = $conn->prepare("INSERT INTO `users`(`id`, `nom`, `telephone`, `email`, `password`, `role`, `classe`) VALUES (NULL, :name, :telephone, :email, :password, :role, :classe)");
            $sql->execute([':name' => $name, ':telephone' => $telephone, ':email' => $email, ':password' => $password, ':role' => $role, ':classe' => $classe]);
            header('Location: addUser.php?id=databaseUpdated');
        }
        mysqli_close($conn);
    }
}

<?php
require_once("connection.php");

if (isset($_POST["email"], $_POST["password"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT email, password, role FROM users WHERE email = '" . $email . "' AND password = '" . $password . "'";
    $result1 = $conn->query($sql);
    // if (mysqli_num_rows($result1) > 0) {   
                 if ($result1->rowCount() > 0 && $email == "admin@admin.com") {
        $LoggedIn = true;
        sleep(2);
        header("Location: mainMenu.php");
    } else {
        $errors = "The username or password are incorrect!";
    }
}
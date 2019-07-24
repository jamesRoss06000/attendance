<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type");

require_once("connection2.php");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if (isset($_POST["email"], $_POST["password"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $result = $stmt->execute([':email' => $email, ':password' => $password]);

    if ($stmt->rowCount()>0) {
        $output = array();
        $output = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($output);
    } else {
        $errors["email"] = "Error";
        $errors["password"] = "Error";
        echo json_encode($errors);
    }
    // $conn->close();
}
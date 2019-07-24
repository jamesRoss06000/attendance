<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type");

require_once("connection2.php");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if (isset($_POST["date"])) {

    $origDate = date("Y-m-d", strtotime($_POST['date']));
    $date = $origDate;
    $id = $_GET['id'];
    $time = $_POST['time'];
    $cours = $_POST['cours'];

    $getName = $conn->prepare("SELECT nom FROM users WHERE id = :id");
    $getName->execute([':id' => $id]);
    $details = $getName->fetchAll();
    $name = $details[0]['nom'];

    $stmt = $conn->prepare("SELECT * FROM cours WHERE intervenant = :name AND date = :date AND time = :time AND cours = :cours");
    $stmt->execute([':name' => $name, ':date' => $date, ':cours' => $cours, ':time' => $time]);

    if ($stmt->rowCount() > 0) {    
        $output = $stmt->fetchAll();
        echo json_encode($output);
    } else {
        $errors = "No data found for this date";
        echo json_encode($errors);
    }
    // $conn->close();
}

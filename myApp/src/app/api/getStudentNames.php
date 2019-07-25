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
    $classe = $_POST['classe'];

    $getName = $conn->prepare("SELECT nom FROM users WHERE id = :id");
    $getName->execute([':id' => $id]);
    $details = $getName->fetchAll();
    $name = $details[0]['nom'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE `classe` = :classe");
    $stmt->execute([':classe' => $classe]);

    if ($stmt->rowCount() > 0) {
        $output = $stmt->fetchAll();
        for ($i = 0; $i < sizeof($output); $i++) {

            array_push($output[$i], $cours, $date);
        }
        echo json_encode($output);
    } else {
        $errors = "No data found for this date";
        echo json_encode($errors);
    }
    // $conn->close();
}

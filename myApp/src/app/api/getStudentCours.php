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

    $getStudent = $conn->prepare("SELECT nom FROM users WHERE id = :id");
    $getStudent->execute([':id' => $id]);
    $studentDetails = $getStudent->fetchAll();
    $studentName = $studentDetails[0]['nom'];

    $stmt = $conn->prepare("SELECT * FROM cours WHERE etudiant = :studentName AND date = :date ORDER BY `time` ASC");
    $stmt->execute([':date' => $date, ':studentName' => $studentName]);

    if ($stmt->rowCount() > 0) {
        $output = array();
        $output = $stmt->fetchAll();
        echo json_encode($output);
    } else {
        $errors = "No data found for this date";
        echo json_encode($errors);
        return;
    }
    // $conn->close();
}

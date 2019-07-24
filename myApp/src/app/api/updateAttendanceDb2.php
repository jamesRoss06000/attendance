<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type");

require_once("connection2.php");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if (isset($_POST["date"])) {

    $date = $_POST['date'];
    $id_planning = $_GET['id'];
    $time = $_POST['time'];
    $cours = $_POST['cours'];
    $id_student = $_POST['id_student'];
    $name = $_POST['name'];

    $stmt = $conn->prepare("UPDATE `cours` SET `present`= 'non' WHERE `date` = :date AND `etudiant` = :name AND `time` = :time AND `cours` = :cours");
    echo $stmt->execute([':date' => $date, ':cours' => $cours, ':time' => $time, ':name' => $name]);
} else {
    $errors = "Update unsuccessful";
    echo json_encode($errors);
}
    // $conn->close();

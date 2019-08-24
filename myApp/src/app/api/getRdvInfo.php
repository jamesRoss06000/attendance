<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type");

require_once("connection2.php");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$stmt2 = $conn->prepare("SELECT campus FROM lieux");
$stmt2->execute();
if ($stmt2->rowCount() > 0) {
    $output1 = array();
    $output1 = $stmt2->fetchAll();

    $stmt = $conn->prepare("SELECT classe FROM classes");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $output = array();
        $output = $stmt->fetchAll();
        $outputEnd = array();
        array_push($outputEnd, $output, $output1);
        echo json_encode($outputEnd);
    } else {
        $errors = "No data found";
        echo json_encode($errors);
    }
}

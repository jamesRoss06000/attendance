<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type");

require_once("connection2.php");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

    $stmt = $conn->prepare("SELECT classe FROM classes");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $output = array();
        $output = $stmt->fetchAll();
        // var_dump($output);
        echo json_encode($output);
    } else {
        $errors = "No data found";
        echo json_encode($errors);
    }
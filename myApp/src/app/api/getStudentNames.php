<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type");

require_once("connection2.php");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if (isset($_POST['date'])) {

    $origDate = date("Y-m-d", strtotime($_POST['date']));
    $date = $origDate;
    $id = $_GET['id'];
    $id_planning = $_POST['id_planning'];
    // echo json_encode($date);
    $getClasse = $conn->prepare("SELECT * FROM planning WHERE `id_planning` = :id_planning");
    $getClasse->execute([':id_planning' => $id_planning]);
    $getDetails = $getClasse->fetchAll();
    $classe = $getDetails[0]['classe'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE `classe` = classe OR `nom` = :nom");
    $stmt->execute([':nom' => $classe, ':classe' => $classe]);

    if ($stmt->rowCount() > 0) {
        $output = array();
        $output = $stmt->fetchAll();
        $newArray = array();
        array_push($newArray, $output, $id_planning);
        echo json_encode($output);
    } else {
        $errors = "No data found for this date";
        echo json_encode($errors);
        return;
    }
    // $conn->close();
}

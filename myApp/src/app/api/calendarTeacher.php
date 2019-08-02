<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type");

require_once("connection2.php");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if (isset($_POST["id"])) {

    $id = $_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM planning WHERE intervenant_id = :id ORDER BY `debut_am` ASC");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        $output = array();
        $output = $stmt->fetchAll();
        echo json_encode($output);
    } else {
        $errors = "No data found for this date";
        echo json_encode($errors);
    }
    // $conn->close();
}

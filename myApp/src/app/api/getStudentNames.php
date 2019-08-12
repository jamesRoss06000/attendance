<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type");
require_once("connection2.php");
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);
//var_dump($_POST);
if (isset($_POST["date"])) {
    $origDate = date("Y-m-d", strtotime($_POST['date']));
    $date = $origDate;
    $id = $_GET['id'];
    $id_planning = $_POST['id_planning'];

    $getClasse = $conn->prepare("SELECT * FROM planning WHERE id_planning = :id_planning");
    $getClasse->execute([':id_planning' => $id_planning]);
    $details = $getClasse->fetchAll();
    $classe = $details[0]['classe'];
    $nom = $details[0]['nom'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE `nom` = :nom AND `classe` = :classe");
    $stmt->execute([':nom' => $nom, ':classe' => $classe]);
    if ($stmt->rowCount() > 0) {
        $output = array();
        $output = $stmt->fetchAll();
        $newOutput = array();
        array_push($newOutput, $output, $id_planning);
        echo json_encode($newOutput);
    } else {
        $stmt1 = $conn->prepare("SELECT * FROM users WHERE `classe` = :classe");
        $stmt1->execute([':classe' => $classe]);
        if ($stmt1->rowCount() > 0) {
            $output1 = array();
            $output1 = $stmt1->fetchAll();
            $newOutput1 = array();
            array_push($newOutput1, $output1, $id_planning);
            echo json_encode($newOutput1);
        }
    }
    // $conn->close();
}
// else{
//     $errors = "No data found for this date!";
// echo json_encode($errors);
// }

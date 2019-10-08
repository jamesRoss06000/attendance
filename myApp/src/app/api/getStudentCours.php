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

    $getStudent = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $getStudent->execute([':id' => $id]);
    $studentDetails = $getStudent->fetchAll();
    $studentClasse = $studentDetails[0]['classe'];
    $studentNom = $studentDetails[0]['nom'];
                                                //    WHERE `classe` = 'G1C1' AND `nom` = NULL OR `nom` = 'AAA'
    $stmt = $conn->prepare("SELECT * FROM planning WHERE (`classe` = :studentClasse AND `nom` IS NULL) OR (`nom` = :studentNom) AND `date` = :date ORDER BY `debut_am` ASC");
    // $stmt = $conn->prepare("SELECT * FROM planning WHERE `classe` = (:studentClasse OR :studentNom) AND `date` = :date ORDER BY `debut_am` ASC");
    $stmt->execute([':date' => $date, ':studentClasse' => $studentClasse, ':studentNom' => $studentNom]);

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

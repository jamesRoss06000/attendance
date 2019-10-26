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
    $id_planning = $_POST['id_planning'];

    $getClasse = $conn->prepare("SELECT * FROM planning WHERE id_planning = :id_planning");
    $getClasse->execute([':id_planning' => $id_planning]);
    $details = $getClasse->fetchAll();
    $classe = $details[0]['classe'];
    $nom = $details[0]['nom'];
    $lieux = $details[0]['lieux'];

    $getDates = $conn->prepare("SELECT debut_cours, fin_cours FROM classes WHERE `classe` = :classe");
    $getDates->execute([':classe' => $classe]);
    $resultDates = $getDates->fetchAll();
    $debut_cours = $resultDates[0]['debut_cours'];
    $fin_cours = $resultDates[0]['fin_cours'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE `nom` = :nom AND $date BETWEEN $debut_cours AND $fin_cours 23:59:00");
    $stmt->execute([':nom' => $nom, ':date' => $date, ':debut_cours' => $debut_cours, ':fin_cours' => $fin_cours]);
    if ($stmt->rowCount() > 0) {
        $output = $stmt->fetchAll();
        $newOutput = array();
        array_push($newOutput, $output, $id_planning, $lieux);
        echo json_encode($newOutput);
    } else {
        $stmt1 = $conn->prepare("SELECT * FROM users WHERE `classe` = :classe");
        $stmt1->execute([':classe' => $classe]);
        if ($stmt1->rowCount() > 0) {
            $output1 = $stmt1->fetchAll();
            $newOutput1 = array();
            array_push($newOutput1, $output1, $id_planning, $lieux);
            echo json_encode($newOutput1);
        }
    }
}
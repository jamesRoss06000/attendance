<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type");

require_once("connection2.php");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if (isset($_POST["etudiant_id"])) {
    $newArray = $_POST;
        $origDate = date("Y-m-d", strtotime($_POST['date']));
        $date = $origDate;
        $cours = $_POST['cours'];
        $classe = $_POST['classe'];
        $etudiant_nom = $_POST['etudiant_nom'];
        $etudiant_id = $_POST['etudiant_id'];
        $query = $conn->prepare("INSERT INTO `absences`(`id`, `date`, `cours`, `classe`, `etudiant`, `etudiant_id`, `justified`, `justificatif`) VALUES (NULL, :date, :cours, :classe, :etudiant_nom, :etudiant_id, '', '')");
        $query->execute([':date' => $date, ':cours' => $cours,':classe' => $classe, ':etudiant_nom' => $etudiant_nom, ':etudiant_id' => $etudiant_id]);
        $success = "Absence added to database";
        echo json_encode($success);
}


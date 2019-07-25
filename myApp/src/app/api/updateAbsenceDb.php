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
    $time = $_POST['time'];
    $lieux = $_POST['lieux'];
    $cours = $_POST['cours'];
    $etudiant_nom = $_POST['etudiant_nom'];
    $etudiant_id = $_POST['etudiant_id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE `nom` = :etudiant_nom AND `id` = :etudiant_id");
    $stmt->execute([':etudiant_nom' => $etudiant_nom, ':etudiant_id' => $etudiant_id]);

    if ($stmt->rowCount() > 0) {
        $output = $stmt->fetchAll();
        for ($i = 0; $i < sizeof($output); $i++) {
            $origDate = date("Y-m-d", strtotime($_POST['date']));
            $date = $origDate;
            $cours = $_POST['cours'];
            $classe = $output[$i]['classe'];
            $name = $output[$i]['nom'];
            // $id = $_GET['id'];
            $query = $conn->prepare("INSERT INTO `absences`(`id`, `date`, `cours`, `classe`, `etudiant`, `justified`, `justificatif`) VALUES (NULL, :date, :cours, :classe, :name, '', '')");
            $query->execute([':classe' => $classe, ':name' => $name, ':cours' => $cours, ':date' => $date]);
            $success = "Absence added to database";
            echo json_encode($success);
        }
    } else {
        $errors = "No data found for this date";
        echo json_encode($errors);
    }
    // $conn->close();
}

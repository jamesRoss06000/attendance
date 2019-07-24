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

    $stmt = $conn->prepare("SELECT * FROM cours WHERE date = :date AND time = :time AND cours = :cours AND present ='non'");
    $stmt->execute([':date' => $date, ':cours' => $cours, ':time' => $time]);

    if ($stmt->rowCount() > 0) {
        $output = $stmt->fetchAll();
        for ($i = 0; $i < sizeof($output); $i++) {
            $classe = $output[$i]['classe'];
            $name = $output[$i]['etudiant'];
            $id = $_GET['id'];
            $query = $conn->prepare("INSERT INTO `absences`(`id`, `classe`, `etudiant`, `justified`, `justificatif`,`id_planning`) VALUES (NULL, :classe, :name, '', '', :id)");
            $query->execute([':classe' => $classe, ':name' => $name, ':id' => $id]);
            $success = "Absence added to database";
            echo json_encode($success);     
        }
    } else {
        $errors = "No data found for this date";
        echo json_encode($errors);
    }
    // $conn->close();
}

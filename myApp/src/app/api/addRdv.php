<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type");

require_once("connection2.php");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if (isset($_POST["name"], $_POST["lieu"])) {
    $date = ($_POST['date']);
    $lieux = $_POST['lieu'];
        $getAdresse = $conn->prepare("SELECT * FROM lieux WHERE campus = :lieux");
        $getAdresse->execute([':lieux' => $lieux]);
        $adresseList = $getAdresse->fetchAll();
        $adresse = $adresseList[0]['adresse'];
    $cours = "Individuel RDV";
    $theme = "";
    $time = $_POST['time'];
        if ($time < 12) {
            $debut_am = $time;
            $debut_pm;
            $fin_am = strtotime($time) + 60*60;
            $fin_pm;
        } else {
            $debut_am;
            $debut_pm = $time;
            $fin_am;
            $fin_pm = strtotime($time) + 60*60;
        }

    $intervenant_id = $_GET['id'];
        $getTeacher = $conn->prepare("SELECT * FROM users WHERE id = :intervenant_id");
        $getTeacher->execute([':intervenant_id' => $intervenant_id]);
        $intervenantList = $getTeacher->fetchAll();
        $intervenant_name = $intervenantList[0]['nom'];
    $name = $_POST['name'];

    if (isset($cours)) {
        $sql = $conn->prepare("INSERT INTO `planning`(`id_planning`, `date`, `lieux`, `adresse`, `cours`, `theme`, `debut_am`, `fin_am`, `debut_pm`, `fin_pm`, `intervenant_name`, `intervenant_id`, `classe`) VALUES (NULL, :date, :lieux, :adresse, :cours, :theme, :debut_am, :fin_am, :debut_pm, :fin_pm, :intervenant_name, :intervenant_id, :name)");
        $sql->execute([':date' => $date, ':lieux' => $lieux, ':adresse' => $adresse, ':cours' => $cours, ':theme' => $theme, ':debut_am' => $debut_am, ':fin_am' => $fin_am, ':debut_pm' => $debut_pm, ':fin_pm' => $fin_pm, ':intervenant_name' => $intervenant_name, 'intervenant_id' => $intervenant_id, ':name' => $name]);
        $success = "RDV added";
        echo json_encode($success);
    } else {
        $noSuccess = "Nothing added to database";
        echo json_encode($noSuccess);
    }
}

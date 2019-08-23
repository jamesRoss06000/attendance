<?php
require_once("connection.php");

$result4 = $connect->query("SELECT campus FROM lieux");
$result = $connect->query("SELECT classe FROM classes");
$result2 = $connect->query("SELECT id, nom FROM users WHERE role = 'intervenant'");

function verifyFields($field)
{
    $date = filter_input(INPUT_POST, "date");
    $lieux = filter_input(INPUT_POST, "lieux");
    $cours = filter_input(INPUT_POST, "cours");
    $intervenant = filter_input(INPUT_POST, "intervenant");

    $msgReturn = "";

    switch ($field) {
        case "date":
            if ($date == "") {
                $msgReturn .= "Please select a date<br>";
            }
            break;
        case "lieux":
            if ($lieux == "") {
                $msgReturn .= "Please select location<br>";
            }
            break;
        case "cours":
            if ($cours == "") {
                $msgReturn .= "Please select the subject<br>";
            }
            break;
        case "intervenant":
            if ($intervenant == "") {
                $msgReturn .= "Please select the teacher<br>";
            }
            break;
    }
    return $msgReturn;
}

function checkError($post)
{
    $Error = [];
    foreach ($post as $key => $value) {
        $err = verifyFields($key);
        if (strlen($err) > 0)
            $Error[] = $err;
    }
    return $Error;
}

if (isset($_POST["date"], $_POST["lieux"], $_POST["cours"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $classe = filter_input(INPUT_POST, "classe");
        $date = filter_input(INPUT_POST, "date");
        $lieux = filter_input(INPUT_POST, "lieux");
        $getAdresse = $conn->prepare("SELECT * FROM lieux WHERE campus = :lieux");
        $getAdresse->execute([':lieux' => $lieux]);
        $adresseList = $getAdresse->fetchAll();
        $adresse = $adresseList[0]['adresse'];
        $cours = filter_input(INPUT_POST, "cours");
        $theme = filter_input(INPUT_POST, "theme");
        $debut_am = filter_input(INPUT_POST, "debut_am");
        $fin_am = filter_input(INPUT_POST, "fin_am");
        $debut_pm = filter_input(INPUT_POST, "debut_pm");
        $fin_pm = filter_input(INPUT_POST, "fin_pm");
        $intervenant_id = filter_input(INPUT_POST, "intervenant");
        $getId = $conn->prepare("SELECT * FROM users WHERE id = :intervenant_id");
        $getId->execute([':intervenant_id' => $intervenant_id]);
        $details = $getId->fetchAll();
        $intervenant_name = $details[0]['nom'];

        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {
            $sql = $conn->prepare("INSERT INTO `planning`(`id_planning`, `date`,  `lieux`, `adresse`, `cours`, `theme`, `debut_am`, `fin_am`, `debut_pm`, `fin_pm`, `intervenant_name`, `intervenant_id`, `classe`) VALUES (NULL, :date, :lieux, :adresse, :cours, :theme, :debut_am, :fin_am, :debut_pm, :fin_pm, :intervenant_name, :intervenant_id, :classe)");
            $sql->execute([':date' => $date, ':lieux' => $lieux, ':adresse' => $adresse, ':cours' => $cours, ':theme' => $theme, ':debut_am' => $debut_am, ':fin_am' => $fin_am, ':debut_pm' => $debut_pm, ':fin_pm' => $fin_pm, ':intervenant_name' => $intervenant_name, ':intervenant_id' => $intervenant_id, ':classe' => $classe]);
            header('Location: addPlanning.php?id=Database updated');
        }
        // $conn->close();
    }
}

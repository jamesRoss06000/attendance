<?php
require_once("connection.php");

$result = $connect->query("SELECT id, classe FROM classes");
$result2 = $connect->query("SELECT id_planning, cours FROM planning");
$result4 = $connect->query("SELECT justificatif FROM justificatifs");

function verifyFields($field)
{
    $classe = filter_input(INPUT_POST, "classe");
    $etudiant = filter_input(INPUT_POST, "etudiant");
    $justificatif = filter_input(INPUT_POST, "justificatif");
    $cours = filter_input(INPUT_POST, "cours");
    $date = filter_input(INPUT_POST, "date");

    $msgReturn = "";

    switch ($field) {
        case "classe":
            if ($classe == "") {
                $msgReturn .= "Please select a class<br>";
            }
            break;
        case "etudiant":
            if ($etudiant == "") {
                $msgReturn .= "Please select the student<br>";
            }
            break;
        case "justificatif":
            if ($justificatif == "" && $justified = "oui") {
                $msgReturn .= "Please select justification for absence<br>";
            }
            break;
        case "cours":
            if ($cours == "") {
                $msgReturn .= "Please select lesson<br>";
            }
            break;
        case "date":
            if ($date == "") {
                $msgReturn .= "Please select date<br>";
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

if (isset($_POST["classe"], $_POST["etudiant"], $_POST["cours"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $classe = filter_input(INPUT_POST, "classe");
        $etudiant = filter_input(INPUT_POST, "etudiant");
            $getId = $conn->prepare("SELECT id FROM users WHERE nom = :etudiant");
            $getId->execute([':etudiant' => $etudiant]);
            $details = $getId->fetchAll();
            $etudiant_id = $details[0]['id'];
        $justified = filter_input(INPUT_POST, "justified");
        $justificatif = filter_input(INPUT_POST, "justificatif");
        if ($justificatif == NULL){
            $justificatif = "";
        }
        $cours = filter_input(INPUT_POST, "cours");
        $date = filter_input(INPUT_POST, "date");

        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {
            $sql = $conn->prepare("INSERT INTO `absences`(`id`, `date`, `cours`, `classe`, `etudiant`, `etudiant_id`, `justified`, `justificatif`) VALUES (NULL, :date, :cours, :classe,  :etudiant, :etudiant_id, :justified, :justificatif)");
            $sql->execute([':date' => $date, ':cours' => $cours, ':classe' => $classe, ':etudiant' => $etudiant, ':etudiant_id' => $etudiant_id, ':justified' => $justified, ':justificatif' => $justificatif]);
            header('Location: addAbsences.php?id=Database_updated');
        }
        // $conn->close();
    }
}

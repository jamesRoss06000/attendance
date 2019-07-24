<?php
require_once("connection.php");

$result = $connect->query("SELECT id, classe FROM classes");
$result2 = $connect->query("SELECT id_planning FROM planning");
$result3 = $connect->query("SELECT justificatif FROM justificatifs");
$result4 = $connect->query("SELECT justificatif FROM justificatifs");

function verifyFields($field)
{
    $classe = filter_input(INPUT_POST, "classe");
    $etudiant = filter_input(INPUT_POST, "etudiant");
    $justified = filter_input(INPUT_POST, "justified");
    $justificatif = filter_input(INPUT_POST, "justificatif");
    $planning = filter_input(INPUT_POST, "id_planning");

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
        case "justified":
            if ($justified == "") {
                // $msgReturn .= "Please select an option<br>";
            }
            break;
        case "justificatif":
            if ($justificatif == "" && $justified ="oui") {
                $msgReturn .= "Please select justification for absence<br>";
            }
            break;
        case "id_planning":
            if ($planning == "") {
                $msgReturn .= "Please select planning ID<br>";
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

if (isset($_POST["classe"], $_POST["etudiant"], $_POST["justified"], $_POST["justificatif"], $_POST["id_planning"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $classe = filter_input(INPUT_POST, "classe");
        $etudiant = filter_input(INPUT_POST, "etudiant");
        $justified = filter_input(INPUT_POST, "justified");
        $justificatif = filter_input(INPUT_POST, "justificatif");
        $planning = filter_input(INPUT_POST, "id_planning");
        // echo ("$classe, $etudiant, $justified, $justificatif, $planning");
        $conn = new PDO('mysql:host=localhost;dbname=attendance', $dbUserName, $dbPassword);
        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {
            $sql = "INSERT INTO `absences`(`id`, `classe`, `id_etudiant`, `justified`, `justificatif`, `id_planning`) VALUES (NULL,'" . $classe . "','" . $etudiant . "','" . $justified . "','" . $justificatif . "', '" . $planning . "')";                                  
            $add = $conn->prepare($sql);
            $add->execute();
            // sleep(2);
            header('Location: addAbsences.php?id=Database_updated');
        }
        mysqli_close($conn);
    }
}

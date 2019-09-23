<?php
require_once("connection.php");

$result = $connect->query("SELECT classe FROM classes");

function verifyFields($field)
{
    $fileUpload = basename($_FILES["fileUpload"]["tmp_name"]);
    $classe = filter_input(INPUT_POST, "classe");

    $msgReturn = "";

    switch ($field) {
        case "fileUpload":
            if ($fileUpload == "") {
                $msgReturn .= "Please select a file to upload<br>";
            }
            break;
        case "classe":
            if ($classe == "") {
                $msgReturn .= "Please select a class<br>";
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

if (isset($_POST["classe"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $row = 1;
        if (($handle = fopen($_FILES["fileUpload"]["tmp_name"], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                // $num = count($data);
                // print_r($data);
                if ($row > 1) {
                    $dateFile = explode("/", $data[0]);
                    $origDate = date("Y-m-d", mktime(0, 0, 0, $dateFile[1], $dateFile[0], $dateFile[2]));
                    $date = $origDate;
                    $lieux = $data[1];
                    $adresse = $data[2];
                    $cours = $data[3];
                    $theme = $data[4];
                    $debut_am = $data[5];
                    $fin_am = $data[6];
                    $debut_pm = $data[7];
                    $fin_pm = $data[8];

                    $intervenant_name = $data[9];
                    $getId = $conn->prepare("SELECT id FROM users WHERE nom = :intervenant_name");
                    $getId->execute([':intervenant_name' => $intervenant_name]);
                    $details = $getId->fetchAll();
                    $intervenant_id = $details[0]['id'];

                    $classe = filter_input(INPUT_POST, "classe");
                    $nom = "";

                    if (strlen($intervenant_name) > 1) {
                        $sql = $conn->prepare("INSERT INTO `planning`(`id_planning`, `date`, `lieux`,
                        `adresse`, `cours`, `theme`, `debut_am`, `fin_am`, `debut_pm`, `fin_pm`,
                        `intervenant_name`, `intervenant_id`, `classe`, `nom`) VALUES (NULL, :date,
                        :lieux, :adresse, :cours, :theme, :debut_am, :fin_am, :debut_pm, :fin_pm, :intervenant_name,
                        :intervenant_id, :classe, :nom)");
                        $sql->execute([':date' => $date, ':lieux' => $lieux, ':adresse' => $adresse,
                        ':cours' => $cours, ':theme' => $theme, ':debut_am' => $debut_am, ':fin_am' => $fin_am,
                        ':debut_pm' => $debut_pm, ':fin_pm' => $fin_pm, ':intervenant_name' => $intervenant_name,
                        'intervenant_id' => $intervenant_id, ':classe' => $classe, ':nom' => $nom]);
                    }
                }
                $row++;
            }
            fclose($handle);
        }

        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {

            // $sql = $conn->prepare("INSERT INTO `cours`(`id`, `date`,  `lieux`, `adresse`,  `cours`, `debut_am`, `fin_am`, `debut_pm`, `fin_pm`, `intervenant_name`, `intervenant_id`, `etudiant`, `classe`, `present`) VALUES (NULL, :date, :lieux, :adresse, :cours, :debut_am, :fin_am, :debut_pm, :fin_pm, :intervenant_name, :intervenant_id, :etudiant, :classe, :present)");
            // $sql->execute([':date' => $date, ':lieux' => $lieux, ':adresse' => $adresse,  ':cours' => $cours, ':debut_am' => $debut_am, ':fin_am' => $fin_am, ':debut_pm' => $debut_pm, ':fin_pm' => $fin_pm, ':intervenant_name' => $intervenant_name, ':intervenant_id' => $intervenant_id, ':etudiant' => $etudiant, ':classe' => $classe, ':present' => $present]);
            // header('Location: addEtudiantToCours.php?id=Database updated');
        }
        // mysqli_close($conn);
    }
}

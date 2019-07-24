<?php
require_once("connection.php");

function verifyFields($field)
{
    // $fieldInput = $_POST[$field];
    $fileUpload = basename($_FILES["fileUpload"]["tmp_name"]);

    $msgReturn = "";

    switch ($field) {
        case "fileUpload":
            if ($fileUpload == "") {
                $msgReturn .= "Please select a file to upload<br>";
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

if (isset($_FILES["fileUpload"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $row = 1;
        if (($handle = fopen($_FILES["fileUpload"]["tmp_name"], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                $num = count($data);
                // var_dump($data);
                if ($row > 1) {
                    $nom = $data[0];
                    $telephone = $data[4];
                    $email = $data[3];
                    $password = $data[3];
                    $role = "etudiant";
                    $classe = filter_input(INPUT_POST, "classe");
                    if (strlen($nom) > 1) {
                        $sql = $conn->prepare("INSERT INTO `users`(`id`, `nom`, `telephone`, `email`, `password`, `role`, `classe`) VALUES (NULL, :nom, :telephone, :email, :password, :role, :classe)");
                        $sql->execute([':nom' => $nom, ':telephone' => $telephone, ':email' => $email, ':password' => $password, ':role' => $role, ':classe' => $classe]);
                    }
                }
                $row++;
                // for ($i = 0; $i < $num; $i++) {
                // echo $data[$i] . "<br />\n";
                // }
            }

            fclose($handle);
        }
        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {
            // $sql = $conn->prepare("INSERT INTO `users`(`id`, `name`, `email`, `password`, `role`, `classe`) VALUES (NULL, :name, :email, :password, :role, :classe)");
            // $sql->execute([':fileupload' => $fileupload]);
            // echo ($handle);
            //  header('Location: addGroupOfStudents.php?id=database_updated');
        }
    }
}

if (isset($_POST["classe"], $_POST["debut"], $_POST["fin"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $classe = filter_input(INPUT_POST, "classe");
        $debut = filter_input(INPUT_POST, "debut");
        $fin = filter_input(INPUT_POST, "fin");
        $conn = new PDO('mysql:host=localhost;dbname=attendance', $dbUserName, $dbPassword);
        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {
            $sql = "INSERT INTO `classes`(`id`, `classe`, `debut_cours`, `fin_cours`) VALUES (NULL,'" . $classe . "','" . $debut . "','" . $fin . "')";
            $add = $conn->prepare($sql);
            $add->execute();
            header('Location: addGroupOfStudents.php?id=database_updated');
        }
        mysqli_close($conn);
    }
}
